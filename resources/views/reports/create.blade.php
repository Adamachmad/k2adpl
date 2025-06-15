@extends('layouts.app')
@section('title', 'Buat Laporan Kerusakan Lingkungan - EcoWatch')
@section('content')
<div class="create-report-container">
    <div class="create-report-header">
        <div class="container">
            <h1 class="page-title">Buat Laporan Kerusakan Lingkungan</h1>
            <p class="page-subtitle">Pilih jenis kerusakan lingkungan yang ingin Anda laporkan.</p>
            <div class="progress-stepper">
                <div class="step active"><div class="step-circle">1</div><div class="step-label">Jenis Laporan</div></div>
                <div class="step-connector"></div>
                <div class="step"><div class="step-circle">2</div><div class="step-label">Detail Lokasi</div></div>
                <div class="step-connector"></div>
                <div class="step"><div class="step-circle">3</div><div class="step-label">Deskripsi & Foto</div></div>
                <div class="step-connector"></div>
                <div class="step"><div class="step-circle">4</div><div class="step-label">Konfirmasi</div></div>
            </div>
        </div>
    </div>
    <div class="categories-section">
        <div class="container">
            <h2 class="section-title" style="text-align: left;">Pilih Jenis Kerusakan Lingkungan</h2>
            <form action="{{ route('reports.create.step1.post') }}" method="POST">
                @csrf
                <input type="hidden" name="category" id="category-input">
                <div class="categories-grid" id="category-grid">
                    <div class="category-card" data-category="Pencemaran Air"><div class="category-icon blue">💧</div><h3 class="category-title">Pencemaran Air</h3><p class="category-description">Polusi air yang mencemari sungai, danau, atau sumber air lainnya</p><button type="submit" class="category-select-btn">Pilih Kategori</button></div>
                    <div class="category-card" data-category="Pencemaran Udara"><div class="category-icon orange">🏭</div><h3 class="category-title">Pencemaran Udara</h3><p class="category-description">Polusi udara dari kendaraan, pabrik, atau sumber lainnya</p><button type="submit" class="category-select-btn">Pilih Kategori</button></div>
                    <div class="category-card" data-category="Pencemaran Tanah"><div class="category-icon brown">🌱</div><h3 class="category-title">Pencemaran Tanah</h3><p class="category-description">Kontaminasi tanah akibat limbah atau bahan kimia berbahaya</p><button type="submit" class="category-select-btn">Pilih Kategori</button></div>
                    <div class="category-card" data-category="Deforestasi"><div class="category-icon green">🌳</div><h3 class="category-title">Deforestasi</h3><p class="category-description">Penebangan hutan secara ilegal atau berlebihan</p><button type="submit" class="category-select-btn">Pilih Kategori</button></div>
                    <div class="category-card" data-category="Kerusakan Ekosistem"><div class="category-icon red">🗑️</div><h3 class="category-title">Kerusakan Ekosistem</h3><p class="category-description">Kerusakan habitat dan ekosistem alam</p><button type="submit" class="category-select-btn">Pilih Kategori</button></div>
                    <div class="category-card" data-category="Lainnya"><div class="category-icon gray">⚠️</div><h3 class="category-title">Lainnya</h3><p class="category-description">Masalah lingkungan lainnya yang tidak termasuk kategori di atas</p><button type="submit" class="category-select-btn">Pilih Kategori</button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function(e) {
            const category = this.dataset.category;
            document.getElementById('category-input').value = category;
        });
    });
});
</script>
@endsection