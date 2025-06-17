@extends('layouts.app') {{-- Atau layouts.admin jika Anda punya layout khusus admin --}}

@section('title', 'Dashboard Admin - EcoWatch')
@section('description', 'Halaman dashboard untuk pengelolaan sistem EcoWatch.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Admin Dashboard</h1>
            <p class="page-subtitle-alt">Selamat datang, {{ Auth::user()->nama ?? 'Admin' }}. Kelola laporan, pengguna, dan konten dari sini.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            {{-- Bagian Statistik --}}
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

            {{-- Bagian Manajemen --}}
            <div class="dashboard-management-container">
                <h2 class="section-heading-alt">Manajemen Utama</h2>
                <div class="admin-quick-actions">
                    <a href="{{ route('admin.reports.pending_approval') }}" class="admin-action-btn primary-blue">
                        <i class="fas fa-check-circle"></i>
                        <span>Verifikasi Laporan ({{ $pendingApprovalReports }})</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="admin-action-btn primary-dark">
                        <i class="fas fa-file-alt"></i>
                        <span>Kelola Semua Laporan</span>
                    </a>
                    <a href="{{ route('admin.education.index') }}" class="admin-action-btn primary-green">
                        <i class="fas fa-book"></i>
                        <span>Kelola Edukasi</span>
                    </a>
                     <a href="{{ route('admin.users.index') }}" class="admin-action-btn primary-dark">
                        <i class="fas fa-users"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                     <a href="#" class="admin-action-btn primary-dark">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan Sistem</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection