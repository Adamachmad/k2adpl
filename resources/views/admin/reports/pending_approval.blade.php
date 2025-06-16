@extends('layouts.app')

@section('title', 'Persetujuan Laporan - Admin EcoWatch')
@section('description', 'Halaman admin untuk meninjau dan menyetujui laporan sebelum diteruskan ke dinas.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Laporan Menunggu Persetujuan Admin</h1>
            <p class="page-subtitle-alt">Tinjau laporan yang masuk dan setujui untuk diteruskan ke Pihak Dinas Terkait.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem;">
                    {{ session('status') }}
                </div>
            @endif

            <h2 class="section-heading-alt" style="margin-top: 0;">Daftar Laporan</h2>

            <div class="report-list">
                @forelse($reports as $report)
                    <div class="report-list-item">
                        @php
                       $photos = $report->fotoBukti;
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
                        <div class="report-footer" style="border-top: none; padding-top: 0; display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;">
                            <form action="{{ route('admin.reports.approve', $report->id) }}" method="POST" style="width: 100%;">
                                @csrf
                                <button type="submit" class="btn-primary" style="width: 100%; padding: 0.75rem 1rem;">Setujui → Dinas</button>
                            </form>
                            <form action="{{ route('admin.reports.reject_admin', $report->id) }}" method="POST" style="width: 100%;">
                                @csrf
                                <button type="submit" class="btn-secondary" style="width: 100%; padding: 0.75rem 1rem; background-color: #ef4444; color: white;">Tolak</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <img src="{{ asset('img/empty-state.svg') }}" alt="Tidak ada laporan" class="empty-state-img">
                        <h2 class="empty-state-title">Tidak Ada Laporan Menunggu Persetujuan</h2>
                        <p class="empty-state-text">Semua laporan yang masuk telah ditinjau atau tidak ada laporan baru.</p>
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