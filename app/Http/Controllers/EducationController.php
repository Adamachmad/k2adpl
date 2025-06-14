<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    /**
     * Menampilkan halaman detail untuk artikel edukasi tertentu.
     */
    public function show($id): View
    {
        // Membuat "database palsu" untuk artikel edukasi kita.
        $articles = [
            1 => [
                'id' => 1,
                'title' => 'Cara Mengurangi Jejak Karbon di Rumah',
                'category' => 'Gaya Hidup Hijau',
                'reading_time' => '5 menit',
                'author' => 'Dr. Sari Wijaya',
                'publish_date' => '15 Desember 2024',
                'image_url' => 'https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/b9ee3b6bfeae0dd229034965a4680edcb6dd5f71?placeholderIfAbsent=true&format=webp&width=800',
                'content' => 'Mengurangi jejak karbon adalah salah satu cara paling efektif untuk melawan perubahan iklim. Langkah-langkah sederhana di rumah, seperti menghemat listrik, mengurangi konsumsi daging, dan memilih produk lokal dapat memberikan dampak yang besar. Artikel ini akan membahas secara mendalam langkah-langkah praktis yang bisa Anda terapkan sehari-hari.'
            ],
            2 => [
                'id' => 2,
                'title' => 'Pentingnya Daur Ulang untuk Masa Depan',
                'category' => 'Daur Ulang',
                'reading_time' => '7 menit',
                'author' => 'Prof. Ahmad Rizki',
                'publish_date' => '12 Desember 2024',
                'image_url' => 'https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/dd525ad9997b2cc53899fb0dbb804c480379cb08?placeholderIfAbsent=true&format=webp&width=800',
                'content' => 'Daur ulang bukan hanya tentang memilah sampah. Ini adalah industri besar yang membantu menghemat sumber daya alam, mengurangi polusi, dan menciptakan lapangan kerja. Memahami proses dan pentingnya daur ulang akan mengubah cara kita memandang sampah dan mendorong kita untuk berpartisipasi lebih aktif.'
            ],
            3 => [
                'id' => 3,
                'title' => 'Dampak Perubahan Iklim Global',
                'category' => 'Perubahan Iklim',
                'reading_time' => '10 menit',
                'author' => 'Dr. Maya Indira',
                'publish_date' => '10 Desember 2024',
                'image_url' => 'https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/76dfbd70b3dd9ea8ae478bb1efebba26f2de795e?placeholderIfAbsent=true&format=webp&width=800',
                'content' => 'Kenaikan suhu global, pencairan es di kutub, dan cuaca ekstrem adalah beberapa manifestasi dari perubahan iklim. Artikel ini menyajikan analisis mendalam tentang bagaimana perubahan iklim mempengaruhi ekosistem, ketahanan pangan, dan kehidupan manusia di seluruh dunia, serta apa saja solusi yang sedang diupayakan.'
            ],
        ];

        // Cari artikel berdasarkan ID yang diklik
        $article = $articles[$id] ?? null;
        if (!$article) {
            abort(404); // Tampilkan halaman 404 jika artikel tidak ditemukan
        }

        // Kirim data artikel yang ditemukan ke view 'education.show'
        return view('education.show', compact('article'));
    }
}