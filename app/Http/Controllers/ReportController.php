<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman detail untuk laporan tertentu dari database.
     */
    public function show($id): View
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    /**
     * Menangani logika penyimpanan laporan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // Mengambil data yang sudah terkumpul dari session
        $reportData = $request->session()->get('report_data');

        // Validasi terakhir sebelum menyimpan
        $request->validate(['terms' => 'required']);

        $finalPhotoPaths = [];
        // Pindahkan foto dari folder temporary ke folder permanen
        if (!empty($reportData['photo_paths'])) {
            foreach ($reportData['photo_paths'] as $tempPath) {
                if (Storage::disk('public')->exists($tempPath)) {
                    $finalPath = str_replace('temp-report-photos', 'report-photos', $tempPath);
                    Storage::disk('public')->move($tempPath, $finalPath);
                    $finalPhotoPaths[] = $finalPath;
                }
            }
        }

        // Simpan semua data ke database menggunakan Model Report
        Report::create([
            'user_id' => Auth::id(),
            'judul' => $reportData['title'],
            'deskripsi' => $reportData['description'],
            'lokasi' => "{$reportData['alamat']}, {$reportData['desa']}, {$reportData['kecamatan']}, {$reportData['kabupaten']}, {$reportData['provinsi']}",
            'fotoBukti' => json_encode($finalPhotoPaths),
            'status' => 'DITUNDA',
        ]);

        // Hapus data dari session setelah berhasil disimpan
        $request->session()->forget('report_data');

        return redirect()->route('reports.success')->with('status', 'Laporan berhasil dikirim!');
    }
    
    // --- Metode untuk Alur Form Multi-Langkah ---

    /** Menampilkan form Langkah 1 (Pilih Kategori). */
    public function createStep1(): View
    {
        session()->forget('report_data'); // Hapus session lama untuk memulai laporan baru
        return view('reports.create');
    }

    /** Memproses data Langkah 1 dan mengarahkan ke Langkah 2. */
    public function postStep1(Request $request): RedirectResponse
    {
        $validatedData = $request->validate(['category' => 'required|string']);
        $request->session()->put('report_data', $validatedData);
        return redirect()->route('reports.create.step2');
    }

    /** Menampilkan form Langkah 2 (Detail Lokasi). */
    public function createStep2(Request $request): View
    {
        $data = $request->session()->get('report_data', []);
        return view('reports.create-step-2', compact('data'));
    }

    /** Memproses data Langkah 2 dan mengarahkan ke Langkah 3. */
    public function postStep2(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'provinsi' => 'required|string', 'kabupaten' => 'required|string',
            'kecamatan' => 'required|string', 'desa' => 'required|string',
            'alamat' => 'required|string',
        ]);
        $data = $request->session()->get('report_data', []);
        $data = array_merge($data, $validatedData);
        $request->session()->put('report_data', $data);
        return redirect()->route('reports.create.step3');
    }

    /** Menampilkan form Langkah 3 (Deskripsi & Foto). */
    public function createStep3(Request $request): View
    {
        $data = $request->session()->get('report_data');
        return view('reports.create-step-3', compact('data'));
    }

    /** Memproses data Langkah 3 dan mengarahkan ke Langkah 4 (Konfirmasi). */
    public function postStep3(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        
        $data = $request->session()->get('report_data', []);
        $data = array_merge($data, $validatedData);

        if ($request->hasFile('photos')) {
            $paths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('temp-report-photos', 'public');
                $paths[] = $path;
            }
            $data['photo_paths'] = $paths;
        }
        
        $request->session()->put('report_data', $data);
        return redirect()->route('reports.create.step4');
    }

    /** Menampilkan halaman konfirmasi (Langkah 4). */
    public function createStep4(Request $request): View|RedirectResponse
    {
        $data = $request->session()->get('report_data');
        if (empty($data['category']) || empty($data['title'])) {
            return redirect()->route('reports.create');
        }
        return view('reports.create-step-4', compact('data'));
    }
}