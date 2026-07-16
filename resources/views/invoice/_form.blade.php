@csrf
<h3 class="card-title">Informasi Invoice</h3>
<div class="grid-2">
    <div class="field"><label>No. Invoice</label><input name="no_invoice" value="{{ old('no_invoice', $item->no_invoice ?? $no ?? '') }}" placeholder="auto"></div>
    <div class="field"><label>Tanggal Invoice *</label><input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', optional($item->tanggal_invoice ?? null)->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
    <div class="field" style="grid-column: span 2"><label>Pelaku Usaha *</label>
        <select name="perusahaan_id" id="perusahaanSelect" required data-autofill-url="{{ url('admin/api/perusahaan') }}">
            <option value="">— Pilih perusahaan —</option>
            @foreach ($perusahaans as $p)
                <option value="{{ $p->id }}" @selected(old('perusahaan_id', $item->perusahaan_id ?? null)==$p->id)>{{ $p->no_ref }} — {{ $p->nama_pelaku_usaha }}</option>
            @endforeach
        </select>
        <small class="muted" id="autofillInfo" style="font-size:11px;color:var(--muted);margin-top:4px;display:none"></small>
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

<script>
(function () {
    var sel = document.getElementById('perusahaanSelect');
    var info = document.getElementById('autofillInfo');
    if (!sel) return;
    sel.addEventListener('change', function () {
        if (!sel.value) { info.style.display = 'none'; return; }
        info.style.display = 'block';
        info.textContent = '⏳ Mengambil data...';
        fetch(sel.dataset.autofillUrl + '/' + sel.value + '/info', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var p = data.perusahaan;
                var pen = data.latest_penawaran;

                // Auto-fill Keterangan
                var ket = document.querySelector('[name="keterangan"]');
                if (ket && !ket.value.trim().length || ket.value === 'Tagihan biaya sertifikasi halal') {
                    ket.value = 'Tagihan biaya sertifikasi halal untuk ' + p.nama_pelaku_usaha + (p.merek_dagang ? ' (' + p.merek_dagang + ')' : '');
                }

                if (pen) {
                    // Auto-fill dari penawaran terbaru
                    var hok = document.querySelector('[name="hok_jumlah_produk"]');
                    if (hok && (hok.value == '1' || hok.value == '')) hok.value = pen.hok_jumlah_produk;

                    var total = document.querySelector('[name="total_tagihan"]');
                    if (total && (total.value == '0' || total.value == '')) total.value = pen.total_biaya;

                    info.innerHTML = '✓ Data pre-filled dari penawaran <b>' + pen.no_penawaran + '</b> (HOK: ' + pen.hok_jumlah_produk + ', Total: Rp ' + pen.total_biaya.toLocaleString('id-ID') + ')';
                    info.style.color = 'var(--success)';
                } else {
                    info.innerHTML = 'ℹ Perusahaan ini belum punya penawaran. Isi manual.';
                    info.style.color = 'var(--warning)';
                }
            })
            .catch(function () {
                info.textContent = '⚠ Gagal mengambil data';
                info.style.color = 'var(--danger)';
            });
    });
})();
</script>
