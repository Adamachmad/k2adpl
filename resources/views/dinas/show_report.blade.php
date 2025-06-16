@extends('layouts.app')

@section('title', 'Detail Laporan Dinas - EcoWatch')
@section('description', 'Lihat detail laporan dan perbarui status oleh Pihak Dinas Terkait.')

@section('content')
<div class="page-container">
    <div class="main-content-alt">
        <div class="container detail-container">
            <div class="report-main-content">
                <div class="detail-header">
                    <span class="report-item-category">{{ $report->category ?? 'Umum' }}</span>
                    <h1 class="detail-title">{{ $report->judul }}</h1>
                    <div class="detail-meta">
                        <span>Dilaporkan oleh <strong>{{ $report->user->nama ?? 'Pengguna Anonim' }}</strong> pada {{ $report->created_at->format('d F Y') }}</span>
                        <span class="status-badge {{ strtolower($report->status) }}">{{ $report->status }}</span>
                        <span class="report-id">ID Laporan: {{ $report->id }}</span>
                    </div>
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
                
                {{-- Form Update Status oleh Dinas --}}
                <div class="update-status-section" style="background: #f8f8f8; padding: 1.5rem; border-radius: 0.75rem; margin-top: 2rem;">
                    <h3 class="section-heading" style="margin-top: 0; border-bottom: none; padding-bottom: 0;">Perbarui Status Laporan</h3>
                    <form action="{{ route('dinas.update_status', $report->id) }}" method="POST">
                        @csrf
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="status" class="form-label" style="margin-bottom: 0.5rem;">Pilih Status Baru:</label>
                            <select name="status" id="status" class="form-input" style="width: auto; display: inline-block;">
                                <option value="DITUNDA" {{ $report->status == 'DITUNDA' ? 'selected' : '' }}>DITUNDA</option>
                                <option value="DIPROSES" {{ $report->status == 'DIPROSES' ? 'selected' : '' }}>DIPROSES</option>
                                <option value="SELESAI" {{ $report->status == 'SELESAI' ? 'selected' : '' }}>SELESAI</option>
                                <option value="DITOLAK" {{ $report->status == 'DITOLAK' ? 'selected' : '' }}>DITOLAK</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary">Update Status</button>
                    </form>
                </div>
                
                {{-- Bagian Diskusi & Komentar --}}
                <div class="comments-section" style="margin-top: 2rem;">
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