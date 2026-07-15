<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk &middot; LPH Hidayatullah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="login-body">
<div class="login-wrap">
    <div class="login-left">
        <div class="login-brand">
            <div class="brand-logo lg">L</div>
            <div>
                <div class="brand-title">LPH HIDAYATULLAH</div>
                <div class="brand-sub">Sertifikat Halal Indonesia</div>
            </div>
        </div>
        <h1 class="login-heading">Selamat Datang Kembali</h1>
        <p class="login-tag">Sistem Manajemen Sertifikasi Halal yang membantu Anda mengelola dokumen, audit, dan keuangan dalam satu platform terpusat.</p>
        <ul class="features">
            <li>Dokumen klien terkelola dalam satu portal</li>
            <li>Penugasan auditor adil &amp; otomatis</li>
            <li>Pemilahan biaya tanpa tumpang tindih</li>
            <li>Laporan PDF satu klik</li>
        </ul>
        <div class="login-footer-note">&copy; {{ date('Y') }} LPH Hidayatullah &middot; v1.0</div>
    </div>
    <div class="login-right">
        <div class="card login-card">
            <h2>Masuk ke Akun</h2>
            <p class="muted">Silakan masuk dengan kredensial Anda untuk melanjutkan.</p>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="form">
                @csrf
                <div class="role-toggle" role="tablist">
                    <label class="role-pill">
                        <input type="radio" name="role" value="operasional" {{ old('role', 'operasional') === 'operasional' ? 'checked' : '' }}>
                        <span>Operasional</span>
                    </label>
                    <label class="role-pill">
                        <input type="radio" name="role" value="keuangan" {{ old('role') === 'keuangan' ? 'checked' : '' }}>
                        <span>Keuangan</span>
                    </label>
                </div>

                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="username" required autofocus>
                </div>
                <div class="field">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="row between">
                    <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
                    <a href="#" class="muted small">Lupa kata sandi?</a>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <button type="submit" class="btn btn-primary block">Masuk</button>
            </form>

            <p class="muted small center">Belum punya akun? Hubungi admin sistem<br>atau email <b>admin@lph-hidayatullah.id</b></p>
        </div>
    </div>
</div>
</body>
</html>
