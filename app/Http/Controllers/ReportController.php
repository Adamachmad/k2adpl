<?php

namespace App\Http\Controllers;

use App\Models\Report; // Pastikan Model Report di-import
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // Import facade untuk autentikasi

class ReportController extends Controller
{
    /**
     * Menampilkan daftar laporan milik pengguna yang sedang login.
     * (Untuk halaman "Laporan Saya")
     */
    public function index(): View
    {
        // Mengambil laporan dari database HANYA untuk user yang sedang login.
        // Diurutkan dari yang paling baru.
        $reports = Report::where('user_id', Auth::id())->latest()->paginate(10);

        return view('reports.index', compact('reports'));
    }

    /**
     * Menampilkan semua laporan untuk publik.
     * (Untuk halaman "Laporan Publik")
     */
    public function publicIndex(): View
    {
        // Mengambil semua laporan dari database, diurutkan dari yang paling baru.
        $reports = Report::latest()->paginate(10);

        return view('reports.public', compact('reports'));
    }

    /**
     * Menampilkan halaman detail untuk laporan tertentu dari database.
     */
    public function show($id): View
    {
        // Mengambil satu laporan dari database berdasarkan ID.
        // findOrFail akan otomatis menampilkan halaman 404 jika ID tidak ditemukan.
        $report = Report::findOrFail($id);

        return view('reports.show', compact('report'));
    }

    /**
     * Menyimpan laporan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'photos' => 'required|array|min:1|max:5', // Minimal 1, maksimal 5 foto
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Maksimal 5MB per foto
            'terms' => 'required',
        ]);

        // 2. Proses unggahan foto
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // Simpan foto di folder 'storage/app/public/report-photos'
                $path = $photo->store('report-photos', 'public');
                $photoPaths[] = $path;
            }
        }

        // 3. Simpan data laporan ke dalam tabel 'reports'
        Report::create([
            'user_id' => Auth::id(), // Mengambil ID user yang sedang login
            'judul' => $validatedData['title'],
            'deskripsi' => $validatedData['description'],
            'lokasi' => $validatedData['location'],
            // fotoBukti disimpan sebagai JSON yang berisi array path semua foto
            'fotoBukti' => json_encode($photoPaths), 
            'status' => 'DITUNDA', // Status awal saat laporan dibuat
        ]);

        // 4. Arahkan pengguna ke halaman sukses dengan pesan
        return redirect()->route('reports.success')->with('status', 'Laporan berhasil dikirim!');
    }
    
    // Metode untuk menampilkan form multi-langkah (sudah tidak memerlukan logika kompleks)
    public function createStep1() { return view('reports.create'); }
    public function createStep2(Request $request) { return view('reports.create-step-2', ['data' => $request->all()]); }
    public function createStep3(Request $request) { return view('reports.create-step-3', ['data' => $request->all()]); }
    public function createStep4(Request $request) { return view('reports.create-step-4', ['data' => $request->all()]); }
}