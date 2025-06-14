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
                <div class="report-list-item">
                    <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/8ec9bb7dfb0b27b3c9bc530655a4e010361d6844?placeholderIfAbsent=true&format=webp&width=300" alt="Polusi Smelter" class="report-item-img">
                    <div class="report-item-content">
                        <div class="report-item-header">
                            <span class="report-item-category">Pencemaran Udara</span>
                            <span class="status-badge active">Aktif</span>
                        </div>
                        <h3 class="report-item-title">Polusi Smelter PT VDNI di Morosi</h3>
                        <p class="report-item-location">Konawe, Sulawesi Tenggara</p>
                        <p class="report-item-date">Dilaporkan oleh: Budi S. - 12 Juni 2025</p>
                    </div>
                    <a href="{{ route('reports.show', ['report' => 4]) }}" class="btn-detail">Lihat Detail</a>
                </div>
                 <div class="report-list-item">
                    <img src="https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/624e7fcaf2f3148b658fbab940f49a9390432f27?placeholderIfAbsent=true&format=webp&width=300" alt="Penggundulan Hutan" class="report-item-img">
                    <div class="report-item-content">
                        <div class="report-item-header">
                            <span class="report-item-category">Deforestasi</span>
                            <span class="status-badge processing">Diproses</span>
                        </div>
                        <h3 class="report-item-title">Penggundulan Hutan Liar di Wawonii</h3>
                        <p class="report-item-location">Konawe Kepulauan, Sulawesi Tenggara</p>
                        <p class="report-item-date">Dilaporkan oleh: Ani P. - 10 Juni 2025</p>
                    </div>
                    <a href="{{ route('reports.show', ['report' => 1]) }}" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
            
            <nav class="pagination">
                <a href="#" class="page-link disabled">Sebelumnya</a>
                <a href="#" class="page-link active">1</a>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">3</a>
                <a href="#" class="page-link">Selanjutnya</a>
            </nav>
        </div>
    </div>
</div>
@endsection