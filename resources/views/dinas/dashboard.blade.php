@extends('layouts.app')

@section('title', 'Dashboard Dinas - EcoWatch')
@section('description', 'Halaman dashboard untuk Pihak Dinas Terkait untuk menindaklanjuti laporan yang disetujui.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Dashboard Dinas</h1>
            <p class="page-subtitle-alt">Lihat dan tindak lanjuti laporan kerusakan lingkungan yang telah disetujui oleh admin.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem;">
                    {{ session('status') }}
                </div>
            @endif

            <h2 class="section-heading-alt" style="margin-top: 0;">Laporan Menunggu Tindak Lanjut</h2>

            <div class="report-list">
                @forelse($reports as $report)
                    <div class="report-list-item">
                        @php
                        $photos = $report->fotoBukti; // Sudah di-cast ke array di model Report
                        $firstPhotoUrl = ($photos && is_array($photos) && !empty($photos)) ? asset('storage/' . $photos[0]) : asset('img/placeholder.jpg');
                        @endphp
                        <img src="{{ $firstPhotoUrl }}" alt="{{ $report->judul }}" class="report-item-img">
                        <div class="report-item-content">
                            <div class="report-item-header">
                                <span class="report-item-category">{{ $report->category ?? 'Umum' }}</span>
                                <span class="status-badge {{ strtolower($report->status) }}">{{ $report->status }}</span>
                            </div>
                            <h3 class="report-item-title">{{ $report->judul }}</h3>
                            <p class="report-item-location">{{ $report->lokasi }}</p>
                            <p class="report-item-date">Dilaporkan pada: {{ $report->created_at->format('d F Y') }}</p>
                            <p class="report-item-date">ID Laporan: {{ $report->id }}</p>
                        </div>
                        <a href="{{ route('dinas.show.report', $report->id) }}" class="btn-detail">Tindak Lanjut →</a>
                    </div>
                @empty
                    <div class="empty-state">
                        <img src="{{ asset('img/empty-state.svg') }}" alt="Tidak ada laporan" class="empty-state-img">
                        <h2 class="empty-state-title">Tidak Ada Laporan Menunggu Tindak Lanjut</h2>
                        <p class="empty-state-text">Saat ini belum ada laporan yang disetujui admin untuk ditindaklanjuti oleh dinas.</p>
                    </div>
                @endforelse
            </div>

            {{-- Paginasi --}}
            <div class="pagination-container" style="margin-top: 2rem;">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection