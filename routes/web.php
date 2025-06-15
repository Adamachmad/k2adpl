<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; // Pastikan ini ada
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
Route::post('/login', function () {
    return 'Metode POST berhasil dipanggil!';
});

// Menampilkan halaman form registrasi
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Memproses data dari form registrasi (persiapan untuk nanti)
// Route::post('/register', [RegisterController::class, 'register']);

// Route untuk logout (persiapan untuk nanti)
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =======================================================
// === ALUR PEMBUATAN LAPORAN ===
// =======================================================
Route::get('/laporan/buat', [ReportController::class, 'createStep1'])->name('reports.create');
Route::get('/laporan/buat/detail-lokasi', [ReportController::class, 'createStep2'])->name('reports.create.step2');
Route::get('/laporan/buat/deskripsi', [ReportController::class, 'createStep3'])->name('reports.create.step3');
Route::get('/laporan/buat/konfirmasi', [ReportController::class, 'createStep4'])->name('reports.create.step4');
Route::post('/laporan/kirim', [ReportController::class, 'store'])->name('reports.store');
Route::get('/laporan/sukses', function () { return view('reports.success'); })->name('reports.success');


// =======================================================
// === ALUR MELIHAT LAPORAN & EDUKASI ===
// =======================================================
Route::get('/laporan/publik', [ReportController::class, 'publicIndex'])->name('reports.public');
Route::get('/laporan-saya', [ReportController::class, 'index'])->name('reports.index');
Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('reports.show');

Route::get('/edukasi', function () { return view('education.index'); })->name('education.index');
Route::get('/edukasi/{article}', [EducationController::class, 'show'])->name('education.show');