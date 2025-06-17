@extends('layouts.app')

@section('title', 'Buat Artikel Edukasi Baru')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Buat Artikel Baru</h1>
            <p class="page-subtitle-alt">Isi formulir di bawah untuk mempublikasikan konten edukasi baru.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <div class="card shadow-lg mb-4" style="max-width: 800px; margin: auto;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.education.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Judul Artikel --}}
                        <div class="form-group mb-4">
                            <label for="title" class="form-label">Judul Artikel</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: 5 Cara Mudah Memulai Daur Ulang">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="form-group mb-4">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                <option value="Daur Ulang" {{ old('category') == 'Daur Ulang' ? 'selected' : '' }}>Daur Ulang</option>
                                <option value="Konservasi" {{ old('category') == 'Konservasi' ? 'selected' : '' }}>Konservasi</option>
                                <option value="Pencemaran" {{ old('category') == 'Pencemaran' ? 'selected' : '' }}>Pencemaran</option>
                                <option value="Gaya Hidup Hijau" {{ old('category') == 'Gaya Hidup Hijau' ? 'selected' : '' }}>Gaya Hidup Hijau</option>
                                <option value="Berita Lingkungan" {{ old('category') == 'Berita Lingkungan' ? 'selected' : '' }}>Berita Lingkungan</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Isi Konten --}}
                        <div class="form-group mb-4">
                            <label for="content" class="form-label">Isi Konten</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required placeholder="Tulis isi lengkap artikel Anda di sini...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload Gambar --}}
                        <div class="form-group mb-4">
                            <label class="form-label">Gambar Utama</label>
                            <div class="custom-file-upload">
                                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" onchange="updateFileName(this)">
                                <label for="image" class="custom-file-label">
                                    <i class="fas fa-upload"></i>
                                    <span id="file-name-display">Pilih sebuah gambar...</span>
                                </label>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="form-actions mt-5 d-flex justify-content-end">
                            <a href="{{ route('admin.education.index') }}" class="btn btn-secondary mr-3">Batal</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Publikasikan Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateFileName(input) {
        const fileNameDisplay = document.getElementById('file-name-display');
        if (input.files && input.files.length > 0) {
            fileNameDisplay.textContent = input.files[0].name;
        } else {
            fileNameDisplay.textContent = 'Pilih sebuah gambar...';
        }
    }
</script>
@endpush
