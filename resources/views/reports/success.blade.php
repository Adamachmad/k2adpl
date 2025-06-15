@extends('layouts.app')

@section('title', 'Laporan Berhasil Terkirim - EcoWatch')
@section('description', 'Terima kasih! Laporan Anda telah berhasil terkirim dan sedang menunggu verifikasi.')

@section('content')
<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12L11 14L15 10M20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h1 class="success-title">Laporan Berhasil Terkirim!</h1>
        <p class="success-message">
            Terima kasih atas laporan Anda. Tim EcoWatch akan segera memverifikasi dan memprosesnya.
            Setiap kontribusi Anda sangat berarti untuk lingkungan yang lebih baik.
        </p>
        <div class="success-actions">
            <a href="{{ route('reports.index') }}" class="btn-primary">Lihat Laporan Saya</a>
            <a href="{{ route('home') }}" class="btn-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</div>

<style>
    .success-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh; /* Sesuaikan tinggi agar konten berada di tengah vertikal */
        padding: 2rem;
        background-color: #f8fbf8; /* Warna latar belakang yang lembut */
    }

    .success-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        text-align: center;
        max-width: 500px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }

    .success-icon {
        color: #28a745; /* Hijau cerah untuk icon sukses */
        font-size: 4rem; /* Ukuran icon */
        margin-bottom: 1rem;
    }

    .success-icon svg {
        stroke: currentColor;
    }

    .success-title {
        font-size: 2.2rem;
        color: #333;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .success-message {
        font-size: 1.1rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .success-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap; /* Agar tombol bisa wrap di layar kecil */
        justify-content: center;
    }

    .btn-primary, .btn-secondary {
        padding: 0.8rem 1.8rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-primary {
        background-color: #22c55e; /* Primary green */
        color: #fff;
        border: 1px solid #22c55e;
    }

    .btn-primary:hover {
        background-color: #16a34a; /* Darker green on hover */
    }

    .btn-secondary {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ccc;
    }

    .btn-secondary:hover {
        background-color: #e0e0e0;
    }
</style>
@endsection