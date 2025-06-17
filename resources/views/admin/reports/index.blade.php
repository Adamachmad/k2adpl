@extends('layouts.app')

@section('title', 'Manajemen Laporan - Admin')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Manajemen Laporan</h1>
            <p class="page-subtitle-alt">Kelola, lihat detail, atau hapus semua laporan yang masuk dari halaman ini.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            {{-- Pesan Sukses --}}
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
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Judul Laporan</th>
                                    <th>Pelapor</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reports as $report)
                                    <tr>
                                        <td class="text-center align-middle">{{ $report->id }}</td>
                                        <td class="text-center">
                                            @php
                                                $photos = $report->fotoBukti;
                                                $photoUrl = ($photos && is_array($photos) && !empty($photos))
                                                            ? asset('storage/' . $photos[0])
                                                            : asset('img/placeholder.jpg');
                                            @endphp
                                            <img src="{{ $photoUrl }}" alt="{{ $report->judul }}" style="width: 120px; height: 80px; object-fit: cover; border-radius: 5px;">
                                        </td>
                                        <td class="align-middle">{{ $report->judul }}</td>
                                        <td class="align-middle">{{ $report->user->name ?? 'N/A' }}</td>
                                        <td class="text-center align-middle">
                                            @php
                                                $statusClass = '';
                                                switch(strtolower($report->status)) {
                                                    case 'selesai': $statusClass = 'success'; break;
                                                    case 'diproses': $statusClass = 'info'; break;
                                                    case 'ditunda': $statusClass = 'warning'; break;
                                                    case 'ditolak': $statusClass = 'danger'; break;
                                                    default: $statusClass = 'secondary';
                                                }
                                            @endphp
                                            <span class="badge badge-{{ $statusClass }} p-2">{{ $report->status }}</span>
                                        </td>
                                        <td class="text-center align-middle">{{ $report->created_at->format('d M Y') }}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-info" target="_blank" title="Lihat Detail Laporan">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Anda yakin ingin menghapus laporan ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">Tidak ada laporan yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination Link --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection