@extends('layouts.app')

{{-- Judul halaman sekarang dinamis sesuai judul laporan --}}
@section('title', $report['title'] . ' - Detail Laporan - EcoWatch')
@section('description', 'Lihat detail lengkap laporan, foto, dan diskusi komunitas terkait masalah lingkungan ini.')

@section('content')
<div class="page-container">
    <div class="main-content-alt">
        <div class="container detail-container">
            <div class="report-main-content">
                <div class="detail-header">
                    {{-- Menggunakan data dari Controller --}}
                    <span class="report-item-category">{{ $report['category'] }}</span>
                    <h1 class="detail-title">{{ $report['title'] }}</h1>
                    <div class="detail-meta">
                        <span>Dilaporkan oleh <strong>{{ $report['reporter'] }}</strong> pada {{ $report['date'] }}</span>
                        <span class="status-badge {{ $report['status_class'] }}">{{ $report['status'] }}</span>
                    </div>
                </div>

                <div class="photo-gallery">
                    {{-- Gambar sekarang dinamis sesuai laporan yang diklik --}}
                    <img src="{{ $report['image_url'] }}" alt="Foto Laporan: {{ $report['title'] }}" class="main-photo">
                </div>
                
                <div class="detail-description-box">
                    <h3 class="section-heading">Deskripsi Laporan</h3>
                    <p>{{ $report['description'] }}</p>
                </div>

                <div class="comments-section">
                    <h3 class="section-heading">Diskusi & Komentar (2)</h3>
                    <div class="comment-form">
                        <img src="https://i.pravatar.cc/40?u=user1" alt="Avatar Anda" class="comment-avatar">
                        <textarea class="comment-input" placeholder="Tulis komentar Anda..." rows="2"></textarea>
                        <button class="comment-submit-btn">Kirim</button>
                    </div>
                    <div class="comment-list">
                        <div class="comment-item">
                            <img src="https://i.pravatar.cc/40?u=user2" alt="Avatar Budi" class="comment-avatar">
                            <div class="comment-content">
                                <div class="comment-header">
                                    <strong class="comment-author">Budi S.</strong>
                                    <span class="comment-time">2 jam lalu</span>
                                </div>
                                <p class="comment-body">Saya juga tinggal di dekat sini dan bisa konfirmasi. Suara gergaji mesin terdengar sampai ke desa.</p>
                            </div>
                        </div>
                        <div class="comment-item">
                            <img src="https://i.pravatar.cc/40?u=user3" alt="Avatar Citra" class="comment-avatar">
                            <div class="comment-content">
                                <div class="comment-header">
                                    <strong class="comment-author">Citra M.</strong>
                                    <span class="comment-time">5 jam lalu</span>
                                </div>
                                <p class="comment-body">Semoga cepat ditindaklanjuti oleh pihak berwenang. Terima kasih atas laporannya!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="report-sidebar">
                <div class="sidebar-widget">
                    <h4 class="widget-title">Lokasi Kejadian</h4>
                    <p>{{ $report['location'] }}</p>
                </div>
                <div class="sidebar-widget">
                    <h4 class="widget-title">Bagikan Laporan</h4>
                    <div class="social-share-buttons">
                        <a href="#">Facebook</a>
                        <a href="#">Twitter</a>
                        <a href="#">WhatsApp</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection