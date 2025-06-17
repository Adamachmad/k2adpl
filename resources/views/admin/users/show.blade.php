@extends('layouts.app')

@section('title', 'Detail Pengguna: ' . $user->nama)

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <a href="{{ route('admin.users.index') }}" class="btn-back-link">← Kembali ke Daftar Pengguna</a>
            <h1 class="page-title-alt mt-2">Detail Pengguna</h1>
            <p class="page-subtitle-alt">Informasi lengkap dan riwayat aktivitas untuk pengguna <strong>{{ $user->nama }}</strong>.</p>
        </div>
    </div>

    <div class="main-content-alt">
        <div class="container">
            <div class="row">
                {{-- Kolom Profil Pengguna --}}
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-body text-center">
                            <div class="user-avatar-initials-lg mx-auto mb-3" style="background-color: #{{ substr(md5($user->nama), 0, 6) }};">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <h4 class="font-weight-bold">{{ $user->nama }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                            @php
                                $roleClass = 'secondary';
                                $roleIcon = 'fa-user';
                                if ($user->role === 'admin') { $roleClass = 'danger'; $roleIcon = 'fa-user-shield'; }
                                elseif ($user->role === 'dinas') { $roleClass = 'info'; $roleIcon = 'fa-building'; }
                            @endphp
                            <span class="role-badge badge-{{ $roleClass }}">
                                <i class="fas {{ $roleIcon }} mr-1"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div class="card-footer text-muted text-center">
                            Bergabung pada: {{ $user->created_at ? $user->created_at->format('d F Y') : 'N/A' }}
                        </div>
                    </div>
                </div>

                {{-- Kolom Riwayat Laporan --}}
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history mr-2"></i>Riwayat Laporan Pengguna
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($user->reports && $user->reports->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($user->reports as $report)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('reports.show', $report->id) }}" target="_blank"><strong>{{ $report->judul }}</strong></a>
                                                <div class="small text-muted">
                                                    ID Laporan: {{ $report->id }}
                                                </div>
                                            </div>
                                            <span class="status-badge {{ strtolower($report->status) }}">{{ $report->status }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-center my-4">Pengguna ini belum pernah membuat laporan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .user-avatar-initials-lg {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 3rem;
    }
    .btn-back-link {
        font-size: 0.9rem;
        color: #6c757d;
        text-decoration: none;
    }
    .btn-back-link:hover {
        text-decoration: underline;
    }
    .list-group-item {
        padding: 1rem 1.25rem;
    }
</style>
@endsection
