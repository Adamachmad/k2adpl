@extends('layouts.app')

@section('title', 'Detail Lokasi Laporan - EcoWatch')
@section('description', 'Tentukan lokasi kejadian dengan detail untuk memudahkan tim kami dalam proses penanganan.')

@section('content')
<div class="create-report-container">
    <div class="create-report-header">
        <div class="container">
            <h1 class="page-title">Detail Lokasi Kejadian</h1>
            <p class="page-subtitle">Tentukan lokasi kejadian dengan detail untuk memudahkan tim kami dalam proses penanganan.</p>

            <div class="progress-stepper">
                <div class="step completed">
                    <div class="step-circle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="step-label">Jenis Laporan</div>
                </div>
                <div class="step-connector completed"></div>
                <div class="step active">
                    <div class="step-circle">2</div>
                    <div class="step-label">Detail Lokasi</div>
                </div>
                <div class="step-connector"></div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Deskripsi & Foto</div>
                </div>
                <div class="step-connector"></div>
                <div class="step">
                    <div class="step-circle">4</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="container">
            <div class="selected-category-card">
                <div class="category-icon-small blue">💧</div>
                <div class="category-info">
                    <span>Jenis Laporan Terpilih</span>
                    <strong>Pencemaran Air</strong>
                </div>
            </div>

            <form class="report-form" action="{{ route('reports.create.step3') }}" method="GET">
                <div class="form-section">
                    <h3 class="form-section-title">
                        <span class="input-icon">🏛️</span>
                        Wilayah Administratif
                    </h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="provinsi" class="form-label">Provinsi <span class="required">*</span></label>
                            <select id="provinsi" name="provinsi" class="form-select" required>
                                <option value="" disabled>-- Pilih Provinsi --</option>
                                <option value="SULAWESI_TENGGARA" selected>SULAWESI TENGGARA</option>
                                <option value="SULAWESI_SELATAN">SULAWESI SELATAN</option>
                                <option value="JAWA_BARAT">JAWA BARAT</option>
                                <option value="DKI_JAKARTA">DKI JAKARTA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kabupaten" class="form-label">Kabupaten/Kota <span class="required">*</span></label>
                            <select id="kabupaten" name="kabupaten" class="form-select" required>
                                <option value="" disabled>-- Pilih Kabupaten/Kota --</option>
                                <option value="KOTA_KENDARI" selected>KOTA KENDARI</option>
                                <option value="KAB_KONAWE">KAB. KONAWE</option>
                                <option value="KAB_BOMBANA">KAB. BOMBANA</option>
                                <option value="KAB_KONAWE_KEPULAUAN">KAB. KONAWE KEPULAUAN</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan" class="form-label">Kecamatan <span class="required">*</span></label>
                            <select id="kecamatan" name="kecamatan" class="form-select" required>
                                <option value="" disabled>-- Pilih Kecamatan --</option>
                                <option value="POASIA" selected>POASIA</option>
                                <option value="KENDARI_BARAT">KENDARI BARAT</option>
                                <option value="ABELI">ABELI</option>
                                <option value="KAMBU">KAMBU</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="desa" class="form-label">Desa/Kelurahan <span class="required">*</span></label>
                            <select id="desa" name="desa" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Desa/Kelurahan --</option>
                                <option value="RAHANDOUNA">RAHANDOUNA</option>
                                <option value="ANGGOEYA">ANGGOEYA</option>
                                <option value="MATABUBU">MATABUBU</option>
                                <option value="WUNDUDOPI">WUNDUDOPI</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">
                        <span class="input-icon">📍</span>
                        Alamat Detail
                    </h3>
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="required">*</span></label>
                        <textarea id="alamat" name="alamat" class="form-textarea" rows="4" placeholder="Contoh: Jl. M.T. Haryono No. 123, Lorong..., RT/RW..." required></textarea>
                        <p class="form-hint">
                            <strong>Contoh alamat yang baik:</strong> "Jl. Raya Kendari No. 123, RT 05/RW 03, dekat Pasar Sentral Kendari, sebelah Masjid Al-Ikhlas"
                        </p>
                    </div>
                </div>

                <div class="tips-card">
                    <div class="tips-icon">💡</div>
                    <div class="tips-content">
                        <h4 class="tips-title">Tips Menentukan Lokasi yang Akurat</h4>
                        <ul>
                            <li>Pastikan semua field wilayah administratif terisi dengan benar.</li>
                            <li>Gunakan patokan yang mudah dikenali seperti sekolah, masjid, pasar, atau jalan utama.</li>
                            <li>Semakin detail alamat, semakin mudah tim kami menemukan dan menangani masalah.</li>
                        </ul>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('reports.create') }}" class="btn-back">← Kembali</a>
                    {{-- Pesan error ini bisa Anda tampilkan secara dinamis dengan JavaScript --}}
                    <div class="form-alert" style="display: none;">
                        <span class="alert-icon">⚠️</span>
                        Lengkapi semua field yang wajib diisi
                    </div>
                    <button type="submit" class="btn-next">Lanjut ke Deskripsi →</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection