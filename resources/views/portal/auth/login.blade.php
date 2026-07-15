<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal Klien &middot; LPH Hidayatullah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body class="auth-body">
<div class="auth-wrap">
    <div class="auth-left">
        <a href="{{ route('landing') }}" class="brand">
            <div class="brand-mark light">L</div>
            <div>
                <div class="brand-name" style="color:#fff">LPH Hidayatullah</div>
                <div class="brand-tag" style="color:#c8dbf5">Portal Klien</div>
            </div>
        </a>
        <h1>Selamat Datang</h1>
        <p>Pantau progres sertifikasi halal produk Anda dari satu portal terpusat.</p>
        <ul class="features">
            <li>Upload dokumen persyaratan</li>
            <li>Lihat penawaran biaya real-time</li>
            <li>Download invoice &amp; sertifikat</li>
            <li>Track status pengajuan</li>
        </ul>
    </div>
    <div class="auth-right">
        <div class="auth-card">
            <h2>Login Klien</h2>
            <p class="muted">Silakan masuk dengan akun klien Anda.</p>
            <form method="POST" action="{{ route('portal.login.submit') }}" class="form">
                @csrf
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="pic@perusahaan.com">
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <div class="row between">
                    <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <button class="btn btn-primary block" type="submit">Masuk</button>
            </form>
            <p class="muted small center" style="margin-top:20px">
                Belum punya akun? <a href="{{ route('portal.register') }}"><b>Daftar sekarang</b></a>
                <br>
                <a href="{{ route('landing') }}" style="color:var(--muted)">← Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
