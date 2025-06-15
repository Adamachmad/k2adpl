@extends('layouts.app')

@section('title', 'Deskripsi & Foto Laporan - EcoWatch')
@section('description', 'Jelaskan detail kejadian dan lampirkan foto sebagai bukti laporan.')

@section('content')
<div class="create-report-container">
    <div class="create-report-header">
        <div class="container">
            <h1 class="page-title">Deskripsi Kejadian & Foto</h1>
            <p class="page-subtitle">Jelaskan detail kejadian dan lampirkan foto sebagai bukti laporan yang kuat.</p>

            <div class="progress-stepper">
                <div class="step completed">
                    <div class="step-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                    <div class="step-label">Jenis Laporan</div>
                </div>
                <div class="step-connector completed"></div>
                <div class="step completed">
                    <div class="step-circle"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                    <div class="step-label">Detail Lokasi</div>
                </div>
                <div class="step-connector completed"></div>
                <div class="step active">
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
            @if (session('errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach (session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form class="report-form" action="{{ route('reports.create.step3.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Input hidden untuk membawa data dari langkah sebelumnya (penting saat kembali dari step 4) --}}
                <input type="hidden" name="category" value="{{ $data['category'] ?? '' }}">
                <input type="hidden" name="provinsi" value="{{ $data['provinsi'] ?? '' }}">
                <input type="hidden" name="kabupaten" value="{{ $data['kabupaten'] ?? '' }}">
                <input type="hidden" name="kecamatan" value="{{ $data['kecamatan'] ?? '' }}">
                <input type="hidden" name="desa" value="{{ $data['desa'] ?? '' }}">
                <input type="hidden" name="alamat" value="{{ $data['alamat'] ?? '' }}">
                
                <div class="form-section">
                    <h3 class="form-section-title">
                        <span class="input-icon">📝</span>
                        Detail Laporan
                    </h3>
                    <div class="form-group">
                        <label for="judul" class="form-label">Judul Laporan <span class="required">*</span></label>
                        <input type="text" id="judul" name="title" class="form-input" placeholder="Contoh: Tumpukan Sampah Liar di Tepi Sungai" value="{{ $data['title'] ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi Rinci <span class="required">*</span></label>
                        <textarea id="deskripsi" name="description" class="form-textarea" rows="6" placeholder="Jelaskan secara rinci apa yang terjadi, siapa yang terlibat (jika tahu), dampaknya, dll." required>{{ $data['description'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">
                        <span class="input-icon">📷</span>
                        Unggah Foto (Maks. 5 foto)
                    </h3>
                    <div class="form-group">
                        <label for="foto-upload" class="file-upload-area">
                            <div class="file-upload-content">
                                <span class="upload-icon">☁️</span>
                                <span class="upload-text">Seret & letakkan file di sini, atau <strong>klik untuk memilih</strong></span>
                                <span class="upload-hint">PNG, JPG, GIF hingga 10MB</span>
                            </div>
                        </label>
                        <input type="file" id="foto-upload" name="photos[]" multiple accept="image/*" class="file-input-hidden">
                        
                        <div class="file-preview-container" id="file-preview">
                            @if (!empty($data['photo_paths']))
                                @foreach ($data['photo_paths'] as $tempPath)
                                    <div class="file-preview-item">
                                        {{-- Menggunakan asset() untuk menampilkan gambar dari storage sementara --}}
                                        <img src="{{ asset('storage/' . $tempPath) }}" alt="Preview Foto">
                                        <span>{{ basename($tempPath) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('reports.create.step2') }}" class="btn-back">← Kembali</a>
                    <button type="submit" class="btn-next">Lanjut ke Konfirmasi →</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.file-input-hidden {
    width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('foto-upload');
    const previewContainer = document.getElementById('file-preview');
    const fileUploadArea = document.querySelector('.file-upload-area');

    if(fileUploadArea && fileInput) {
        fileUploadArea.addEventListener('click', function(e) {
            // Penting: Hindari default event handler dari label agar `fileInput.click()` tidak terpicu dua kali
            e.preventDefault(); 
            fileInput.click();
        });
    }

    if(fileInput) {
        fileInput.addEventListener('change', function () {
            previewContainer.innerHTML = ''; // Kosongkan preview yang ada
            const files = this.files;

            if (files.length > 5) {
                alert('Anda hanya bisa mengunggah maksimal 5 foto. Silakan pilih ulang.');
                this.value = ''; // Reset input file untuk menghapus pilihan yang berlebihan
                return; // Hentikan fungsi
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.classList.add('file-preview-item');
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const fileName = document.createElement('span');
                        fileName.textContent = file.name;
                        
                        previewWrapper.appendChild(img);
                        previewWrapper.appendChild(fileName);
                        previewContainer.appendChild(previewWrapper);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    }
});
</script>
@endsection