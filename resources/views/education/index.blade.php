@extends('layouts.app')

@section('title', 'Artikel Edukasi - EcoWatch')
@section('description', 'Kumpulan artikel dan panduan untuk meningkatkan kesadaran dan pengetahuan tentang isu-isu lingkungan.')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Pusat Edukasi</h1>
            <p class="page-subtitle-alt">Tingkatkan pengetahuan Anda tentang isu lingkungan dan temukan cara untuk berkontribusi.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <div class="articles-grid">
                @forelse($articles as $article)
                    <article class="article-card">
                        {{-- Gambar Artikel --}}
                        <a href="{{ route('education.show', $article->id) }}" class="article-image-link">
                            <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('img/placeholder.jpg') }}" alt="{{ $article->title }}" class="article-image" loading="lazy">
                        </a>
                        <div class="article-content">
                             {{-- Kategori Artikel --}}
                            <div class="article-category-badge">{{ $article->category ?? 'Info' }}</div>
                            
                            {{-- Judul Artikel --}}
                            <h3 class="article-title-link">
                                <a href="{{ route('education.show', $article->id) }}">{{ Str::limit($article->title, 60) }}</a>
                            </h3>

                            {{-- Cuplikan Konten --}}
                            <p class="article-excerpt">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                            
                            {{-- Info Tambahan --}}
                            <div class="article-meta-info">
                                <span>Oleh Tim EcoWatch</span>
                                <span class="separator">·</span>
                                <span>{{ $article->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="w-100 text-center py-5">
                        <p>Belum ada artikel edukasi yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            {{-- Link Paginasi --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
