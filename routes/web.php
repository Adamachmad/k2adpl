<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EducationController;

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
    return view('welcome');
})->name('home');

// Route untuk Autentikasi
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


// =======================================================
// === ALUR PEMBUATAN LAPORAN (MULTI-STEP) ===
// =======================================================

// Langkah 1: Halaman memilih Jenis Laporan
Route::get('/laporan/buat', function () {
    return view('reports.create');
})->name('reports.create');

// Langkah 2: Halaman mengisi Detail Lokasi
Route::get('/laporan/buat/detail-lokasi', function () {
    return view('reports.create-step-2');
})->name('reports.create.step2');

// Langkah 3: Halaman mengisi Deskripsi & Foto
Route::get('/laporan/buat/deskripsi', function () {
    return view('reports.create-step-3');
})->name('reports.create.step3');

// Langkah 4: Halaman Konfirmasi Laporan
Route::get('/laporan/buat/konfirmasi', function () {
    return view('reports.create-step-4');
})->name('reports.create.step4');

// Logika Pengiriman Form (method POST)
Route::post('/laporan/kirim', function () {
    // Logika backend untuk menyimpan data akan ada di sini.
    // Untuk sekarang, kita arahkan ke halaman sukses.
    return redirect()->route('reports.success');
})->name('reports.store');

// Halaman Sukses setelah mengirim laporan
Route::get('/laporan/sukses', function () {
    return view('reports.success');
})->name('reports.success');


// =======================================================
// === ALUR MELIHAT LAPORAN ===
// =======================================================

// Halaman untuk melihat semua laporan publik
Route::get('/laporan/publik', function () {
    return view('reports.public');
})->name('reports.public');

// Halaman untuk melihat laporan milik pengguna yang sedang login
Route::get('/laporan-saya', function () {
    return view('reports.index');
})->name('reports.index');

// laporan

Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('reports.show');
// edukasi
Route::get('/edukasi/{article}', [EducationController::class, 'show'])->name('education.show');


// =======================================================
// === HALAMAN LAINNYA ===
// =======================================================

// Halaman Edukasi
Route::get('/edukasi', function () {
    return view('education.index');
})->name('education.index');