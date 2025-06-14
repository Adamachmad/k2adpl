@extends('layouts.app')

@section('title', $article['title'] . ' - Edukasi EcoWatch')
@section('description', 'Baca artikel lengkap tentang ' . $article['title'] . ' dan tingkatkan pengetahuan lingkungan Anda.')

@section('content')
<div class="page-container">
    <div class="main-content-alt">
        <div class="container" style="max-width: 800px;">
            <article class="article-detail-content">
                <header class="article-detail-header">
                    <span class="article-category-badge">{{ $article['category'] }}</span>
                    <h1 class="article-detail-title">{{ $article['title'] }}</h1>
                    <div class="article-detail-meta">
                        <span>Oleh <strong>{{ $article['author'] }}</strong></span>
                        <span class="meta-separator">|</span>
                        <span>Dipublikasikan pada {{ $article['publish_date'] }}</span>
                        <span class="meta-separator">|</span>
                        <span>📖 {{ $article['reading_time'] }}</span>
                    </div>
                </header>

                <figure class="article-detail-figure">
                    {{-- PERBAIKAN: Memastikan gambar dinamis dari controller --}}
                    <img src="{{ $article['image_url'] }}" alt="{{ $article['title'] }}" class="article-detail-image">
                </figure>

                <section class="article-body">
                    <p>{{ $article['content'] }}</p>
                    {{-- Contoh paragraf tambahan --}}
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </section>
            </article>
        </div>
    </div>
</div>
@endsection