@csrf
<div class="grid-2">
    <div class="field"><label>No. Referensi (auto-generate)</label><input name="no_ref" value="{{ old('no_ref', $perusahaan->no_ref ?? '') }}" placeholder="REF-YYYY-XXXX"></div>
    <div class="field"><label>Nama Pelaku Usaha *</label><input name="nama_pelaku_usaha" value="{{ old('nama_pelaku_usaha', $perusahaan->nama_pelaku_usaha ?? '') }}" required></div>
    <div class="field"><label>Merek Dagang</label><input name="merek_dagang" value="{{ old('merek_dagang', $perusahaan->merek_dagang ?? '') }}"></div>
    <div class="field"><label>Business License No (untuk klien LN)</label><input name="business_license_no" value="{{ old('business_license_no', $perusahaan->business_license_no ?? '') }}"></div>
    <div class="field"><label>Jumlah Produk</label><input type="number" min="1" name="jumlah_produk" value="{{ old('jumlah_produk', $perusahaan->jumlah_produk ?? 1) }}"></div>
    <div class="field"><label>Jumlah Pabrik</label><input type="number" min="1" name="jumlah_pabrik" value="{{ old('jumlah_pabrik', $perusahaan->jumlah_pabrik ?? 1) }}"></div>
    <div class="field"><label>Jumlah Bahan</label><input type="number" min="1" name="jumlah_bahan" value="{{ old('jumlah_bahan', $perusahaan->jumlah_bahan ?? 1) }}"></div>
    <div class="field"><label>Klien Luar Negeri?</label>
        <select name="is_foreign">
            <option value="0" @selected(!old('is_foreign', $perusahaan->is_foreign ?? false))>Tidak (Dalam Negeri)</option>
            <option value="1" @selected(old('is_foreign', $perusahaan->is_foreign ?? false))>Ya (Luar Negeri)</option>
        </select>
    </div>
    <div class="field"><label>Jenis Ajuan *</label><input name="jenis_ajuan" value="{{ old('jenis_ajuan', $perusahaan->jenis_ajuan ?? 'Kemasan Produk') }}" required></div>
    <div class="field"><label>Skala *</label>
        <select name="skala" required>
            @foreach (['Mikro','Kecil','Menengah','Besar'] as $s)
                <option value="{{ $s }}" @selected(old('skala',$perusahaan->skala ?? 'Mikro')===$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="field"><label>Jenis Produk</label><input name="jenis_produk" value="{{ old('jenis_produk', $perusahaan->jenis_produk ?? '') }}"></div>
    <div class="field" style="grid-column: span 2"><label>Alamat</label><textarea name="alamat">{{ old('alamat',$perusahaan->alamat ?? '') }}</textarea></div>
    <div class="field"><label>Kota</label><input name="kota" value="{{ old('kota', $perusahaan->kota ?? '') }}"></div>
    <div class="field"><label>Provinsi</label><input name="provinsi" value="{{ old('provinsi', $perusahaan->provinsi ?? '') }}"></div>
    <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email', $perusahaan->email ?? '') }}"></div>
    <div class="field"><label>No. Telepon</label><input name="no_telepon" value="{{ old('no_telepon', $perusahaan->no_telepon ?? '') }}"></div>
    <div class="field"><label>Status *</label>
        <select name="status" required>
            @foreach (['Pengajuan','Verifikasi','Audit Berjalan','Selesai','Ditolak'] as $s)
                <option value="{{ $s }}" @selected(old('status', $perusahaan->status ?? 'Pengajuan')===$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row" style="justify-content:flex-end">
    <a href="{{ route('admin.perusahaan.index') }}" class="btn">Batal</a>
    <button class="btn btn-primary" type="submit">Simpan</button>
</div>
