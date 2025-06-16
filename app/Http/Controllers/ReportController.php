<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException; // Pastikan ini di-import
use Illuminate\Support\Facades\Hash; // PASTIKAN INI DI-IMPORT UNTUK HASH::CHECK

class ReportController extends Controller
{
    /**
     * Menampilkan daftar laporan milik pengguna yang sedang login.
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $reports = Report::where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);
        return view('reports.index', compact('reports'));
    }

    /**
     * Menampilkan halaman untuk melihat semua laporan publik.
     * @return \Illuminate\View\View
     */
    public function publicIndex(): View
    {
        $reports = Report::latest()->paginate(10);
        return view('reports.public', compact('reports'));
    }

    /**
     * Menampilkan halaman detail untuk laporan tertentu.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    /**
     * Menampilkan form Langkah 1: Memilih Jenis Laporan.
     * Menghapus data sesi laporan sebelumnya untuk memulai yang baru.
     * @return \Illuminate\View\View
     */
    public function createStep1(): View
    {
        session()->forget('report_data');
        return view('reports.create');
    }

    /**
     * Memproses data Langkah 1 (jenis laporan) dan mengarahkan ke Langkah 2.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStep1(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'category' => 'required|string',
        ]);
        $request->session()->put('report_data', $validatedData);
        return redirect()->route('reports.create.step2');
    }

    /**
     * Menampilkan form Langkah 2: Mengisi Detail Lokasi.
     * Memastikan data kategori dari Langkah 1 sudah ada.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function createStep2(Request $request): View
    {
        $data = $request->session()->get('report_data', []);
        if (empty($data['category'])) {
            return redirect()->route('reports.create')->withErrors('Silakan pilih jenis laporan terlebih dahulu.');
        }
        return view('reports.create-step-2', compact('data'));
    }

    /**
     * Memproses data Langkah 2 (detail lokasi) dan mengarahkan ke Langkah 3.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStep2(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'alamat' => 'required|string',
        ]);
        $data = $request->session()->get('report_data', []);
        $data = array_merge($data, $validatedData);
        $request->session()->put('report_data', $data);
        return redirect()->route('reports.create.step3');
    }

    /**
     * Menampilkan form Langkah 3: Mengisi Deskripsi & Foto.
     * Memastikan data lokasi dari Langkah 2 sudah ada.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function createStep3(Request $request): View
    {
        $data = $request->session()->get('report_data');
        if (empty($data['provinsi'])) {
            return redirect()->route('reports.create.step2')->withErrors('Silakan lengkapi detail lokasi terlebih dahulu.');
        }
        return view('reports.create-step-3', compact('data'));
    }

    /**
     * Memproses data Langkah 3 (Deskripsi & Foto) dan mengarahkan ke Langkah 4 (Konfirmasi).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStep3(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->session()->get('report_data', []);
        $data['title'] = $validatedData['title'];
        $data['description'] = $validatedData['description'];

        if ($request->hasFile('photos')) {
            $paths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('temp-report-photos', 'public');
                $paths[] = $path;
            }
            $data['photo_paths'] = $paths;
        } else {
            $data['photo_paths'] = [];
        }

        $request->session()->put('report_data', $data);
        return redirect()->route('reports.create.step4');
    }

    /**
     * Menampilkan halaman konfirmasi (Langkah 4).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function createStep4(Request $request): View|RedirectResponse
    {
        $data = $request->session()->get('report_data');
        if (empty($data['category']) || empty($data['provinsi']) || empty($data['title'])) {
            return redirect()->route('reports.create')->withErrors('Silakan lengkapi semua langkah laporan terlebih dahulu.');
        }
        return view('reports.create-step-4', compact('data'));
    }

    /**
     * Menyimpan laporan baru ke database setelah semua langkah selesai.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $reportData = $request->session()->get('report_data');

        if (empty($reportData)) {
            return redirect()->route('reports.create')->withErrors('Sesi Anda telah habis, silakan mulai lagi.');
        }

        $request->validate(['terms' => 'required|accepted']);

        $finalPhotoPaths = [];
        if (!empty($reportData['photo_paths'])) {
            foreach ($reportData['photo_paths'] as $tempPath) {
                if (Storage::disk('public')->exists($tempPath)) {
                    $finalPath = str_replace('temp-report-photos/', 'report-photos/', $tempPath);
                    Storage::disk('public')->move($tempPath, $finalPath);
                    $finalPhotoPaths[] = $finalPath;
                }
            }
        }

        Report::create([
            'user_id' => Auth::id(),
            'judul' => $reportData['title'],
            'deskripsi' => $reportData['description'],
            'lokasi' => "{$reportData['alamat']}, {$reportData['desa']}, {$reportData['kecamatan']}, {$reportData['kabupaten']}, {$reportData['provinsi']}",
            'fotoBukti' => json_encode($finalPhotoPaths),
            'status' => 'DITUNDA',
            'category' => $reportData['category'],
        ]);

        $request->session()->forget('report_data');

        return redirect()->route('reports.success')->with('status', 'Laporan berhasil dikirim!');
    }

    /**
     * Menampilkan halaman sukses setelah laporan dikirim.
     * @return \Illuminate\View\View
     */
    public function success(): View
    {
        return view('reports.success');
    }

    /**
     * Menampilkan form login.
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani percobaan login pengguna.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        // Logika login yang menangani hashing secara manual, menghindari InvalidCastException
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Verifikasi password secara manual karena 'hashed' cast di model dihilangkan/bermasalah
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->has('remember')); // Login user, dengan "ingat saya" jika dicentang
            $request->session()->regenerate();

            // --- LOGIKA REDIRECT BERDASARKAN ROLE ---
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'dinas') {
                return redirect()->intended(route('dinas.dashboard'));
            } else { // 'user' atau role lainnya
                return redirect()->intended(route('home'));
            }
            // --- AKHIR LOGIKA REDIRECT ---
        }

        // Jika login gagal, lemparkan exception dengan pesan error
        // Ini adalah perbaikan untuk "Call to undefined method Illuminate\Validation\ValidationException::onlyInput()"
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ]);
    }

    /**
     * Menangani proses logout pengguna.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }
}