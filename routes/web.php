<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EducationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route Halaman Utama (Homepage)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =======================================================
// === HALAMAN PUBLIK & AUTENTIKASI ===
// =======================================================

// Menampilkan halaman form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Memproses data dari form login
Route::post('/login', [LoginController::class, 'login']);
// Memproses logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Menampilkan halaman form registrasi
Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');




// =======================================================
// === ALUR PEMBUATAN LAPORAN (MULTI-STEP DINAMIS) ===
// =======================================================

// Langkah 1: Menampilkan & Memproses form awal
Route::get('/laporan/buat', [ReportController::class, 'createStep1'])->name('reports.create');
Route::post('/laporan/buat', [ReportController::class, 'postStep1'])->name('reports.create.step1.post');

// Langkah 2: Menampilkan & Memproses form detail lokasi
Route::get('/laporan/buat/detail-lokasi', [ReportController::class, 'createStep2'])->name('reports.create.step2');
Route::post('/laporan/buat/detail-lokasi', [ReportController::class, 'postStep2'])->name('reports.create.step2.post');

// Langkah 3: Menampilkan & Memproses form deskripsi & foto
Route::get('/laporan/buat/deskripsi', [ReportController::class, 'createStep3'])->name('reports.create.step3');
Route::post('/laporan/buat/deskripsi', [ReportController::class, 'postStep3'])->name('reports.create.step3.post');

// Langkah 4: Menampilkan halaman konfirmasi
Route::get('/laporan/buat/konfirmasi', [ReportController::class, 'createStep4'])->name('reports.create.step4');

// Logika untuk menyimpan laporan ke database
Route::post('/laporan/kirim', [ReportController::class, 'store'])->name('reports.store');

// Halaman sukses setelah laporan terkirim
Route::get('/laporan/sukses', function () {
    return view('reports.success');
})->name('reports.success');

// ... (Sisa route Anda)
// =======================================================
// === ALUR MELIHAT LAPORAN & EDUKASI ===
// =======================================================
Route::get('/laporan/publik', [ReportController::class, 'publicIndex'])->name('reports.public');
Route::get('/laporan-saya', [ReportController::class, 'index'])->name('reports.index')->middleware('auth');
Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('reports.show')->middleware('auth');

Route::get('/edukasi', [EducationController::class, 'index'])->name('education.index');
Route::get('/edukasi/{article}', [EducationController::class, 'show'])->name('education.show');


// =======================================================
// === HALAMAN DASHBOARD BERDASARKAN ROLE ===
// =======================================================
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth'); // Nanti bisa ditambahkan middleware role admin

Route::get('/dinas/dashboard', function () {
    return view('dinas.dashboard');
})->name('dinas.dashboard')->middleware('auth'); // Nanti bisa ditambahkan middleware role dinas