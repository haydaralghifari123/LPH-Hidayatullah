<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Portal Klien &middot; LPH Hidayatullah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body class="auth-body">
<div class="auth-wrap wide">
    <div class="auth-left">
        <a href="{{ route('landing') }}" class="brand">
            <div class="brand-mark light">L</div>
            <div>
                <div class="brand-name" style="color:#fff">LPH Hidayatullah</div>
                <div class="brand-tag" style="color:#c8dbf5">Portal Klien</div>
            </div>
        </a>
        <h1>Ajukan Sertifikasi Halal</h1>
        <p>Daftar akun dan mulai proses sertifikasi halal produk Anda.</p>
        <ul class="features">
            <li>Registrasi mudah &amp; cepat</li>
            <li>Portal terintegrasi</li>
            <li>Support tim LPH Hidayatullah</li>
        </ul>
    </div>
    <div class="auth-right">
        <div class="auth-card">
            <h2>Buat Akun Baru</h2>
            <p class="muted">Isi data PIC &amp; perusahaan Anda.</p>
            <form method="POST" action="{{ route('portal.register.submit') }}" class="form">
                @csrf

                <h4 class="section-label">👤 Data PIC</h4>
                <div class="grid-2">
                    <div class="field"><label>Nama Lengkap *</label><input name="nama_pic" value="{{ old('nama_pic') }}" required></div>
                    <div class="field"><label>Email *</label><input type="email" name="email" value="{{ old('email') }}" required></div>
                    <div class="field"><label>No. HP</label><input name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxx"></div>
                    <div class="field"><label>Jabatan</label><input name="jabatan" value="{{ old('jabatan') }}" placeholder="Manager QC"></div>
                    <div class="field"><label>Password *</label><input type="password" name="password" required minlength="6"></div>
                    <div class="field"><label>Konfirmasi Password *</label><input type="password" name="password_confirmation" required></div>
                </div>

                <h4 class="section-label">🏢 Data Perusahaan</h4>
                <div class="grid-2">
                    <div class="field" style="grid-column:span 2"><label>Nama Pelaku Usaha *</label><input name="nama_pelaku_usaha" value="{{ old('nama_pelaku_usaha') }}" required></div>
                    <div class="field"><label>Merek Dagang</label><input name="merek_dagang" value="{{ old('merek_dagang') }}"></div>
                    <div class="field"><label>Jenis Ajuan *</label>
                        <select name="jenis_ajuan" required>
                            <option value="">— Pilih —</option>
                            @foreach (['Makanan & Minuman','Obat & Kosmetik','Bahan Kimiawi','Barang Gunaan','Penyembelihan','Kemasan Produk','Lainnya'] as $j)
                                <option value="{{ $j }}" @selected(old('jenis_ajuan')===$j)>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field"><label>Skala Usaha *</label>
                        <select name="skala" required>
                            @foreach (['Mikro','Kecil','Menengah','Besar'] as $s)
                                <option value="{{ $s }}" @selected(old('skala','Mikro')===$s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field"><label>Jenis Produk</label><input name="jenis_produk" value="{{ old('jenis_produk') }}" placeholder="misal: Snack Kemasan"></div>
                    <div class="field" style="grid-column:span 2"><label>Alamat</label><textarea name="alamat">{{ old('alamat') }}</textarea></div>
                    <div class="field"><label>Kota</label><input name="kota" value="{{ old('kota') }}"></div>
                    <div class="field"><label>Provinsi</label><input name="provinsi" value="{{ old('provinsi') }}"></div>
                    <div class="field" style="grid-column:span 2">
                        <label class="check"><input type="checkbox" name="is_foreign" value="1" @checked(old('is_foreign'))> Klien Luar Negeri (foreign client)</label>
                    </div>
                </div>

                <button class="btn btn-primary block" type="submit">Daftar &amp; Masuk</button>
                <p class="muted small center" style="margin-top:20px">
                    Sudah punya akun? <a href="{{ route('portal.login') }}"><b>Login di sini</b></a>
                </p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
