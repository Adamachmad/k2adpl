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

// PERBAIKAN DI SINI: Mengembalikan ke controller
// Memproses data dari form login
Route::post('/login', [LoginController::class, 'login']);

// Menampilkan halaman form registrasi
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

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