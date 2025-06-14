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
                <div class="report-list-item">
                    <img src="https://images.unsplash.com/photo-1624375354913-afe132152873?q=80&w=1470&auto=format&fit=crop" alt="Contoh Laporan" class="report-item-img">
                    <div class="report-item-content">
                        <div class="report-item-header">
                            <span class="report-item-category">Deforestasi</span>
                            <span class="status-badge processing">Diproses</span>
                        </div>
                        <h3 class="report-item-title">Penggundulan Hutan Liar di Wawonii</h3>
                        <p class="report-item-location">Konawe Kepulauan, Sulawesi Tenggara</p>
                        <p class="report-item-date">Dilaporkan pada: 10 Juni 2025</p>
                    </div>
                    <a href="{{ route('reports.show', ['report' => 2]) }}" class="btn-detail">Lihat Detail</a>
                </div>
                </div>
            <nav class="pagination">
                <a href="#" class="page-link disabled">Sebelumnya</a>
                <a href="#" class="page-link active">1</a>
                <a href="#" class="page-link">Selanjutnya</a>
            </nav>
        </div>
    </div>
</div>
@endsection