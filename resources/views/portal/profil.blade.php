@extends('portal.layout')
@section('title','Profil Perusahaan')
@section('content')
<h1 class="page-title">Profil Perusahaan</h1>
<p class="page-desc">Lengkapi data profil Anda. Data ini akan digunakan di dokumen resmi.</p>

<div class="card">
    <form method="POST" action="{{ route('portal.profil.update') }}" class="form">
        @csrf @method('PUT')

        <h3 class="card-title">Data PIC</h3>
        <div class="grid-2">
            <div class="field"><label>Nama Lengkap PIC *</label><input name="nama_pic" value="{{ old('nama_pic', $client->nama_pic) }}" required></div>
            <div class="field"><label>Email</label><input value="{{ $client->email }}" disabled></div>
            <div class="field"><label>No. HP</label><input name="no_hp" value="{{ old('no_hp', $client->no_hp) }}"></div>
            <div class="field"><label>Jabatan</label><input name="jabatan" value="{{ old('jabatan', $client->jabatan) }}"></div>
        </div>

        <h3 class="card-title" style="margin-top:20px">Data Perusahaan</h3>
        <div class="grid-2">
            <div class="field" style="grid-column:span 2"><label>Nama Pelaku Usaha *</label><input name="nama_pelaku_usaha" value="{{ old('nama_pelaku_usaha', $perusahaan->nama_pelaku_usaha ?? '') }}" required></div>
            <div class="field"><label>Merek Dagang</label><input name="merek_dagang" value="{{ old('merek_dagang', $perusahaan->merek_dagang ?? '') }}"></div>
            <div class="field"><label>NIB (Nomor Induk Berusaha)</label><input name="nib" value="{{ old('nib', $perusahaan->nib ?? '') }}"></div>
            <div class="field"><label>NPWP</label><input name="npwp" value="{{ old('npwp', $perusahaan->npwp ?? '') }}"></div>
            <div class="field"><label>No. SiHalal (BPJPH)</label><input name="no_sihalal" value="{{ old('no_sihalal', $perusahaan->no_sihalal ?? '') }}"></div>
            <div class="field"><label>Business License No (LN)</label><input name="business_license_no" value="{{ old('business_license_no', $perusahaan->business_license_no ?? '') }}"></div>
            <div class="field"><label>Jenis Ajuan *</label>
                <select name="jenis_ajuan" required>
                    @foreach (['Makanan & Minuman','Obat & Kosmetik','Bahan Kimiawi','Barang Gunaan','Penyembelihan','Kemasan Produk','Lainnya'] as $j)
                        <option value="{{ $j }}" @selected(old('jenis_ajuan', $perusahaan->jenis_ajuan ?? '')===$j)>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field"><label>Skala *</label>
                <select name="skala" required>
                    @foreach (['Mikro','Kecil','Menengah','Besar'] as $s)
                        <option value="{{ $s }}" @selected(old('skala', $perusahaan->skala ?? 'Mikro')===$s)>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field" style="grid-column:span 2"><label>Jenis Produk</label><input name="jenis_produk" value="{{ old('jenis_produk', $perusahaan->jenis_produk ?? '') }}"></div>
            <div class="field" style="grid-column:span 2"><label>Alamat</label><textarea name="alamat">{{ old('alamat', $perusahaan->alamat ?? '') }}</textarea></div>
            <div class="field"><label>Kota</label><input name="kota" value="{{ old('kota', $perusahaan->kota ?? '') }}"></div>
            <div class="field"><label>Provinsi</label><input name="provinsi" value="{{ old('provinsi', $perusahaan->provinsi ?? '') }}"></div>
        </div>

        <div class="row" style="justify-content:flex-end;margin-top:20px">
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
