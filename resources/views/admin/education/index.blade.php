@extends('layouts.app')

@section('title', 'Kelola Edukasi - Admin')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title-alt">Manajemen Edukasi</h1>
                <p class="page-subtitle-alt">Tambah, ubah, atau hapus artikel edukasi untuk komunitas.</p>
            </div>
            <a href="{{ route('admin.education.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Artikel Baru
            </a>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th style="width: 5%;">ID</th>
                                    <th style="width: 15%;">Gambar</th>
                                    <th>Judul</th>
                                    <th style="width: 15%;">Kategori</th>
                                    <th style="width: 15%;">Tanggal Publikasi</th>
                                    <th style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($articles as $article)
                                    <tr>
                                        <td class="text-center align-middle">{{ $article->id }}</td>
                                        <td class="text-center">
                                            <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('img/placeholder.jpg') }}" alt="{{ $article->title }}" style="width: 120px; height: 80px; object-fit: cover; border-radius: 5px;">
                                        </td>
                                        <td class="align-middle">{{ $article->title }}</td>
                                        <td class="align-middle text-center"><span class="badge badge-info p-2">{{ $article->category }}</span></td>
                                        <td class="text-center align-middle">{{ $article->created_at->format('d M Y') }}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('admin.education.edit', $article->id) }}" class="btn btn-sm btn-warning" title="Edit Artikel">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.education.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus artikel ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Artikel">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">Belum ada artikel edukasi yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
