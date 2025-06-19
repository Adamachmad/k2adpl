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
            @forelse($recentReports as $report)
                <div class="report-card">
                    @php
                        $photos = $report->fotoBukti;
                        $firstPhotoUrl = ($photos && is_array($photos) && !empty($photos)) ? asset('storage/' . $photos[0]) : asset('img/placeholder.jpg');
                    @endphp
                    <img src="{{ $firstPhotoUrl }}" alt="{{ $report->judul }}" class="report-image" loading="lazy">
                    <div class="report-content">
                        <div class="report-card-header">
                            <span class="report-category">{{ $report->category ?? 'Umum' }}</span>
                            {{-- PERBAIKAN: Menambahkan status di sini --}}
                            @if($report->status)
                                <span class="status-badge {{ strtolower($report->status) }}">{{ $report->status }}</span>
                            @endif
                        </div>
                        <h3 class="report-title">{{ Str::limit($report->judul, 40) }}</h3>
                        <div class="report-location">
                            <span class="icon">📍</span>
                            <span>{{ Str::limit($report->lokasi, 45) }}</span>
                        </div>
                        <div class="report-time">
                            <span class="icon">🕒</span>
                            <span>{{ $report->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="report-footer">
                            <a href="{{ route('reports.show', $report->id) }}" class="detail-link">Lihat Detail →</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-100 text-center py-4">
                    <p>Belum ada laporan terbaru.</p>
                </div>
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
            @if(isset($recentArticles))
                @forelse($recentArticles as $article)
                    <article class="article-card">
                        <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('img/placeholder.jpg') }}" alt="{{ $article->title }}" class="article-image" loading="lazy">
                        <div class="article-header simplified">
                            <div class="article-meta">
                                <span class="reading-time">📖 {{ $article->category ?? 'Info' }}</span>
                                <h3 class="article-title">{{ Str::limit($article->title, 55) }}</h3>
                            </div>
                        </div>
                        <p class="article-excerpt">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <div class="article-footer">
                            <div class="article-author">
                                <span class="author-name">Oleh Tim EcoWatch</span>
                                <span class="publish-date">{{ $article->created_at->format('d M Y') }}</span>
                            </div>
                            <a href="{{ route('education.show', $article->id) }}" class="read-more">Baca →</a>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-5" style="width: 100%;">
                        <p>Belum ada artikel edukasi yang dipublikasikan.</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</section>
@endsection
