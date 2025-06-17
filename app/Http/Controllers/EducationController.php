<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    /**
     * Menampilkan halaman utama Edukasi dengan daftar semua artikel.
     */
    public function index(): View
    {
        // Mengambil semua artikel dari database, diurutkan dari yang terbaru,
        // dan ditampilkan per halaman (paginate)
        $articles = Education::latest()->paginate(9); // 9 artikel per halaman

        return view('education.index', compact('articles'));
    }

    /**
     * Menampilkan halaman detail dari satu artikel edukasi.
     */
    public function show(Education $article): View
    {
        // Menggunakan Route Model Binding untuk mengambil artikel secara otomatis
        return view('education.show', compact('article'));
    }
}
