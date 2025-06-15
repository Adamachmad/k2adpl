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
            
            <a href="https://menlhk.go.id/" target="_blank" rel="noopener noreferrer" class="partner-link">
                <div class="partner-logo">
                    <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/ada15015f30b3cef19222cde70a267df20f45d12?placeholderIfAbsent=true&format=webp&width=400"
                        alt="Kementerian Lingkungan Hidup dan Kehutanan" class="partner-img"
                        loading="lazy">
                </div>
            </a>
            
            <a href="https://brgm.go.id/" target="_blank" rel="noopener noreferrer" class="partner-link">
                <div class="partner-logo">
                    <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/6544be8787f982baa225bff134d4ce82d0194155?placeholderIfAbsent=true&format=webp&width=400"
                        alt="Badan Restorasi Gambut dan Mangrove" class="partner-img"
                        loading="lazy">
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
            {{-- Loop melalui laporan terbaru yang diambil dari database --}}
            @forelse($recentReports as $report)
                <div class="report-card">
                    @php
                        $photos = json_decode($report->fotoBukti);
                        $firstPhotoUrl = ($photos && is_array($photos) && !empty($photos)) ? asset('storage/' . $photos[0]) : asset('img/placeholder.jpg');
                    @endphp
                    <img src="{{ $firstPhotoUrl }}" alt="{{ $report->judul }}" class="report-image" loading="lazy">
                    <div class="report-content">
                        <h3 class="report-title">{{ $report->judul }}</h3>
                        <span class="report-category">{{ $report->category ?? 'Umum' }}</span>
                        <div class="report-location">
                            <span class="icon">📍</span>
                            <span>{{ $report->lokasi }}</span>
                        </div>
                        <div class="report-time">
                            <span class="icon">🕒</span>
                            <span>{{ $report->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="report-footer">
                            <span class="status-badge {{ strtolower($report->status) }}">{{ $report->status }}</span>
                            <a href="{{ route('reports.show', $report->id) }}" class="detail-link">Lihat Detail →</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Belum ada laporan terbaru.</p>
            @endforelse
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
                <img src="https://images.unsplash.com/photo-1542601904-45B6A6358354?q=80&w=1470&auto=format&fit=crop" alt="Jejak Karbon di Rumah" class="article-image" loading="lazy">
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