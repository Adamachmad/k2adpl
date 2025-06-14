@extends('layouts.app')

@section('title', 'Laporan Berhasil Terkirim - EcoWatch')
@section('description', 'Terima kasih telah melaporkan. Laporan Anda sedang kami proses.')

@section('content')
<div class="success-page-container">
    <div class="success-card">
        <div class="success-icon">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h1 class="success-title">Laporan Berhasil Terkirim!</h1>
        <p class="success-message">
            Terima kasih telah peduli dan mengambil tindakan untuk lingkungan kita. Setiap laporan sangat berarti.
        </p>
        
        <div class="report-id-box">
            <span>ID Laporan Anda</span>
            <strong>ECO-W-{{ date('Ymd') }}-001</strong>
            <small>Gunakan ID ini untuk melacak status laporan Anda.</small>
        </div>

        <div class="next-steps">
            <h3 class="next-steps-title">Apa Selanjutnya?</h3>
            <ol>
                <li><strong>Verifikasi Laporan:</strong> Tim kami akan memverifikasi detail laporan Anda dalam 1x24 jam.</li>
                <li><strong>Tindak Lanjut:</strong> Laporan yang valid akan kami teruskan ke dinas terkait untuk penanganan.</li>
                <li><strong>Pembaruan Status:</strong> Anda dapat memantau status laporan Anda kapan saja melalui halaman "Laporan Saya".</li>
            </ol>
        </div>

        <div class="success-actions">
            <a href="{{-- route('reports.index') --}}" class="btn-primary">Lihat Laporan Saya</a>
            <a href="{{ route('home') }}" class="btn-secondary">Kembali ke Halaman Utama</a>
        </div>
    </div>
</div>
@endsection