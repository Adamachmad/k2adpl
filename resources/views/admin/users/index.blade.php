@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Admin')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title-alt">Manajemen Pengguna</h1>
            <p class="page-subtitle-alt">Lihat, kelola, dan hapus pengguna terdaftar dari halaman ini.</p>
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
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table admin-users-table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Pengguna</th>
                                    <th>Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Tanggal Bergabung</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        {{-- Kolom Pengguna (rata kiri agar rapi dengan avatar) --}}
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar-initials mr-3" style="background-color: #{{ substr(md5($user->nama), 0, 6) }};">
                                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $user->nama }}</strong>
                                                    <div class="small text-muted">ID: {{ $user->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Kolom lainnya dengan konten di tengah --}}
                                        <td class="align-middle text-center">{{ $user->email }}</td>
                                        <td class="text-center align-middle">
                                            @php
                                                $roleClass = 'secondary';
                                                $roleIcon = 'fa-user';
                                                if ($user->role === 'admin') {
                                                    $roleClass = 'danger';
                                                    $roleIcon = 'fa-user-shield';
                                                } elseif ($user->role === 'dinas') {
                                                    $roleClass = 'info';
                                                    $roleIcon = 'fa-building';
                                                }
                                            @endphp
                                            <span class="role-badge badge-{{ $roleClass }}">
                                                <i class="fas {{ $roleIcon }} mr-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</td>
                                        <td class="text-center align-middle">
                                            @if(Auth::id() !== $user->id)
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-light mx-1" title="Lihat Detail Pengguna">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Anda yakin ingin menghapus pengguna ini? Semua laporan yang terkait juga akan terhapus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mx-1" title="Hapus Pengguna">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge badge-light">Ini Anda</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <h5>Tidak ada pengguna yang terdaftar.</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gaya untuk Tabel Manajemen Pengguna yang Rapi */
    .admin-users-table {
        border-collapse: collapse;
        width: 100%;
    }

    .admin-users-table thead th {
        background-color: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
        border-left: 1px solid #e3e6f0;
        vertical-align: middle;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        text-align: center; /* Memastikan semua header di tengah */
    }
    
    .admin-users-table thead th:first-child {
        border-left: none;
        text-align: left; /* Header pertama rata kiri */
    }
    
    .admin-users-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .admin-users-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .admin-users-table tbody td {
        border-bottom: 1px solid #e3e6f0;
        border-left: 1px solid #e3e6f0; /* Memberi garis vertikal */
        padding: 1rem;
        vertical-align: middle; 
    }

    .admin-users-table tbody td:first-child {
        border-left: none; /* Menghilangkan garis di sisi paling kiri */
    }
    
    .user-avatar-initials {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .role-badge {
        padding: 0.4em 0.8em;
        border-radius: 20px;
        font-size: 0.75rem;
        color: white;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .role-badge.badge-danger { background-color: #e74a3b; }
    .role-badge.badge-info { background-color: #36b9cc; }
    .role-badge.badge-secondary { background-color: #858796; }
</style>

@endsection
