@extends('layouts.app')

@section('title', 'Dashboard Admin - EcoWatch')
@section('description', 'Halaman dashboard untuk pengelolaan sistem EcoWatch.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Admin Dashboard</h1>
            {{-- Menggunakan Auth::user()->nama sesuai database Anda --}}
            <p class="page-subtitle-alt">Selamat datang, {{ Auth::user()->nama ?? 'Admin' }}. Kelola laporan, pengguna, dan konten dari sini.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-icon blue">📥</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Laporan Perlu Verifikasi</p>
                        <p class="stat-card-value">{{ $pendingApprovalReports }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon green">✅</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Total Laporan Disetujui Dinas</p>
                        <p class="stat-card-value">{{ $dinasReports }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon orange">📊</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Total Laporan Selesai</p>
                        <p class="stat-card-value">{{ $completedReports }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon red">📝</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Total Semua Laporan</p>
                        <p class="stat-card-value">{{ $totalReports }}</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-table-container">
                <h2 class="section-heading-alt">Aksi Cepat Admin</h2>
                <div class="admin-quick-actions"> {{-- Ini adalah div pembungkus untuk tombol --}}
                    {{-- Tombol Verifikasi Laporan --}}
                    <a href="{{ route('admin.reports.pending_approval') }}" class="admin-action-btn primary-blue">
                        Verifikasi Laporan Baru ({{ $pendingApprovalReports }})
                    </a>
                    {{-- Tombol Kelola Edukasi --}}
                    <a href="{{ route('admin.education.index') }}" class="admin-action-btn primary-green">
                        Kelola Edukasi
                    </a>
                    {{-- Tambahkan tautan lain jika ada manajemen user, setting, dll. --}}
                </div>

                <h2 class="section-heading-alt" style="margin-top: 2rem;">Manajemen Lainnya</h2>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="#" class="section-link">Manajemen Pengguna</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" class="section-link">Pengaturan Sistem</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection