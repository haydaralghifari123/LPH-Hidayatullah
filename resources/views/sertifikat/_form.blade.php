@csrf
<div class="grid-2">
    <div class="field"><label>No. Sertifikat (auto)</label><input name="no_sertifikat" value="{{ old('no_sertifikat', $item->no_sertifikat ?? '') }}" placeholder="LPH-YYYY-XXXX"></div>
    <div class="field"><label>Tanggal Terbit *</label><input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', optional($item->tanggal_terbit ?? null)->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
    <div class="field" style="grid-column: span 2"><label>Pelaku Usaha *</label>
        <select name="perusahaan_id" required>
            <option value="">— Pilih pengajuan —</option>
            @foreach ($perusahaans as $p)
                <option value="{{ $p->id }}" @selected(old('perusahaan_id', $item->perusahaan_id ?? null)==$p->id)>{{ $p->no_ref }} — {{ $p->nama_pelaku_usaha }}</option>
            @endforeach
        </select>
    </div>
    <div class="field"><label>Jenis Daftar *</label>
        <select name="jenis_daftar" required>
            @foreach (['Baru','Perpanjangan','Perubahan'] as $s)
                <option value="{{ $s }}" @selected(old('jenis_daftar', $item->jenis_daftar ?? 'Baru')===$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="field"><label>Jenis Produk</label><input name="jenis_produk" value="{{ old('jenis_produk', $item->jenis_produk ?? '') }}"></div>
    <div class="field"><label>Merek Dagang</label><input name="merek_dagang" value="{{ old('merek_dagang', $item->merek_dagang ?? '') }}"></div>
    <div class="field"><label>Tanggal Expired</label><input type="date" name="tanggal_expired" value="{{ old('tanggal_expired', optional($item->tanggal_expired ?? null)->format('Y-m-d')) }}"></div>
    <div class="field"><label>Status *</label>
        <select name="status" required>
            @foreach (['Menunggu','Terbit','Expired'] as $s)
                <option value="{{ $s }}" @selected(old('status', $item->status ?? 'Terbit')===$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="field" style="grid-column: span 2"><label>Upload Dokumen PDF (max 5MB)</label><input type="file" name="file_pdf" accept="application/pdf"></div>
</div>
<div class="row" style="justify-content:flex-end">
    <a href="{{ route('admin.sertifikat.index') }}" class="btn">Batal</a>
    <button class="btn btn-primary" type="submit">Simpan Sertifikat</button>
</div>
