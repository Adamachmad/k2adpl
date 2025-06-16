@extends('layouts.app')

@section('title', 'Laporan Saya - EcoWatch')
@section('description', 'Lacak status dan lihat detail semua laporan kerusakan lingkungan yang telah Anda kirim.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Laporan Saya</h1>
            <p class="page-subtitle-alt">Lacak status dan lihat detail semua laporan kerusakan lingkungan yang telah Anda kirim.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <div class="filter-bar">
                <button class="filter-btn active">Semua</button>
                <button class="filter-btn">Menunggu Verifikasi</button>
                <button class="filter-btn">Diproses</button>
                <button class="filter-btn">Selesai</button>
                <button class="filter-btn">Ditolak</button>
            </div>

            <div class="report-list">
                {{-- @forelse akan melakukan loop jika ada laporan, dan menjalankan @empty jika tidak ada --}}
                @forelse($reports as $report)
                <div class="report-list-item">
                    @php
                    // Mengambil foto pertama dari array di kolom fotoBukti
                    $photos = $report->fotoBukti;
                    // Pastikan $photos adalah array dan tidak kosong, jika tidak gunakan placeholder
                    $firstPhotoUrl = ($photos && is_array($photos) && !empty($photos)) ? asset('storage/' . $photos[0]) : asset('img/placeholder.jpg');
                    @endphp
                    <img src="{{ $firstPhotoUrl }}" alt="{{ $report->judul }}" class="report-item-img">
                    <div class="report-item-content">
                        <div class="report-item-header">
                            {{-- Tampilkan kategori laporan --}}
                            <span class="report-item-category">{{ $report->category ?? 'Umum' }}</span>
                            <span class="status-badge {{ strtolower($report->status) }}">{{ $report->status }}</span>
                        </div>
                        <h3 class="report-item-title">{{ $report->judul }}</h3>
                        <p class="report-item-location">{{ $report->lokasi }}</p>
                        {{-- Tampilkan ID Laporan dan tanggal --}}
                        <p class="report-item-date">ID Laporan: {{ $report->id }} | Dilaporkan pada: {{ $report->created_at->format('d F Y') }}</p>
                    </div>
                    <a href="{{ route('reports.show', $report->id) }}" class="btn-detail">Lihat Detail</a>
                </div>
                @empty
                {{-- Bagian ini akan tampil jika tidak ada laporan sama sekali --}}
                <div class="empty-state">
                    <img src="{{ asset('img/empty-state.svg') }}" alt="Tidak ada laporan" class="empty-state-img">
                    <h2 class="empty-state-title">Anda Belum Membuat Laporan</h2>
                    <p class="empty-state-text">Mari berkontribusi untuk lingkungan yang lebih baik dengan melaporkan masalah di sekitar Anda.</p>
                    <a href="{{ route('reports.create') }}" class="btn-primary" style="background: var(--primary-green); color: white;">Buat Laporan Baru</a>
                </div>
                @endforelse
            </div>

            {{-- Menampilkan link Paginasi --}}
            <div class="pagination-container" style="margin-top: 2rem;">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection