@extends('layouts.app')

@section('title', $article->title . ' - EcoWatch')
@section('description', Str::limit(strip_tags($article->content), 150))

@section('content')
<div class="page-container">
    <div class="main-content-alt">
        <div class="container" style="max-width: 800px;">
            <article class="article-detail-content">
                {{-- Kategori & Tanggal --}}
                <div class="article-detail-meta">
                    <span class="badge badge-primary p-2">{{ $article->category }}</span>
                    <span class="mx-2">·</span>
                    <span>Dipublikasikan pada {{ $article->created_at->format('d F Y') }}</span>
                </div>

                {{-- Judul Artikel --}}
                <h1 class="article-detail-title">{{ $article->title }}</h1>

                {{-- Gambar Utama --}}
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-detail-image">
                @endif

                {{-- Isi Konten --}}
                <div class="article-detail-body">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </article>

             {{-- Tombol Kembali --}}
            <div class="text-center mt-5">
                <a href="{{ route('education.index') }}" class="btn btn-secondary">← Kembali ke Semua Artikel</a>
            </div>
        </div>
    </div>
</div>

<style>
    .article-detail-content { margin-top: 2rem; }
    .article-detail-meta { margin-bottom: 1rem; color: #6c757d; font-size: 0.9rem; }
    .article-detail-title { font-size: 2.5rem; font-weight: 700; margin-bottom: 1.5rem; }
    .article-detail-image { width: 100%; height: auto; border-radius: 12px; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .article-detail-body { font-size: 1.1rem; line-height: 1.8; color: #333; }
</style>
@endsection
