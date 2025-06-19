@extends('layouts.app')

@section('title', 'Detail Laporan - ' . $report->judul)
@section('description', 'Lihat detail lengkap laporan, foto, dan diskusi komunitas terkait masalah lingkungan ini.')

@section('content')
<div class="page-container">
    <div class="main-content-alt">
        <div class="container detail-container">
            <div class="report-main-content">
                <div class="detail-header">
                    <span class="report-item-category">{{ $report->category ?? 'Umum' }}</span>
                    <h1 class="detail-title">{{ $report->judul }}</h1>
                    
                    {{-- BAGIAN YANG DISEMPURNAKAN --}}
                    <div class="detail-meta">
                        <span><i class="fas fa-user-circle"></i> Dilaporkan oleh <strong>{{ $report->user->name ?? 'Pengguna Anonim' }}</strong></span>
                        <span><i class="fas fa-calendar-alt"></i> {{ $report->created_at->format('d F Y') }}</span>
                        <span class="report-id"><i class="fas fa-hashtag"></i> ID: {{ $report->id }}</span>
                        
                        {{-- Logika baru untuk menampilkan status dengan ikon dan warna --}}
                        @if($report->status)
                            @php
                                $statusClass = 'secondary'; $statusIcon = 'fa-question-circle';
                                $currentStatus = strtolower($report->status);
                                if ($currentStatus == 'selesai') { $statusClass = 'success'; $statusIcon = 'fa-check-circle'; }
                                elseif ($currentStatus == 'diproses') { $statusClass = 'info'; $statusIcon = 'fa-cogs'; }
                                elseif ($currentStatus == 'ditunda') { $statusClass = 'warning'; $statusIcon = 'fa-pause-circle'; }
                                elseif ($currentStatus == 'ditolak') { $statusClass = 'danger'; $statusIcon = 'fa-times-circle'; }
                            @endphp
                            <span class="status-badge-detail status-{{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i>
                                {{ $report->status }}
                            </span>
                        @endif
                    </div>
                    {{-- AKHIR BAGIAN YANG DISEMPURNAKAN --}}

                </div>
                <div class="photo-gallery">
                    @php
                        $photos = $report->fotoBukti;
                    @endphp

                    @if ($photos && is_array($photos) && !empty($photos))
                        <img src="{{ asset('storage/' . $photos[0]) }}" alt="Foto Laporan Utama" class="main-photo">
                        @if (count($photos) > 1)
                            <div class="thumbnail-gallery">
                                @foreach ($photos as $index => $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Thumbnail Foto {{ $index + 1 }}" 
                                         class="thumbnail-item {{ $index == 0 ? 'active' : '' }}" 
                                         onclick="changeMainPhoto(this)">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <img src="{{ asset('img/placeholder.jpg') }}" alt="Tidak ada foto" class="main-photo">
                        <p class="text-center mt-3">Tidak ada foto terlampir untuk laporan ini.</p>
                    @endif
                </div>
                <div class="detail-description-box">
                    <h3 class="section-heading">Deskripsi Laporan</h3>
                    <p>{{ $report->deskripsi }}</p>
                </div>

                {{-- BAGIAN KOMENTAR ANDA YANG TIDAK DIUBAH SAMA SEKALI --}}
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

            {{-- Sidebar tidak diubah --}}
            <aside class="report-sidebar">
                <div class="sidebar-widget">
                    <h4 class="widget-title">Lokasi Kejadian</h4>
                    <p>{{ $report->lokasi }}</p>
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

<script>
    function changeMainPhoto(thumbnail) {
        const mainPhoto = document.querySelector('.main-photo');
        const activeThumbnail = document.querySelector('.thumbnail-item.active');
        if (activeThumbnail) {
            activeThumbnail.classList.remove('active');
        }
        mainPhoto.src = thumbnail.src;
        thumbnail.classList.add('active');
    }
</script>
@endsection

@push('styles')
<style>
    .detail-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1.5rem; /* Jarak antar item */
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 1rem;
        border-top: 1px solid #e3e3e3;
        border-bottom: 1px solid #e3e3e3;
        padding: 0.75rem 0;
    }
    .detail-meta span {
        display: inline-flex;
        align-items: center;
    }
    .detail-meta .fas {
        margin-right: 0.5rem;
        color: #adb5bd;
    }
    .status-badge-detail {
        padding: 0.4em 0.9em;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-badge-detail.status-warning { background-color: #ffc107; color: #212529; }
    .status-badge-detail.status-info { background-color: #17a2b8; }
    .status-badge-detail.status-success { background-color: #28a745; }
    .status-badge-detail.status-danger { background-color: #dc3545; }
    .status-badge-detail.status-secondary { background-color: #6c757d; }
</style>
@endpush
