<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') &middot; LPH Hidayatullah</title>
    <meta name="description" content="Lembaga Pemeriksa Halal Hidayatullah — LPH Utama dengan pemeriksaan semua ruang lingkup produk halal di Indonesia.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ route('landing') }}" class="brand">
                <img src="{{ asset('images/logo.webp') }}" alt="LPH Hidayatullah" style="height:44px;width:auto">
            </a>
            <nav class="main-nav">
                <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('landing.tentang') }}" class="{{ request()->routeIs('landing.tentang') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ route('landing.layanan') }}" class="{{ request()->routeIs('landing.layanan') ? 'active' : '' }}">Layanan</a>
                <a href="{{ route('landing.kontak') }}" class="{{ request()->routeIs('landing.kontak') ? 'active' : '' }}">Kontak</a>
            </nav>
            <div class="header-actions">
                <a href="{{ route('portal.login') }}" class="btn btn-ghost">Portal Klien</a>
                <a href="{{ route('admin.login') }}" class="btn btn-primary">Login Admin</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <img src="{{ asset('images/logo.webp') }}" alt="LPH Hidayatullah" style="height:52px;width:auto;background:#fff;padding:6px 10px;border-radius:8px;margin-bottom:14px">
                <p style="color:#a3b5cf;font-size:13px;line-height:1.7">Lembaga Pemeriksa Halal terakreditasi LPH UTAMA dengan izin BPJPH untuk pemeriksaan seluruh ruang lingkup produk halal di Indonesia.</p>
            </div>
            <div>
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    <li><a href="{{ route('landing.tentang') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('landing.layanan') }}">Layanan</a></li>
                    <li><a href="{{ route('landing.kontak') }}">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4>Akses</h4>
                <ul>
                    <li><a href="{{ route('portal.login') }}">Portal Klien</a></li>
                    <li><a href="{{ route('portal.register') }}">Daftar Akun Klien</a></li>
                    <li><a href="{{ route('admin.login') }}">Login Admin/Staff</a></li>
                </ul>
            </div>
            <div>
                <h4>Kontak</h4>
                <ul>
                    <li class="foot-line"><x-icon name="phone" size="14"/> 0822-1111-5361</li>
                    <li class="foot-line"><x-icon name="mail" size="14"/> Customercare@lphhidayatullah.id</li>
                    <li class="foot-line"><x-icon name="map-pin" size="14"/> Jl. Cipinang Cempedak No.14, Jakarta Timur</li>
                </ul>
            </div>
        </div>
        <div class="container footer-bottom">
            <div>&copy; {{ date('Y') }} LPH Hidayatullah. Semua hak dilindungi.</div>
            <div>v1.0 &middot; Sistem Manajemen Sertifikasi Halal</div>
        </div>
    </footer>
    <script>
    (function () {
        var car = document.getElementById('heroCarousel');
        if (!car) return;
        var slides = car.querySelectorAll('.carousel-slide');
        var dots = car.querySelectorAll('.dot');
        var idx = 0;
        var count = slides.length;
        window.carouselGoTo = function (i) {
            slides[idx].classList.remove('active');
            dots[idx].classList.remove('active');
            idx = (i + count) % count;
            slides[idx].classList.add('active');
            dots[idx].classList.add('active');
        };
        window.carouselNav = function (dir) { carouselGoTo(idx + dir); };
        setInterval(function () { carouselNav(1); }, 5000);
    })();
    </script>
</body>
</html>
