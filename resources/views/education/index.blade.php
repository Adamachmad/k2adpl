@extends('layouts.app')

@section('title', 'Pusat Edukasi - EcoWatch')
@section('description', 'Tingkatkan pengetahuan Anda tentang isu lingkungan, gaya hidup berkelanjutan, dan cara berkontribusi untuk bumi yang lebih baik.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Pusat Edukasi Lingkungan</h1>
            <p class="page-subtitle-alt">Temukan artikel, panduan, dan berita terbaru untuk menginspirasi aksi peduli lingkungan Anda.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <section class="featured-article-section">
                <a href="#" class="featured-article-card">
                    <div class="featured-image-container">
                        <img src="https://images.unsplash.com/photo-1599059813005-11265ba4b4ce?q=80&w=1470&auto=format&fit=crop" alt="Gaya Hidup Zero Waste">
                    </div>
                    <div class="featured-content-container">
                        <span class="article-category-badge featured">Gaya Hidup Hijau</span>
                        <h2 class="featured-title">5 Langkah Mudah Memulai Gaya Hidup Zero Waste di Rumah</h2>
                        <p class="featured-excerpt">Mengurangi sampah dari sumbernya adalah langkah paling efektif untuk menjaga lingkungan. Pelajari cara-cara praktis yang bisa Anda terapkan mulai hari ini, dari dapur hingga kamar mandi.</p>
                        <div class="article-author-info">
                            <span>Oleh Dr. Rina S. | 10 Juni 2025</span>
                        </div>
                    </div>
                </a>
            </section>

            <section class="all-articles-section">
                <h2 class="section-heading-alt">Semua Artikel</h2>

                <div class="education-grid">
                    <a href="#" class="education-article-card">
                        <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=1470&auto=format&fit=crop" alt="Daur Ulang Plastik" class="education-card-img">
                        <div class="education-card-content">
                            <span class="article-category-badge">Daur Ulang</span>
                            <h3 class="education-card-title">Memahami Simbol Daur Ulang: Panduan Lengkap untuk Pemula</h3>
                            <p class="education-card-excerpt">Segitiga dengan angka di dalamnya seringkali membingungkan. Mari kita bedah arti dari setiap simbol untuk membantu Anda memilah sampah dengan benar.</p>
                        </div>
                    </a>
                      <a href="#" class="education-article-card">
                        {{-- PERUBAHAN: Menggunakan gambar lokal dengan asset() --}}
                        <img src="{{ asset('img/mikroplastik.jpg') }}" alt="Pencemaran plastik di laut" class="education-card-img">
                        <div class="education-card-content">
                            <span class="article-category-badge danger">Pencemaran</span>
                            <h3 class="education-card-title">Ancaman Tak Terlihat: Bahaya Mikroplastik di Laut Kita</h3>
                            <p class="education-card-excerpt">Plastik tidak benar-benar hilang, ia hanya terpecah menjadi bagian-bagian kecil. Kenali dampak mikroplastik bagi ekosistem laut dan kesehatan manusia.</p>
                        </div>
                    </a>
                    <a href="#" class="education-article-card">
                        <img src="https://images.unsplash.com/photo-1473448912268-2022ce9509d8?q=80&w=1441&auto=format&fit=crop" alt="Konservasi Hutan" class="education-card-img">
                        <div class="education-card-content">
                            <span class="article-category-badge success">Konservasi</span>
                            <h3 class="education-card-title">Pentingnya Hutan Hujan Sebagai Paru-paru Dunia</h3>
                            <p class="education-card-excerpt">Hutan hujan tropis memainkan peran vital dalam mengatur iklim global. Cari tahu mengapa kita harus melindunginya dan apa yang bisa kita lakukan.</p>
                        </div>
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection