@csrf
<h3 class="card-title">Informasi Invoice</h3>
<div class="grid-2">
    <div class="field"><label>No. Invoice</label><input name="no_invoice" value="{{ old('no_invoice', $item->no_invoice ?? $no ?? '') }}" placeholder="auto"></div>
    <div class="field"><label>Tanggal Invoice *</label><input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', optional($item->tanggal_invoice ?? null)->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
    <div class="field" style="grid-column: span 2"><label>Pelaku Usaha *</label>
        <select name="perusahaan_id" required>
            <option value="">— Pilih perusahaan —</option>
            @foreach ($perusahaans as $p)
                <option value="{{ $p->id }}" @selected(old('perusahaan_id', $item->perusahaan_id ?? null)==$p->id)>{{ $p->no_ref }} — {{ $p->nama_pelaku_usaha }}</option>
            @endforeach
        </select>
    </div>
    <div class="field"><label>HOK / Jumlah Produk *</label><input type="number" min="1" name="hok_jumlah_produk" value="{{ old('hok_jumlah_produk', $item->hok_jumlah_produk ?? 1) }}" required></div>
    <div class="field"><label>Skema Pembayaran *</label>
        <select name="skema_pembayaran" required>
            @foreach (['Lunas / Sekali Bayar','DP 50% / Pelunasan','Termin 3x'] as $s)
                <option value="{{ $s }}" @selected(old('skema_pembayaran', $item->skema_pembayaran ?? 'Lunas / Sekali Bayar')===$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
</div>

<h3 class="card-title" style="margin-top:18px">Detail Tagihan</h3>
<div class="field"><label>Keterangan</label><textarea name="keterangan">{{ old('keterangan', $item->keterangan ?? 'Tagihan biaya sertifikasi halal') }}</textarea></div>
<div class="grid-2">
    <div class="field"><label>Total Tagihan (Rp) *</label><input type="number" step="1000" name="total_tagihan" value="{{ old('total_tagihan', $item->total_tagihan ?? 0) }}" required></div>
    <div class="field"><label>Diskon (Rp)</label><input type="number" step="1000" name="diskon" value="{{ old('diskon', $item->diskon ?? 0) }}"></div>
    <div class="field"><label>Status *</label>
        <select name="status" required>
            @foreach (['draft','terkirim','lunas'] as $s)
                <option value="{{ $s }}" @selected(old('status', $item->status ?? 'draft')===$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row" style="justify-content:flex-end">
    <a href="{{ route('admin.invoice.index') }}" class="btn">Batal</a>
    <button class="btn btn-primary" type="submit">Simpan Invoice</button>
</div>
