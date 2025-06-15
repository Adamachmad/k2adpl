@extends('layouts.app')

@section('title', 'Dashboard Dinas - EcoWatch')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Dashboard Dinas</h1>
            <p class="page-subtitle-alt">Berikut adalah daftar laporan yang telah diverifikasi dan perlu ditindaklanjuti.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
             <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-icon blue">📝</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Laporan Baru Disetujui</p>
                        <p class="stat-card-value">8</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon orange">⏳</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Sedang Ditindaklanjuti</p>
                        <p class="stat-card-value">22</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon green">✅</div>
                    <div class="stat-card-content">
                        <p class="stat-card-label">Kasus Selesai</p>
                        <p class="stat-card-value">156</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-table-container">
                <h2 class="section-heading-alt">Laporan Untuk Ditindaklanjuti</h2>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>ID Laporan</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Tanggal Disetujui</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ECO-000117</td>
                            <td>Penggundulan Hutan Liar di Wawonii</td>
                            <td>Konawe Kepulauan</td>
                            <td>12 Juni 2025</td>
                            <td><span class="status-badge active">DISETUJUI</span></td>
                            <td><a href="#" class="btn-table-action">Tindak Lanjut</a></td>
                        </tr>
                        <tr>
                            <td>#ECO-000115</td>
                            <td>Pencemaran Limbah di Sungai Wanggu</td>
                            <td>Kota Kendari</td>
                            <td>11 Juni 2025</td>
                            <td><span class="status-badge active">DISETUJUI</span></td>
                            <td><a href="#" class="btn-table-action">Tindak Lanjut</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection