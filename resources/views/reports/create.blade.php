@extends('layouts.app')

@section('title', 'Buat Laporan Kerusakan Lingkungan - EcoWatch')
@section('description', 'Laporkan masalah lingkungan di sekitar Anda untuk membantu menciptakan lingkungan yang lebih bersih dan sehat.')

@section('content')
<div class="create-report-container">
    <div class="create-report-header">
        <div class="container">
            <div class="header-content">
                <h1 class="page-title">Buat Laporan Kerusakan Lingkungan</h1>
                <p class="page-subtitle">Laporkan masalah lingkungan di sekitar Anda untuk membantu menciptakan lingkungan yang lebih bersih dan sehat.</p>
            </div>

            <div class="progress-stepper">
                <div class="step active">
                    <div class="step-circle">1</div>
                    <div class="step-label">Jenis Laporan</div>
                </div>
                <div class="step-connector"></div>
                <div class="step">
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

    <div class="categories-section">
        <div class="container">
            {{-- Menambahkan style="text-align: left;" agar sesuai desain --}}
            <h2 class="section-title" style="text-align: left;">Pilih Jenis Kerusakan Lingkungan</h2>
            <div class="categories-grid">
                <div class="category-card" data-category="pencemaran-air">
                    <div class="category-icon blue">
                        💧
                    </div>
                    <h3 class="category-title">Pencemaran Air</h3>
                    <p class="category-description">Polusi air yang mencemari sungai, danau, atau sumber air lainnya</p>
                    <button class="category-select-btn">Pilih Kategori</button>
                </div>

                <div class="category-card" data-category="pencemaran-udara">
                    <div class="category-icon orange">
                        🏭
                    </div>
                    <h3 class="category-title">Pencemaran Udara</h3>
                    <p class="category-description">Polusi udara dari kendaraan, pabrik, atau sumber lainnya</p>
                    <button class="category-select-btn">Pilih Kategori</button>
                </div>

                <div class="category-card" data-category="pencemaran-tanah">
                    <div class="category-icon brown">
                        🌱
                    </div>
                    <h3 class="category-title">Pencemaran Tanah</h3>
                    <p class="category-description">Kontaminasi tanah akibat limbah atau bahan kimia berbahaya</p>
                    <button class="category-select-btn">Pilih Kategori</button>
                </div>

                <div class="category-card" data-category="deforestasi">
                    <div class="category-icon green">
                        🌳
                    </div>
                    <h3 class="category-title">Deforestasi</h3>
                    <p class="category-description">Penebangan hutan secara ilegal atau berlebihan</p>
                    <button class="category-select-btn">Pilih Kategori</button>
                </div>

                <div class="category-card" data-category="kerusakan-ekosistem">
                    <div class="category-icon red">
                        🗑️
                    </div>
                    <h3 class="category-title">Kerusakan Ekosistem</h3>
                    <p class="category-description">Kerusakan habitat dan ekosistem alam</p>
                    <button class="category-select-btn">Pilih Kategori</button>
                </div>

                <div class="category-card" data-category="lainnya">
                    <div class="category-icon gray">
                        ⚠️
                    </div>
                    <h3 class="category-title">Lainnya</h3>
                    <p class="category-description">Masalah lingkungan lainnya yang tidak termasuk kategori di atas</p>
                    <button class="category-select-btn">Pilih Kategori</button>
                </div>
            </div>
        </div>
    </div>

    <div class="notification-section">
        <div class="container">
            <h2 class="section-title">Laporan Terbaru</h2>
            <div class="notification-list">
                <div class="notification-item success">
                    <div class="notification-icon">✅</div>
                    <div class="notification-content">
                        <h4>Laporan Berhasil</h4>
                        <p>Pencemaran air di Sungai Ciliwung telah berhasil dilaporkan</p>
                    </div>
                </div>

                <div class="notification-item info">
                    <div class="notification-icon">📊</div>
                    <div class="notification-content">
                        <h4>Status Update</h4>
                        <p>Laporan deforestasi di Bogor sedang dalam proses verifikasi</p>
                    </div>
                </div>

                <div class="notification-item warning">
                    <div class="notification-icon">⚠️</div>
                    <div class="notification-content">
                        <h4>Perhatian Tinggi</h4>
                        <p>Pencemaran udara di Jakarta memerlukan tindakan segera</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="articles-preview">
        <div class="container">
            <h2 class="section-title">Artikel Edukasi</h2>
            <div class="articles-grid">
                <div class="article-preview-card green">
                    <div class="article-icon">📖</div>
                    <h4>Cara Melaporkan Pencemaran Lingkungan</h4>
                    <p>Panduan lengkap untuk melaporkan masalah lingkungan dengan efektif</p>
                </div>

                <div class="article-preview-card blue">
                    <div class="article-icon">🌍</div>
                    <h4>Dampak Pencemaran Terhadap Ekosistem</h4>
                    <p>Memahami bagaimana pencemaran mempengaruhi keseimbangan alam</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.dataset.category;
            // Di sini Anda biasanya akan menavigasi ke form detail
            // Untuk saat ini, kita akan menampilkan alert
            alert(`Membuka form laporan untuk kategori: ${this.querySelector('.category-title').textContent}`);
            
            // Dalam aplikasi nyata, Anda mungkin melakukan:
            // window.location.href = `/laporan/buat/${category}`;
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryCards = document.querySelectorAll('.category-card');

    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.dataset.category;

            // UBAH DARI ALERT KE NAVIGASI
            // alert(`Membuka form laporan untuk kategori: ${this.querySelector('.category-title').textContent}`);

            // Ganti dengan navigasi ke route langkah 2
            window.location.href = `{{ route('reports.create.step2') }}?kategori=${category}`;
        });
    });
});
</script>
@endsection