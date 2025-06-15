@extends('layouts.app')

@section('title', 'EcoWatch - Laporkan Kerusakan Lingkungan di Sekitar Anda')
@section('description', 'Pantau, Laporkan, dan Selamatkan Lingkungan Bersama EcoWatch. Setiap laporan Anda berkontribusi untuk masa depan yang lebih hijau.')

@section('content')
<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="hero-title">
                Laporkan Kerusakan Lingkungan<br>
                <span class="hero-subtitle">di Sekitar Anda</span>
            </h1>
            <p class="hero-description">
                Pantau, Laporkan, dan Selamatkan Lingkungan Bersama EcoWatch.
                Setiap laporan Anda berkontribusi untuk masa depan yang lebih hijau.
            </p>
            <a href="{{ route('reports.create') }}" class="hero-cta-btn">
                <span class="btn-icon">+</span>
                Mulai Buat Laporan
            </a>
        </div>
    </div>
</section>

<section class="stats">
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-indicator green"></div>
            <span class="stat-text">1,247 Laporan Aktif</span>
        </div>
        <div class="stat-item">
            <div class="stat-indicator blue"></div>
            <span class="stat-text">89 Kota Terjangkau</span>
        </div>
        <div class="stat-item">
            <div class="stat-indicator orange"></div>
            <span class="stat-text">156 Kasus Terselesaikan</span>
        </div>
    </div>
</section>

<section class="partners">
    <div class="partners-container">
        <h2 class="partners-title">Aplikasi Yang Bermitra Dengan Kedinasan:</h2>
        <div class="partner-logos">
            <a href="https://www.menlhk.go.id/" target="_blank" rel="noopener noreferrer" class="partner-link">
                <div class="partner-logo">
                    <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/ada15015f30b3cef19222cde70a267df20f45d12?placeholderIfAbsent=true&format=webp&width=400"
                         alt="Kementerian Lingkungan Hidup dan Kehutanan" class="partner-img" loading="lazy">
                </div>
            </a>
            <a href="https://brgm.go.id/" target="_blank" rel="noopener noreferrer" class="partner-link">
                <div class="partner-logo">
                    <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/6544be8787f982baa225bff134d4ce82d0194155?placeholderIfAbsent=true&format=webp&width=400"
                         alt="Badan Restorasi Gambut dan Mangrove" class="partner-img" loading="lazy">
                </div>
            </a>
        </div>
    </div>
</section>

<section class="reports">
    <div class="reports-container">
        <div class="section-header">
            <h2 class="section-title">Laporan Terbaru</h2>
            <a href="{{ route('reports.public') }}" class="section-link">Lihat Semua</a>
        </div>
        <div class="reports-grid">
            <div class="report-card">
                <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/70495b491d493198a97b72ca55f1c7d45672ae57?placeholderIfAbsent=true&format=webp&width=300" alt="Pencemaran Laut Pulau Kabaena" class="report-image" loading="lazy">
                <div class="report-content">
                    <h3 class="report-title">Pencemaran Laut Pulau Kabaena</h3>
                    <span class="report-category">Pencemaran Air</span>
                    <div class="report-location">
                        <span class="icon">📍</span>
                        <span>Bombana, Sulawesi Tenggara</span>
                    </div>
                    <div class="report-time">
                        <span class="icon">🕒</span>
                        <span>2 jam lalu</span>
                    </div>
                    <div class="report-footer">
                        <span class="status-badge active">Aktif</span>
                        <a href="{{ route('reports.show', ['report' => 1]) }}" class="detail-link">Lihat Detail →</a>
                    </div>
                </div>
            </div>
            <div class="report-card">
                <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/624e7fcaf2f3148b658fbab940f49a9390432f27?placeholderIfAbsent=true&format=webp&width=300" alt="Penggundulan Hutan Liar Wawonii" class="report-image" loading="lazy">
                <div class="report-content">
                    <h3 class="report-title">Penggundulan Hutan Liar Wawonii</h3>
                    <span class="report-category">Deforestasi</span>
                    <div class="report-location">
                        <span class="icon">📍</span>
                        <span>Konawe Kepulauan, Sulawesi Tenggara</span>
                    </div>
                    <div class="report-time">
                        <span class="icon">🕒</span>
                        <span>5 jam lalu</span>
                    </div>
                    <div class="report-footer">
                        <span class="status-badge processing">Dalam Proses</span>
                        <a href="{{ route('reports.show', ['report' => 2]) }}" class="detail-link">Lihat Detail →</a>
                    </div>
                </div>
            </div>
            <div class="report-card">
                <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/7c8a0ad64e23c77aba14a983cb0c44b9f3efd777?placeholderIfAbsent=true&format=webp&width=300" alt="Pembuangan Limbah Padi Tongauna" class="report-image" loading="lazy">
                <div class="report-content">
                    <h3 class="report-title">Pembuangan Limbah Padi Tongauna</h3>
                    <span class="report-category">Pencemaran Tanah</span>
                    <div class="report-location">
                        <span class="icon">📍</span>
                        <span>Konawe, Sulawesi Tenggara</span>
                    </div>
                    <div class="report-time">
                        <span class="icon">🕒</span>
                        <span>1 hari lalu</span>
                    </div>
                    <div class="report-footer">
                        <span class="status-badge completed">Terselesaikan</span>
                        <a href="{{ route('reports.show', ['report' => 3]) }}" class="detail-link">Lihat Detail →</a>
                    </div>
                </div>
            </div>
            <div class="report-card">
                <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/8ec9bb7dfb0b27b3c9bc530655a4e010361d6844?placeholderIfAbsent=true&format=webp&width=300" alt="Polusi Smelter PT VDNI" class="report-image" loading="lazy">
                <div class="report-content">
                    <h3 class="report-title">Polusi Smelter PT VDNI</h3>
                    <span class="report-category">Pencemaran Udara</span>
                    <div class="report-location">
                        <span class="icon">📍</span>
                        <span>Konawe, Sulawesi Tenggara</span>
                    </div>
                    <div class="report-time">
                        <span class="icon">🕒</span>
                        <span>2 hari lalu</span>
                    </div>
                    <div class="report-footer">
                        <span class="status-badge active">Aktif</span>
                        <a href="{{ route('reports.show', ['report' => 4]) }}" class="detail-link">Lihat Detail →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="articles">
    <div class="articles-container">
        <div class="section-header">
            <h2 class="section-title">Artikel Edukasi</h2>
            <a href="{{ route('education.index') }}" class="section-link">Lihat Semua</a>
        </div>
        <div class="articles-grid">
            <article class="article-card">
                <div class="article-header simplified">
                    <div class="article-meta">
                        <span class="reading-time">📖 5 menit baca</span>
                        <h3 class="article-title">Cara Mengurangi Jejak Karbon di Rumah</h3>
                    </div>
                </div>
                <img src="{{ asset('img/jejak-karbon-rumah.jpg') }}" alt="Jejak Karbon di Rumah" class="article-image" loading="lazy">
                <p class="article-excerpt">
                    Pelajari langkah-langkah sederhana yang dapat Anda lakukan untuk mengurangi dampak lingkungan dari aktivitas sehari-hari.
                </p>
                <div class="article-footer">
                    <div class="article-author">
                        <span class="author-name">Oleh Dr. Sari Wijaya</span>
                        <span class="publish-date">15 Des 2024</span>
                    </div>
                    <a href="{{ route('education.show', ['article' => 1]) }}" class="read-more">Baca →</a>
                </div>
            </article>

            <article class="article-card">
                <div class="article-header simplified">
                    <div class="article-meta">
                        <span class="reading-time">📖 7 menit baca</span>
                        <h3 class="article-title">Pentingnya Daur Ulang untuk Masa Depan</h3>
                    </div>
                </div>
                <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=1470&auto=format&fit=crop" alt="Daur Ulang" class="article-image" loading="lazy">
                <p class="article-excerpt">
                    Memahami mengapa daur ulang sangat penting untuk menjaga kelestarian lingkungan dan bagaimana cara melakukannya dengan benar.
                </p>
                <div class="article-footer">
                    <div class="article-author">
                        <span class="author-name">Oleh Prof. Ahmad Rizki</span>
                        <span class="publish-date">12 Des 2024</span>
                    </div>
                    <a href="{{ route('education.show', ['article' => 2]) }}" class="read-more">Baca →</a>
                </div>
            </article>

            <article class="article-card">
                <div class="article-header simplified">
                    <div class="article-meta">
                        <span class="reading-time">📖 10 menit baca</span>
                        <h3 class="article-title">Dampak Perubahan Iklim Global</h3>
                    </div>
                </div>
                <img src="https://images.unsplash.com/photo-1473448912268-2022ce9509d8?q=80&w=1441&auto=format&fit=crop" alt="Perubahan Iklim" class="article-image" loading="lazy">
                <p class="article-excerpt">
                    Analisis mendalam tentang bagaimana perubahan iklim mempengaruhi ekosistem dan kehidupan manusia di seluruh dunia.
                </p>
                <div class="article-footer">
                    <div class="article-author">
                        <span class="author-name">Oleh Dr. Maya Indira</span>
                        <span class="publish-date">10 Des 2024</span>
                    </div>
                    <a href="{{ route('education.show', ['article' => 3]) }}" class="read-more">Baca →</a>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection