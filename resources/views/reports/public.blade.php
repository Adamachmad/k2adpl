@extends('layouts.app')

@section('title', 'Laporan Publik - EcoWatch')
@section('description', 'Lihat semua laporan kerusakan lingkungan yang dikirim oleh komunitas EcoWatch.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Laporan Publik</h1>
            <p class="page-subtitle-alt">Lihat semua laporan kerusakan lingkungan yang dikirim oleh komunitas EcoWatch.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <div class="filter-bar">
                <button class="filter-btn active">Semua</button>
                <button class="filter-btn">Diproses</button>
                <button class="filter-btn">Selesai</button>
            </div>

            <div class="report-list">
                {{-- Gunakan @forelse untuk loop data dari controller --}}
                @forelse($reports as $report)
                    <div class="report-list-item">
                        @php
                            // Logika untuk mendapatkan URL gambar pertama atau placeholder
                            // Memastikan $report->fotoBukti ada, merupakan array, dan tidak kosong
                            $photos = $report->fotoBukti;
                            $firstPhotoUrl = ($photos && is_array($photos) && !empty($photos))
                                ? asset('storage/' . $photos[0])
                                : asset('img/placeholder.jpg');
                        @endphp
                        {{-- Tampilkan gambar secara dinamis --}}
                        <img src="{{ $firstPhotoUrl }}" alt="{{ $report->judul }}" class="report-item-img">
                        
                        <div class="report-item-content">
                            <div class="report-item-header">
                                {{-- Tampilkan data dinamis dari database --}}
                                <span class="report-item-category">{{ $report->category ?? 'Umum' }}</span>
                                <span class="status-badge {{ strtolower($report->status) }}">{{ $report->status }}</span>
                            </div>
                            <h3 class="report-item-title">{{ $report->judul }}</h3>
                            <p class="report-item-location">{{ $report->lokasi }}</p>
                            <p class="report-item-date">Dilaporkan oleh: {{ $report->user->name ?? 'Anonim' }} - {{ $report->created_at->format('d F Y') }}</p>
                        </div>
                        {{-- Buat link ke detail laporan secara dinamis --}}
                        <a href="{{ route('reports.show', $report->id) }}" class="btn-detail">Lihat Detail</a>
                        
                    </div>
                @empty
                    {{-- Bagian ini akan tampil jika tidak ada laporan sama sekali di database --}}
                    <div class="empty-state" style="width: 100%; text-align: center; padding: 4rem 0;">
                        <h2 class="empty-state-title">Belum Ada Laporan Publik</h2>
                        <p class="empty-state-text">Jadilah yang pertama melaporkan masalah lingkungan di sekitar Anda!</p>
                        <a href="{{ route('reports.create') }}" class="btn-primary" style="background: var(--primary-green); color: white; margin-top: 1rem;">Buat Laporan Baru</a>
                    </div>
                @endforelse
            </div>
            
            {{-- Tampilkan navigasi halaman (pagination) secara dinamis --}}
            <div class="pagination-container" style="margin-top: 2rem;">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection