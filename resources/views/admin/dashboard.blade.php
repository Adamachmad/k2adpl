@extends('layouts.app')

@section('title', 'Admin Dashboard - EcoWatch')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Admin Dashboard</h1>
            <p class="page-subtitle-alt">Selamat datang, Admin. Kelola laporan, pengguna, dan konten dari sini.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-icon blue">📥</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Laporan Perlu Verifikasi</p>
                        <p class="stat-card-value">12</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon green">📈</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Total Laporan Aktif</p>
                        <p class="stat-card-value">78</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon orange">👥</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Total Pengguna</p>
                        <p class="stat-card-value">254</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon red">📝</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Total Artikel Edukasi</p>
                        <p class="stat-card-value">15</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-table-container">
                <h2 class="section-heading-alt">Laporan Terbaru Untuk Diverifikasi</h2>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>ID Laporan</th>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ECO-000125</td>
                            <td>Tumpukan Sampah Liar di Tepi Jalan</td>
                            <td>Budi S.</td>
                            <td>15 Juni 2025</td>
                            <td><span class="status-badge pending">DITUNDA</span></td>
                            <td><a href="#" class="btn-table-action">Verifikasi</a></td>
                        </tr>
                        <tr>
                            <td>#ECO-000124</td>
                            <td>Asap Pabrik Mengganggu di Malam Hari</td>
                            <td>Citra M.</td>
                            <td>14 Juni 2025</td>
                            <td><span class="status-badge pending">DITUNDA</span></td>
                            <td><a href="#" class="btn-table-action">Verifikasi</a></td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection