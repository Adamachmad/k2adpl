<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - EcoWatch</title>
    <meta name="description" content="Masuk ke EcoWatch untuk melaporkan masalah lingkungan dan berkontribusi untuk masa depan yang lebih hijau.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-poppins antialiased">
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">🌍</div>
                <span class="logo-text">EcoWatch</span>
            </a>
            <div class="header-tabs">
                <a href="{{ route('login') }}" class="tab-item active">Login</a>
                <a href="{{ route('register') }}" class="tab-item">Register</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="login-content">
            <!-- Left Side - Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-content">
                    <h1 class="welcome-title">
                        Selamat Datang<br>
                        di EcoWatch
                    </h1>
                    <p class="welcome-description">
                        Platform pelaporan lingkungan yang menghubungkan masyarakat dengan pemerintah untuk menciptakan lingkungan yang lebih bersih dan sehat.
                    </p>

                    <!-- Feature Cards -->
                    <div class="feature-cards">
                        <div class="feature-card">
                            <div class="feature-icon blue">
                                📊
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Laporan Real-time</h3>
                                <p class="feature-description">Pantau dan laporkan masalah lingkungan secara langsung</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon orange">
                                🤝
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Kolaborasi</h3>
                                <p class="feature-description">Bekerja sama dengan pemerintah dan LSM</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon green">
                                🌱
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Dampak Nyata</h3>
                                <p class="feature-description">Ciptakan perubahan positif untuk lingkungan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ route('home') }}" class="back-button">
                        ← Kembali
                    </a>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-section">
                <div class="login-form-container">
                    <div class="form-header">
                        <div class="form-icon">🌍</div>
                        <h2 class="form-title">Masuk ke EcoWatch</h2>
                        <p class="form-subtitle">Bergabunglah untuk melaporkan masalah lingkungan</p>
                    </div>

                    <form class="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input @error('email') error @enderror"
                                placeholder="Masukkan email Anda"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-input-container">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-input @error('password') error @enderror"
                                    placeholder="Masukkan password Anda"
                                    required
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    👁️
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="form-options">
                            <label class="checkbox-container">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                Ingat saya
                            </label>
                            <a href="#" class="forgot-password">Lupa password?</a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="login-button">
                            Masuk
                        </button>

                        <!-- Register Link -->
                        <div class="register-link">
                            Belum punya akun? <a href="{{ route('register') }}" class="register-link-text">Daftar sekarang</a>
                        </div>

                        <!-- Alternative Buttons -->
                        <div class="alternative-buttons">
                            <button type="submit" class="alt-login-btn">Masuk</button>
                            <a href="{{ route('register') }}" class="alt-register-btn">Daftar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }
    </script>

    @vite(['resources/js/app.js'])
</body>
</html>
