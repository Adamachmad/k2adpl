<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController as CustomRegisterController;
use App\Http\Controllers\DinasController;

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
    $recentReports = App\Models\Report::where('status', '!=', 'DRAFT')->latest()->take(4)->get();
    // Menambahkan pengambilan data untuk artikel edukasi
    $recentArticles = App\Models\Education::latest()->take(3)->get(); 
    
    // Mengirim kedua variabel ke view
    return view('welcome', compact('recentReports', 'recentArticles'));
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
    Route::post('/laporan/buat/deskripsi', [ReportController::class, 'postStep3'])->name('reports.create.step3.post');

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

// Halaman untuk melihat laporan milik pengguna yang sedang login
Route::get('/laporan-saya', [ReportController::class, 'index'])->name('reports.index')->middleware('auth');

// Halaman untuk menampilkan detail dari satu laporan
Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('reports.show');


// =======================================================
// === HALAMAN EDUKASI ===
// =======================================================

// Halaman utama Edukasi
Route::get('/edukasi', [EducationController::class, 'index'])->name('education.index');

// Halaman untuk menampilkan detail artikel edukasi
Route::get('/edukasi/{article}', [EducationController::class, 'show'])->name('education.show');

// =======================================================
// === HALAMAN ADMINISTRATOR ===
// =======================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // --- Manajemen Laporan ---
    Route::get('/reports', [AdminController::class, 'allReports'])->name('reports.index');
    Route::get('/reports/pending-approval', [AdminController::class, 'pendingApprovalReports'])->name('reports.pending_approval');
    Route::post('/reports/{id}/approve', [AdminController::class, 'approveReport'])->name('reports.approve');
    Route::post('/reports/{id}/reject-admin', [AdminController::class, 'rejectReportByAdmin'])->name('reports.reject_admin');
    Route::delete('/reports/{report}', [AdminController::class, 'destroyReport'])->name('reports.destroy');

    // --- Manajemen Edukasi ---
    Route::get('/education', [AdminController::class, 'educationIndex'])->name('education.index');
    Route::get('/education/create', [AdminController::class, 'createEducation'])->name('education.create');
    Route::post('/education', [AdminController::class, 'storeEducation'])->name('education.store');
    Route::get('/education/{education}/edit', [AdminController::class, 'editEducation'])->name('education.edit');
    Route::put('/education/{education}', [AdminController::class, 'updateEducation'])->name('education.update');
    Route::delete('/education/{education}', [AdminController::class, 'destroyEducation'])->name('education.destroy');
    
    // --- Manajemen Pengguna ---
    Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // --- Pengaturan Sistem (Contoh) ---
    Route::get('/settings', function() { 
        return "Halaman Pengaturan Sistem Segera Hadir"; 
    })->name('settings.index');

});


// =======================================================
// === HALAMAN DINAS ===
// =======================================================
Route::middleware(['auth', 'dinas'])->prefix('dinas')->name('dinas.')->group(function () {
    Route::get('/dashboard', [DinasController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports/{id}', [DinasController::class, 'showReport'])->name('show.report');
    Route::post('/reports/{id}/update-status', [DinasController::class, 'updateReportStatus'])->name('update_status');
});
