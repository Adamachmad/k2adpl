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

class ReportController extends Controller
{
    /**
     * Menampilkan daftar laporan milik pengguna yang sedang login.
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Mengambil laporan dari database HANYA untuk user yang sedang login.
        // Diurutkan dari yang paling baru dan diberi paginasi 10 item per halaman.
        $reports = Report::where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);

        // Mengirim data laporan ke view 'reports.index'
        return view('reports.index', compact('reports'));
    }

    /**
     * Menampilkan halaman untuk melihat semua laporan publik.
     * @return \Illuminate\View\View
     */
    public function publicIndex(): View
    {
        // Mengambil semua laporan dari database, diurutkan dari yang terbaru, dan diberi paginasi.
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
        // Mencari laporan berdasarkan ID; jika tidak ditemukan, akan otomatis menghasilkan error 404.
        $report = Report::findOrFail($id);

        // Mengirim data laporan yang ditemukan ke view 'reports.show'
        return view('reports.show', compact('report'));
    }

    /**
     * Menampilkan form Langkah 1: Memilih Jenis Laporan.
     * Menghapus data sesi laporan sebelumnya untuk memulai yang baru.
     * @return \Illuminate\View\View
     */
    public function createStep1(): View
    {
        session()->forget('report_data'); // Hapus session lama saat memulai laporan baru
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
        // Redirect jika kategori belum dipilih dari step 1
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
        // Menggabungkan data lokasi baru dengan data yang sudah ada di session
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
        // Redirect jika detail lokasi belum lengkap dari step 2
        if (empty($data['provinsi'])) { // Contoh validasi sederhana
            return redirect()->route('reports.create.step2')->withErrors('Silakan lengkapi detail lokasi terlebih dahulu.');
        }
        return view('reports.create-step-3', compact('data'));
    }

    /**
     * Memproses data Langkah 3 (Deskripsi & Foto) dan mengarahkan ke Langkah 4 (Konfirmasi).
     * Ini adalah metode kunci untuk mengatasi error serialisasi file.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStep3(Request $request): RedirectResponse
    {
        // 1. Validasi input teks dan file
        // 'nullable|array|max:5' berarti field 'photos' bisa kosong,
        // berupa array (untuk multiple files), dan maksimal 5 file.
        // 'photos.*' untuk validasi setiap file dalam array.
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB per file
        ]);

        // 2. Ambil data yang sudah ada dari session
        $data = $request->session()->get('report_data', []);

        // 3. Gabungkan data teks baru ke dalam session data
        $data['title'] = $validatedData['title'];
        $data['description'] = $validatedData['description'];

        // 4. Proses file jika ada: Simpan file ke lokasi sementara dan simpan HANYA PATH-nya ke session
        if ($request->hasFile('photos')) {
            $paths = [];
            foreach ($request->file('photos') as $photo) {
                // Simpan foto ke folder sementara 'storage/app/public/temp-report-photos'
                // Method 'store' akan mengembalikan path relatif dari disk.
                $path = $photo->store('temp-report-photos', 'public');
                $paths[] = $path;
            }
            // Simpan array berisi path string foto ke dalam session
            // Ini PENTING karena objek UploadedFile tidak dapat diserialisasi ke session.
            $data['photo_paths'] = $paths;
        } else {
            // Pastikan photo_paths kosong jika tidak ada foto diupload
            $data['photo_paths'] = [];
        }

        // 5. Simpan semua data yang terkumpul kembali ke session
        $request->session()->put('report_data', $data);

        // 6. Arahkan ke halaman konfirmasi (Langkah 4)
        return redirect()->route('reports.create.step4');
    }

    /**
     * Menampilkan halaman konfirmasi (Langkah 4).
     * Memastikan semua data yang dibutuhkan dari langkah-langkah sebelumnya sudah ada di session.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function createStep4(Request $request): View|RedirectResponse
    {
        $data = $request->session()->get('report_data');
        // Redirect jika data laporan dari langkah-langkah sebelumnya belum lengkap
        if (empty($data['category']) || empty($data['provinsi']) || empty($data['title'])) {
            return redirect()->route('reports.create')->withErrors('Silakan lengkapi semua langkah laporan terlebih dahulu.');
        }
        return view('reports.create-step-4', compact('data'));
    }

    /**
     * Menyimpan laporan baru ke database setelah semua langkah selesai.
     * Ini adalah metode yang akan memindahkan file dari temp ke permanen dan menyimpan data ke DB.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Mengambil semua data laporan yang tersimpan di session
        $reportData = $request->session()->get('report_data');

        // Mengamankan dari kasus sesi habis atau data tidak lengkap
        if (empty($reportData)) {
            return redirect()->route('reports.create')->withErrors('Sesi Anda telah habis, silakan mulai lagi.');
        }

        // Validasi terakhir, misalnya checkbox persetujuan syarat & ketentuan.
        // 'accepted' memastikan checkbox dicentang.
        $request->validate(['terms' => 'required|accepted']);

        $finalPhotoPaths = [];
        // Memproses dan memindahkan foto dari folder sementara ke folder permanen
        if (!empty($reportData['photo_paths'])) {
            foreach ($reportData['photo_paths'] as $tempPath) {
                // Memastikan file benar-benar ada di penyimpanan sementara sebelum dipindahkan
                if (Storage::disk('public')->exists($tempPath)) {
                    // Mendefinisikan path tujuan akhir (folder 'report-photos')
                    $finalPath = str_replace('temp-report-photos/', 'report-photos/', $tempPath);
                    // Memindahkan file dari lokasi sementara ke lokasi permanen
                    Storage::disk('public')->move($tempPath, $finalPath);
                    $finalPhotoPaths[] = $finalPath; // Menyimpan path final
                }
            }
        }

        // Membuat entri laporan baru di database menggunakan Eloquent ORM
        Report::create([
            'user_id' => Auth::id(), // Mengambil ID pengguna yang sedang login
            'judul' => $reportData['title'],
            'deskripsi' => $reportData['description'],
            // Menggabungkan semua detail lokasi menjadi satu string untuk kolom 'lokasi'
            'lokasi' => "{$reportData['alamat']}, {$reportData['desa']}, {$reportData['kecamatan']}, {$reportData['kabupaten']}, {$reportData['provinsi']}",
            'fotoBukti' => json_encode($finalPhotoPaths), // Menyimpan array path foto sebagai string JSON
            'status' => 'DITUNDA', // Menetapkan status awal laporan
            'category' => $reportData['category'], // Menyimpan kategori laporan
        ]);

        // Menghapus data laporan dari session setelah berhasil disimpan ke database
        $request->session()->forget('report_data');

        // Mengarahkan pengguna ke halaman sukses dengan pesan status
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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect pengguna ke halaman yang dimaksud atau halaman 'home'
            return redirect()->intended(route('home'));
        }

        // Jika login gagal, lemparkan exception dengan pesan error
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email'); // Hanya menyertakan input email yang salah
    }

    /**
     * Menangani proses logout pengguna.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); // Mengakhiri sesi autentikasi pengguna
        $request->session()->invalidate(); // Menghapus semua data sesi
        $request->session()->regenerateToken(); // Meregenerasi token CSRF baru
        return redirect(route('home')); // Mengarahkan kembali ke halaman utama setelah logout
    }
}