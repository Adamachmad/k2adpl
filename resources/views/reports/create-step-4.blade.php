@extends('layouts.app')

@section('title', 'Konfirmasi Laporan - EcoWatch')
@section('description', 'Periksa kembali semua detail laporan Anda sebelum mengirim.')

@section('content')
<div class="create-report-container">
    <div class="create-report-header">
        <div class="container">
            <h1 class="page-title">Konfirmasi Laporan Anda</h1>
            <p class="page-subtitle">Satu langkah terakhir. Periksa kembali semua detail laporan Anda sebelum mengirimkannya kepada tim kami.</p>

            <div class="progress-stepper">
                <div class="step completed"><div class="step-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div class="step-label">Jenis Laporan</div></div>
                <div class="step-connector completed"></div>
                <div class="step completed"><div class="step-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div class="step-label">Detail Lokasi</div></div>
                <div class="step-connector completed"></div>
                <div class="step completed"><div class="step-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div class="step-label">Deskripsi & Foto</div></div>
                <div class="step-connector completed"></div>
                <div class="step active"><div class="step-circle">4</div><div class="step-label">Konfirmasi</div></div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="container">
            
            <form class="summary-container" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Nanti di sini kita akan meletakkan input hidden untuk semua data dari langkah sebelumnya --}}
                
                <div class="summary-section">
                    <h3 class="summary-title">Jenis Laporan</h3>
                    <p class="summary-value">Pencemaran Air</p>
                </div>
                <div class="summary-section">
                    <h3 class="summary-title">Lokasi Kejadian</h3>
                    <p class="summary-value">Sulawesi Tenggara, Kendari, Poasia, Jl. M.T. Haryono No. 123</p>
                </div>
                <div class="summary-section">
                    <h3 class="summary-title">Detail Laporan</h3>
                    <p class="summary-label">Judul Laporan</p>
                    <p class="summary-value">Limbah pabrik dibuang langsung ke sungai dekat pemukiman warga</p>
                    <p class="summary-label">Deskripsi</p>
                    <p class="summary-value">Setiap sore, terlihat pipa dari pabrik tahu XYZ mengeluarkan cairan berwarna keruh dan berbau tidak sedap ke sungai. Hal ini sudah berlangsung selama 2 bulan terakhir dan menyebabkan ikan-ikan mati serta gatal-gatal pada warga yang menggunakan air sungai.</p>
                </div>
                <div class="summary-section">
                    <h3 class="summary-title">Foto Terlampir</h3>
                    <div class="file-preview-container">
                        <div class="file-preview-item">
                            <img src="https://via.placeholder.com/150" alt="Foto 1">
                            <span>foto-sungai.jpg</span>
                        </div>
                    </div>
                </div>

                <div class="final-confirmation">
                    <div class="checkbox-container">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Saya menyatakan bahwa informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan.</label>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('reports.create.step3') }}" class="btn-back">← Kembali</a>
                    <button type="submit" class="btn-next">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection