<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Daftar Akun - EcoWatch')</title>
    <meta name="description" content="Daftar dan mulai laporkan kerusakan lingkungan di sekitar Anda.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

</head>
<body>
<div class="auth-page-container">
    <div class="auth-content-wrapper">
        {{-- Sisi Kiri: Greeting Section --}}
        <div class="auth-greeting-section">
            <a href="{{ route('home') }}" class="auth-logo-link">
                {{-- Menggunakan URL logo yang lebih stabil atau placeholder teks --}}
                <img src="https://via.placeholder.com/100x50?text=EcoWatch+Logo" alt="EcoWatch Logo" class="auth-logo-img">
                {{-- ATAU, jika gambar logo EcoWatch Anda sendiri tetap bermasalah, gunakan teks saja: --}}
                {{-- <span style="font-size: 2rem; font-weight: 700; color: #22c55e;">EcoWatch</span> --}}
            </a>
            <h1 class="greeting-title">Selamat Datang di EcoWatch</h1>
            <p class="greeting-subtitle">Bergabunglah untuk melaporkan masalah lingkungan dan menjadi bagian dari solusi.</p>

            <div class="auth-feature-list">
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        {{-- Menggunakan SVG inline sederhana atau Emoji sebagai fallback pasti --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        {{-- Atau Emoji: ⚡ --}}
                    </div>
                    <p class="auth-feature-text"><strong>Laporan Real-time</strong><br>Sampaikan laporan Anda dengan cepat dan mudah.</p>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        {{-- Atau Emoji: 🤝 --}}
                    </div>
                    <p class="auth-feature-text"><strong>Kolaborasi</strong><br>Terhubung dengan pihak berwenang dan organisasi terkait.</p>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                        {{-- Atau Emoji: 📈 --}}
                    </div>
                    <p class="auth-feature-text"><strong>Dampak Nyata</strong><br>Kontribusi Anda penting untuk perubahan yang lebih baik.</p>
                </div>
            </div>
            <p class="auth-back-link">
                <a href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 5px;">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                    Kembali
                </a>
            </p>
        </div>

        {{-- Sisi Kanan: Form Section --}}
        <div class="auth-form-section">
            <div class="auth-form-inner-wrapper">
                <h2 class="form-main-title">Daftar ke EcoWatch</h2>
                <p class="form-main-subtitle">Bergabunglah untuk melaporkan masalah lingkungan.</p>

                <form class="auth-form" method="POST" action="{{ route('register.post') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" required autocomplete="name" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autocomplete="email">
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Daftar Sebagai</label>
                        <select id="role" name="role" class="form-input" required>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>LSM / Warga Biasa (Pelapor)</option>
                            <option value="dinas" {{ old('role') == 'dinas' ? 'selected' : '' }}>Pihak Dinas Terkait</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-input" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="auth-button primary">
                        Daftar
                    </button>
                </form>

                <p class="auth-link-bottom">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="auth-link-text">Masuk sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>