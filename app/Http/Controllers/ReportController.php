<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        // Melindungi semua metode di controller ini agar hanya bisa diakses oleh user yang sudah login
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar laporan milik pengguna yang sedang login.
     */
    public function index(): View
    {
        $reports = Report::where('user_id', Auth::id())->latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }

    /**
     * Menampilkan semua laporan untuk publik.
     * (Middleware 'auth' tidak diterapkan di sini jika ingin semua orang bisa lihat)
     */
    public function publicIndex(): View
    {
        $reports = Report::latest()->paginate(10);
        return view('reports.public', compact('reports'));
    }

    /**
     * Menampilkan halaman detail untuk laporan tertentu dari database.
     */
    public function show($id): View
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }
    
    /**
     * Menampilkan form Langkah 1.
     */
    public function createStep1(): View
    {
        session()->forget('report_data'); // Hapus session lama saat memulai laporan baru
        return view('reports.create');
    }

    /**
     * Memproses data Langkah 1 dan menampilkan form Langkah 2.
     */
    public function postStep1(Request $request): RedirectResponse
    {
        $validatedData = $request->validate(['category' => 'required|string']);
        $request->session()->put('report_data', $validatedData);
        return redirect()->route('reports.create.step2');
    }

    /**
     * Menampilkan form Langkah 2.
     */
    public function createStep2(Request $request): View
    {
        $data = $request->session()->get('report_data');
        return view('reports.create-step-2', compact('data'));
    }

    /**
     * Memproses data Langkah 2 dan menampilkan form Langkah 3.
     */
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

    /**
     * Menampilkan form Langkah 3.
     */
    public function createStep3(Request $request): View
    {
        $data = $request->session()->get('report_data');
        return view('reports.create-step-3', compact('data'));
    }

    /**
     * Memproses data Langkah 3 dan menampilkan form Langkah 4 (Konfirmasi).
     */
    public function postStep3(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', 'description' => 'required|string',
        ]);
        
        $data = $request->session()->get('report_data', []);
        $data = array_merge($data, $validatedData);

        // Menangani file upload dan menyimpannya sementara di session
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

    /**
     * Menampilkan halaman konfirmasi (Langkah 4).
     */
    public function createStep4(Request $request): View
    {
        $data = $request->session()->get('report_data');
        if (!$data) {
            return redirect()->route('reports.create');
        }
        return view('reports.create-step-4', compact('data'));
    }

    /**
     * Menyimpan laporan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $reportData = $request->session()->get('report_data');
        
        // Validasi terakhir
        $request->validate(['terms' => 'required']);

        // Pindahkan foto dari folder temporary ke folder permanen
        // (Ini adalah contoh sederhana, bisa dibuat lebih canggih)
        $finalPhotoPaths = $reportData['photo_paths'] ?? [];

        Report::create([
            'user_id' => Auth::id(),
            'judul' => $reportData['title'],
            'deskripsi' => $reportData['description'],
            'lokasi' => "{$reportData['alamat']}, {$reportData['desa']}, {$reportData['kecamatan']}, {$reportData['kabupaten']}, {$reportData['provinsi']}",
            'fotoBukti' => json_encode($finalPhotoPaths), 
            'status' => 'DITUNDA',
        ]);

        $request->session()->forget('report_data');

        return redirect()->route('reports.success')->with('status', 'Laporan berhasil dikirim!');
    }
}