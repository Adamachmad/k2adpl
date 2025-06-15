@extends('layouts.app')

@section('title', 'Login - EcoWatch')

@section('content')
<div class="login-container">
    <div class="login-content">
        <div class="welcome-section">
            <div class="welcome-content">
                <a href="{{ route('home') }}" class="logo mb-4" style="text-decoration: none;">
                    <img src="{{ asset('img/logo-ecowatch.svg') }}" alt="Logo EcoWatch" class="logo-svg" style="height: 50px;">
                </a>
                <h1 class="welcome-title">Bergabunglah dengan Gerakan Peduli Lingkungan</h1>
                <p class="welcome-description">Setiap laporan, setiap aksi, dan setiap suara Anda membantu menciptakan bumi yang lebih hijau dan sehat untuk generasi mendatang.</p>
                <div class="feature-cards">
                    <div class="feature-card">
                        <div class="feature-icon blue">📸</div>
                        <div class="feature-content">
                            <h3 class="feature-title">Laporkan dengan Mudah</h3>
                            <p class="feature-description">Ambil foto, beri deskripsi, dan kirim laporan kerusakan lingkungan dalam hitungan menit.</p>
                        </div>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon green">📈</div>
                        <div class="feature-content">
                            <h3 class="feature-title">Pantau Progres</h3>
                            <p class="feature-description">Lihat status dan tindak lanjut dari setiap laporan yang Anda dan komunitas kirimkan.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="back-button">← Kembali ke Halaman Utama</a>
            </div>
        </div>

        <div class="login-section">
            <div class="login-form-container">
                <div class="form-header">
                    <h2 class="form-title">Selamat Datang Kembali</h2>
                    <p class="form-subtitle">Silakan masukkan detail Anda untuk masuk.</p>
                </div>

                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-input-container">
                            <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>
                        <a href="#" class="forgot-password">Lupa Password?</a>
                    </div>

                    <button type="submit" class="login-button">
                        Masuk
                    </button>
                </form>

                <p class="register-link mt-4">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="register-link-text">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .alert{padding:1rem;margin-bottom:1rem;border-radius:.5rem;border:1px solid transparent}.alert-danger{color:#721c24;background-color:#f8d7da;border-color:#f5c6cb}.alert-danger ul{margin:0;padding-left:1.2rem}.mb-4{margin-bottom:1.5rem}.mt-4{margin-top:1.5rem}
</style>
@endsection