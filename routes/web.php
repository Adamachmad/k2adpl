<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController as CustomRegisterController;
use App\Http\Controllers\DinasController; // <<< TAMBAHKAN INI

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// =======================================================
// === HALAMAN PUBLIK & AUTENTIKASI ===
// =======================================================

// Route Halaman Utama (Homepage)
Route::get('/', function () {
    $recentReports = App\Models\Report::latest()->take(4)->get();
    return view('welcome', compact('recentReports'));
})->name('home');

// Route untuk Login (menampilkan form)
Route::get('/login', [ReportController::class, 'showLoginForm'])->name('login');
// Route untuk memproses Login (submit form)
Route::post('/login', [ReportController::class, 'login']);
// Route untuk Logout
Route::post('/logout', [ReportController::class, 'logout'])->name('logout');

// Route untuk Registrasi (menampilkan form)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
// Route untuk memproses Registrasi (submit form)
Route::post('/register', [CustomRegisterController::class, 'registerUser'])->name('register.post');


// =======================================================
// === ALUR PEMBUATAN LAPORAN (MULTI-STEP) ===
// Menggunakan middleware 'auth' untuk melindungi rute ini agar hanya bisa diakses user terautentikasi
// =======================================================
Route::middleware(['auth'])->group(function () {
    // Langkah 1: Halaman memilih Jenis Laporan
    Route::get('/laporan/buat', [ReportController::class, 'createStep1'])->name('reports.create');
    Route::post('/laporan/buat/step1', [ReportController::class, 'postStep1'])->name('reports.create.step1.post');

    // Langkah 2: Halaman mengisi Detail Lokasi
    Route::get('/laporan/buat/detail-lokasi', [ReportController::class, 'createStep2'])->name('reports.create.step2');
    Route::post('/laporan/buat/step2', [ReportController::class, 'postStep2'])->name('reports.create.step2.post');

    // Langkah 3: Halaman mengisi Deskripsi & Foto
    Route::get('/laporan/buat/deskripsi', [ReportController::class, 'createStep3'])->name('reports.create.step3');
    Route::post('/laporan/buat/deskripsi', [ReportController::class, 'postStep3'])->name('reports.create.step3.post'); // Aksi POST untuk step 3

    // Langkah 4: Halaman Konfirmasi Laporan
    Route::get('/laporan/buat/konfirmasi', [ReportController::class, 'createStep4'])->name('reports.create.step4');

    // Logika Pengiriman Form FINAL (method POST)
    Route::post('/laporan/kirim', [ReportController::class, 'store'])->name('reports.store');

    // Halaman Sukses setelah mengirim laporan
    Route::get('/laporan/sukses', [ReportController::class, 'success'])->name('reports.success');
});


// =======================================================
// === ALUR MELIHAT LAPORAN ===
// =======================================================

// Halaman untuk melihat semua laporan publik
Route::get('/laporan/publik', [ReportController::class, 'publicIndex'])->name('reports.public');

// Halaman untuk melihat laporan milik pengguna yang sedang login (dilindungi Auth)
Route::get('/laporan-saya', [ReportController::class, 'index'])->name('reports.index')->middleware('auth');

// Halaman untuk menampilkan detail dari satu laporan
// {report} adalah parameter dinamis, misal /laporan/1 atau /laporan/2
Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('reports.show');


// =======================================================
// === HALAMAN EDUKASI ===
// =======================================================

// Halaman utama Edukasi
Route::get('/edukasi', function () {
    return view('education.index'); // Atau [EducationController::class, 'index'] jika ada
})->name('education.index');

// Halaman untuk menampilkan detail artikel edukasi
Route::get('/edukasi/{article}', function ($articleId) {
    // Ini hanyalah contoh data statis. Nanti Anda akan mengambil dari database.
    $articles = [
        1 => ['title' => 'Cara Mengurangi Jejak Karbon di Rumah', 'content' => 'Isi lengkap artikel tentang jejak karbon...', 'image' => 'https://images.unsplash.com/photo-1542601904-45B6A6358354?q=80&w=1470&auto=format&fit=crop'],
        2 => ['title' => 'Pentingnya Daur Ulang untuk Masa Depan', 'content' => 'Isi lengkap artikel tentang daur ulang...', 'image' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=1470&auto=format&fit=crop'],
        3 => ['title' => 'Dampak Perubahan Iklim Global', 'content' => 'Isi lengkap artikel tentang perubahan iklim...', 'image' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?q=80&w=1441&auto=format&fit=crop'],
    ];

    $article = $articles[$articleId] ?? null;

    if (!$article) {
        abort(404, 'Artikel tidak ditemukan.');
    }
    return view('education.show', compact('article'));
})->name('education.show');

// =======================================================
// === HALAMAN ADMINISTRATOR (Dilindungi Middleware 'auth' dan 'admin') ===
// =======================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Pengelolaan Laporan (Admin menyetujui laporan untuk dinas)
    Route::get('/reports/pending-approval', [AdminController::class, 'pendingApprovalReports'])->name('reports.pending_approval');
    Route::post('/reports/{id}/approve', [AdminController::class, 'approveReport'])->name('reports.approve');
    Route::post('/reports/{id}/reject-admin', [AdminController::class, 'rejectReportByAdmin'])->name('reports.reject_admin'); // Jika ada penolakan oleh admin

    // Pengelolaan Edukasi (Admin saja yang bisa)
    Route::get('/education', [AdminController::class, 'educationIndex'])->name('education.index');
    Route::get('/education/create', [AdminController::class, 'createEducation'])->name('education.create');
    Route::post('/education', [AdminController::class, 'storeEducation'])->name('education.store');
    Route::get('/education/{id}/edit', [AdminController::class, 'editEducation'])->name('education.edit');
    Route::put('/education/{id}', [AdminController::class, 'updateEducation'])->name('education.update');
    Route::delete('/education/{id}', [AdminController::class, 'destroyEducation'])->name('education.destroy');
});


// =======================================================
// === HALAMAN DINAS (Dilindungi Middleware 'auth' dan 'dinas') ===
// =======================================================
Route::middleware(['auth', 'dinas'])->prefix('dinas')->name('dinas.')->group(function () {
    Route::get('/dashboard', [DinasController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports/{id}', [DinasController::class, 'showReport'])->name('show.report');
    Route::post('/reports/{id}/update-status', [DinasController::class, 'updateReportStatus'])->name('update_status');
});