<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Register - EcoWatch</title>
    <meta name="description" content="Daftar ke EcoWatch untuk mulai melaporkan masalah lingkungan dan berkontribusi untuk masa depan yang lebih hijau.">
    
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
                <a href="{{ route('login') }}" class="tab-item">Login</a>
                <a href="{{ route('register') }}" class="tab-item active">Register</a>
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

            <!-- Right Side - Register Form -->
            <div class="login-section">
                <div class="login-form-container">
                    <div class="form-header">
                        <div class="form-icon">🌍</div>
                        <h2 class="form-title">Daftar ke EcoWatch</h2>
                        <p class="form-subtitle">Bergabunglah untuk melaporkan masalah lingkungan</p>
                    </div>

                    <form class="login-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-input @error('name') error @enderror" 
                                placeholder="Masukkan nama lengkap Anda"
                                value="{{ old('name') }}"
                                required 
                                autofocus
                            >
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

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
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    👁️
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="password-input-container">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="form-input @error('password_confirmation') error @enderror" 
                                    placeholder="Konfirmasi password Anda"
                                    required
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    👁️
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-options">
                            <label class="checkbox-container">
                                <input type="checkbox" name="terms" required>
                                <span class="checkmark"></span>
                                Saya setuju dengan <a href="#" class="forgot-password">Syarat & Ketentuan</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="login-button">
                            Daftar Sekarang
                        </button>

                        <!-- Login Link -->
                        <div class="register-link">
                            Sudah punya akun? <a href="{{ route('login') }}" class="register-link-text">Masuk sekarang</a>
                        </div>

                        <!-- Alternative Buttons -->
                        <div class="alternative-buttons">
                            <a href="{{ route('login') }}" class="alt-register-btn">Masuk</a>
                            <button type="submit" class="alt-login-btn">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleButton = passwordInput.nextElementSibling;
            
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
