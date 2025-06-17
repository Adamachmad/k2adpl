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
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.education.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Judul Artikel</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Pilih Kategori...</option>
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

                        <div class="form-group">
                            <label for="content">Isi Konten</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Utama</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.education.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Publikasikan Artikel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
