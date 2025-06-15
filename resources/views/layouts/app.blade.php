<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'EcoWatch')</title>
    <meta name="description" content="@yield('description', 'Laporkan dan pantau masalah lingkungan di sekitar Anda.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- TAMBAHKAN BARIS INI UNTUK FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    @vite('resources/css/app.css')

</head>
<body>

    <header class="header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('img/logo-ecowatch.svg') }}" alt="Logo EcoWatch" class="logo-svg">
            </a>

            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <div class="nav-dropdown">
                    <button class="nav-link dropdown-toggle">Laporan</button>
                    <div class="dropdown-menu">
                        <a href="{{ route('reports.public') }}" class="dropdown-item">Laporan Publik</a>
                        @auth
                        <a href="{{ route('reports.index') }}" class="dropdown-item">Laporan Saya</a>
                        @endauth
                    </div>
                </div>
                <a href="{{ route('education.index') }}" class="nav-link">Edukasi</a>
            </nav>

            <div class="header-actions">
                <div class="notification-container">
                    <button class="notification-btn" id="notification-btn" aria-label="Notifikasi">
                        <span>🔔</span>
                        <div class="notification-badge">3</div>
                    </button>
                    <div class="notification-overlay" id="notification-overlay">
                        <div class="notification-header">
                            <h3>Notifikasi</h3>
                            <span class="notification-count">3 Baru</span>
                        </div>
                        <div class="notification-list">
                            <a href="{{ route('reports.show', ['report' => 3]) }}" class="notification-item unread">
                                <div class="notification-icon success">✓</div>
                                <div class="notification-content">
                                    <h4>Laporan Selesai</h4>
                                    <p>Laporan Anda tentang "Pembuangan Limbah Padi" telah selesai ditangani.</p>
                                    <span class="notification-time">15 menit lalu</span>
                                </div>
                            </a>
                            <a href="{{ route('reports.show', ['report' => 2]) }}" class="notification-item unread">
                                <div class="notification-icon info">💬</div>
                                <div class="notification-content">
                                    <h4>Komentar Baru</h4>
                                    <p>Budi mengomentari laporan Anda: "Penggundulan Hutan Liar di Wawonii".</p>
                                    <span class="notification-time">1 jam lalu</span>
                                </div>
                            </a>
                            <a href="{{ route('reports.show', ['report' => 4]) }}" class="notification-item">
                                <div class="notification-icon warning">⚠️</div>
                                <div class="notification-content">
                                    <h4>Status Diperbarui</h4>
                                    <p>Laporan Anda tentang "Polusi Smelter PT VDNI" sedang dalam proses.</p>
                                    <span class="notification-time">3 jam lalu</span>
                                </div>
                            </a>
                        </div>
                        <div class="notification-footer">
                            <a href="#" class="view-all-btn">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>
                
                @auth
                <a href="{{ route('reports.create') }}" class="create-report-btn">
                    <span class="btn-icon">+</span>
                    <span>Buat Laporan</span>
                </a>
                <div class="user-dropdown">
                    <button class="user-avatar-button" id="user-menu-button">
                        <div class="user-avatar">
                            {{-- MENGGUNAKAN Auth::user()->nama --}}
                            <span>{{ Auth::user()->nama ? strtoupper(substr(Auth::user()->nama, 0, 1)) : '?' }}</span>
                        </div>
                        {{-- MENGGUNAKAN Auth::user()->nama --}}
                        <span class="user-name">Halo, {{ Auth::user()->nama ? strtok(Auth::user()->nama, " ") : 'Pengguna' }}</span>
                        <span class="dropdown-caret">▾</span>
                    </button>
                    <div class="user-dropdown-menu" id="user-menu">
                        <a href="{{ route('home') }}" class="dropdown-item">Dashboard</a>
                        <a href="{{ route('reports.index') }}" class="dropdown-item">Laporan Saya</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item logout">Logout</button>
                        </form>
                    </div>
                </div>

                @else
                <a href="{{ route('login') }}" class="btn-secondary">Masuk</a>
                <a href="{{ route('register') }}" class="create-report-btn">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-company">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <img src="{{ asset('img/logo-eco-watch.png') }}" alt="Logo EcoWatch" width="20" height="20">
                        </div>
                        <span class="logo-text">EcoWatch</span>
                    </div>
                    <p class="company-description">
                        Platform komunitas untuk memantau, melaporkan, dan mengatasi masalah lingkungan demi masa depan yang lebih hijau.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">FB</a>
                        <a href="#" class="social-link" aria-label="Twitter">TW</a>
                        <a href="#" class="social-link" aria-label="Instagram">IG</a>
                    </div>
                </div>
                <div class="footer-nav">
                    <h3 class="footer-title">Navigasi</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                        <li><a href="{{ route('reports.public') }}" class="footer-link">Laporan Publik</a></li>
                        <li><a href="{{ route('reports.index') }}" class="footer-link">Laporan Saya</a></li>
                        <li><a href="{{ route('education.index') }}" class="footer-link">Edukasi</a></li>
                    </ul>
                </div>
                <div class="footer-help">
                    <h3 class="footer-title">Bantuan</h3>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">FAQ</a></li>
                        <li><a href="#" class="footer-link">Hubungi Kami</a></li>
                        <li><a href="#" class="footer-link">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="footer-link">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="copyright">&copy; {{ date('Y') }} EcoWatch. Semua Hak Cipta Dilindungi.</p>
                <div class="footer-bottom-links">
                    <a href="#" class="footer-bottom-link">Terms</a>
                    <a href="#" class="footer-bottom-link">Privacy</a>
                    <a href="#" class="footer-bottom-link">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Notifikasi
            const notifBtn = document.getElementById('notification-btn');
            const notifOverlay = document.getElementById('notification-overlay');

            if (notifBtn && notifOverlay) {
                notifBtn.addEventListener('click', function(event) {
                    event.stopPropagation();
                    notifOverlay.classList.toggle('show');
                });
            }

            // Dropdown User Profile
            const userMenuButton = document.getElementById('user-menu-button'); // Tombol pemicu dropdown
            const userDropdownContainer = document.querySelector('.user-dropdown'); // Kontainer utama user dropdown

            if (userMenuButton && userDropdownContainer) {
                userMenuButton.addEventListener('click', function(event) {
                    event.stopPropagation(); // Mencegah event klik menyebar
                    userDropdownContainer.classList.toggle('open'); // Toggle class 'open' pada kontainer
                });

                // Menutup dropdown jika mengklik di luar area user dropdown
                document.addEventListener('click', function(event) {
                    if (userDropdownContainer && !userDropdownContainer.contains(event.target)) {
                        userDropdownContainer.classList.remove('open');
                    }
                });
            }

            // Menutup semua dropdown lainnya (notifikasi) jika mengklik di luar area
            document.addEventListener('click', function(event) {
                if (notifOverlay && !notifOverlay.contains(event.target) && !notifBtn.contains(event.target)) {
                    notifOverlay.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>