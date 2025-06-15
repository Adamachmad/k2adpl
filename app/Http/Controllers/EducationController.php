<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    // Properti untuk menyimpan "database palsu"
    private $articles = [
        1 => [
            'id' => 1, 'title' => 'Cara Mengurangi Jejak Karbon di Rumah', 'category' => 'Gaya Hidup Hijau', 'reading_time' => '5 menit',
            'author' => 'Dr. Sari Wijaya', 'publish_date' => '15 Desember 2024',
            'image_url' => 'https://images.unsplash.com/photo-1542601904-45B6A6358354?q=80&w=1470&auto=format&fit=crop',
            'content' => 'Mengurangi jejak karbon adalah salah satu cara paling efektif untuk melawan perubahan iklim. Langkah-langkah sederhana di rumah, seperti menghemat listrik, mengurangi konsumsi daging, dan memilih produk lokal dapat memberikan dampak yang besar. Artikel ini akan membahas secara mendalam langkah-langkah praktis yang bisa Anda terapkan sehari-hari.'
        ],
        2 => [
            'id' => 2, 'title' => 'Pentingnya Daur Ulang untuk Masa Depan', 'category' => 'Daur Ulang', 'reading_time' => '7 menit',
            'author' => 'Prof. Ahmad Rizki', 'publish_date' => '12 Desember 2024',
            'image_url' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=1470&auto=format&fit=crop',
            'content' => 'Daur ulang bukan hanya tentang memilah sampah. Ini adalah industri besar yang membantu menghemat sumber daya alam, mengurangi polusi, dan menciptakan lapangan kerja. Memahami proses dan pentingnya daur ulang akan mengubah cara kita memandang sampah.'
        ],
        3 => [
            'id' => 3, 'title' => 'Dampak Perubahan Iklim Global', 'category' => 'Perubahan Iklim', 'reading_time' => '10 menit',
            'author' => 'Dr. Maya Indira', 'publish_date' => '10 Desember 2024',
            'image_url' => 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?q=80&w=1441&auto=format&fit=crop',
            'content' => 'Kenaikan suhu global, pencairan es di kutub, dan cuaca ekstrem adalah beberapa manifestasi dari perubahan iklim. Artikel ini menyajikan analisis mendalam tentang bagaimana perubahan iklim mempengaruhi ekosistem dan kehidupan manusia di seluruh dunia.'
        ],
    ];

    /**
     * Menampilkan halaman utama edukasi.
     */
    public function index(): View
    {
        $articles = $this->articles;
        return view('education.index', compact('articles'));
    }

    /**
     * Menampilkan halaman detail untuk artikel edukasi tertentu.
     */
    public function show($id): View
    {
        $article = $this->articles[$id] ?? null;
        abort_if(!$article, 404);

        return view('education.show', compact('article'));
    }
}