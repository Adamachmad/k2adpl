<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ReportController extends Controller
{
    // ... SEMUA FUNGSI LAIN DARI KODE ASLI ANDA TETAP SAMA ...
    public function index(): View
    {
        $reports = Report::where('user_id', Auth::id())->latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }
    public function publicIndex(): View
    {
        $reports = Report::latest()->where('status', '!=', 'DRAFT')->paginate(10);
        return view('reports.public', compact('reports'));
    }
    public function show($id): View
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }
    public function success(): View
    {
        return view('reports.success');
    }
    public function showLoginForm(): View
    {
        return view('auth.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'dinas') {
                return redirect()->intended(route('dinas.dashboard'));
            } else {
                return redirect()->intended(route('home'));
            }
        }
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ]);
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }

    // =======================================================
    // === ALUR PEMBUATAN LAPORAN (LOGIKA DRAFT & PERBAIKAN) ===
    // =======================================================

    public function createStep1(): View
    {
        session()->forget('draft_report_id');
        return view('reports.create');
    }

    public function postStep1(Request $request): RedirectResponse
    {
        $validatedData = $request->validate(['category' => 'required|string']);
        $draftReport = Report::create([
            'user_id' => Auth::id(),
            'category' => $validatedData['category'],
        ]);
        session(['draft_report_id' => $draftReport->id]);
        return redirect()->route('reports.create.step2');
    }

    public function createStep2(Request $request): View
    {
        if (!session()->has('draft_report_id')) {
            return redirect()->route('reports.create');
        }
        $report = Report::findOrFail(session('draft_report_id'));
        return view('reports.create-step-2', ['data' => $report->toArray()]);
    }

    public function postStep2(Request $request): RedirectResponse
    {
        if (!session()->has('draft_report_id')) { return redirect()->route('reports.create'); }
        $validatedData = $request->validate([
            'provinsi' => 'required|string', 'kabupaten' => 'required|string',
            'kecamatan' => 'required|string', 'desa' => 'required|string',
            'alamat' => 'required|string',
        ]);
        $report = Report::findOrFail(session('draft_report_id'));
        
        // Cukup simpan string lokasi yang sudah digabung
        $report->update([
            'lokasi' => "{$validatedData['alamat']}, {$validatedData['desa']}, {$validatedData['kecamatan']}, {$validatedData['kabupaten']}, {$validatedData['provinsi']}",
        ]);
        return redirect()->route('reports.create.step3');
    }

    public function createStep3(Request $request): View
    {
        if (!session()->has('draft_report_id')) { return redirect()->route('reports.create'); }
        $report = Report::findOrFail(session('draft_report_id'));
        return view('reports.create-step-3', ['data' => $report->toArray()]);
    }

    public function postStep3(Request $request): RedirectResponse
    {
        if (!session()->has('draft_report_id')) { return redirect()->route('reports.create'); }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array|max:5', 'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        $report = Report::findOrFail(session('draft_report_id'));
        $updateData = [
            'judul' => $validatedData['title'],
            'deskripsi' => $validatedData['description'],
        ];
        if ($request->hasFile('photos')) {
            if (is_array($report->fotoBukti)) {
                foreach ($report->fotoBukti as $oldPhoto) Storage::disk('public')->delete($oldPhoto);
            }
            $paths = [];
            foreach ($request->file('photos') as $photo) {
                $paths[] = $photo->store('report-photos', 'public');
            }
            $updateData['fotoBukti'] = $paths;
        }
        $report->update($updateData);
        return redirect()->route('reports.create.step4');
    }
    
    /**
     * LANGKAH 4: Menampilkan halaman konfirmasi dari data final di database.
     */
    public function createStep4(Request $request): View
    {
        if (!session()->has('draft_report_id')) {
            return redirect()->route('reports.create')->withErrors('Sesi laporan tidak ditemukan.');
        }
        $report = Report::findOrFail(session('draft_report_id'));
        
        // Mengubah model menjadi array
        $data = $report->toArray();

        // "Menerjemahkan" nama kolom database ke nama yang diharapkan oleh view
        $data['title'] = $report->judul;
        $data['description'] = $report->deskripsi;
        $data['photo_paths'] = $report->fotoBukti;
        
        // --- INI PERBAIKAN UTAMA UNTUK LOKASI ---
        // Memecah kembali string 'lokasi' menjadi komponen-komponennya
        $lokasiParts = explode(', ', $report->lokasi ?? '');
        $data['alamat']    = $lokasiParts[0] ?? '';
        $data['desa']      = $lokasiParts[1] ?? '';
        $data['kecamatan'] = $lokasiParts[2] ?? '';
        $data['kabupaten'] = $lokasiParts[3] ?? '';
        $data['provinsi']  = $lokasiParts[4] ?? '';
        // --- AKHIR PERBAIKAN ---

        return view('reports.create-step-4', compact('data'));
    }

    /**
     * PROSES FINAL: Mengubah status laporan dari DRAFT menjadi DITUNDA.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!session()->has('draft_report_id')) {
            return redirect()->route('reports.create')->withErrors('Sesi Anda telah habis, silakan mulai lagi.');
        }
        $request->validate(['terms' => 'required|accepted']);
        $report = Report::findOrFail(session('draft_report_id'));
        $report->status = 'DITUNDA';
        $report->save();
        session()->forget('draft_report_id');
        return redirect()->route('reports.success')->with('status', 'Laporan berhasil dikirim!');
    }
}
