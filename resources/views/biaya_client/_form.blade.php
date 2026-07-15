@csrf
<h3 class="card-title">Informasi Client</h3>
<div class="grid-2">
    <div class="field"><label>No. Biaya</label><input name="no_biaya" value="{{ old('no_biaya', $item->no_biaya ?? $no ?? '') }}" placeholder="auto"></div>
    <div class="field"><label>Tanggal Terbit *</label><input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', optional($item->tanggal_terbit ?? null)->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
    <div class="field" style="grid-column: span 2"><label>Perusahaan *</label>
        <select name="perusahaan_id" required>
            <option value="">— Pilih perusahaan —</option>
            @foreach ($perusahaans as $p)
                <option value="{{ $p->id }}" @selected(old('perusahaan_id', $item->perusahaan_id ?? null)==$p->id)>{{ $p->no_ref }} — {{ $p->nama_pelaku_usaha }}</option>
            @endforeach
        </select>
    </div>
    <div class="field"><label>HOK / Jumlah Produk *</label><input type="number" min="1" name="hok_jumlah_produk" value="{{ old('hok_jumlah_produk', $item->hok_jumlah_produk ?? 1) }}" required></div>
    <div class="field"><label>Status *</label>
        <select name="status" required>
            @foreach (['draft','final'] as $s)
                <option value="{{ $s }}" @selected(old('status', $item->status ?? 'draft')===$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
</div>

<h3 class="card-title" style="margin-top:18px">Rincian Komponen Biaya (Rp)</h3>
<div class="grid-2">
    <div class="field"><label>Biaya BPJPH</label><input type="number" step="1000" name="biaya_bpjph" value="{{ old('biaya_bpjph', $item->biaya_bpjph ?? 0) }}"></div>
    <div class="field"><label>Biaya LPH</label><input type="number" step="1000" name="biaya_lph" value="{{ old('biaya_lph', $item->biaya_lph ?? 0) }}"></div>
    <div class="field"><label>Biaya Transportasi</label><input type="number" step="1000" name="biaya_transportasi" value="{{ old('biaya_transportasi', $item->biaya_transportasi ?? 0) }}"></div>
    <div class="field"><label>Biaya Uji Lab</label><input type="number" step="1000" name="biaya_uji_lab" value="{{ old('biaya_uji_lab', $item->biaya_uji_lab ?? 0) }}"></div>
</div>

<div class="row" style="justify-content:flex-end">
    <a href="{{ route('admin.biaya-client.index') }}" class="btn">Batal</a>
    <button class="btn btn-primary" type="submit">Simpan</button>
</div>
