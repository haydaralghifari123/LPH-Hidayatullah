@csrf
<h3 class="card-title">Informasi Client</h3>
<div class="grid-2">
    <div class="field"><label>No. Biaya</label><input name="no_biaya" value="{{ old('no_biaya', $item->no_biaya ?? $no ?? '') }}" placeholder="auto"></div>
    <div class="field"><label>Tanggal Terbit *</label><input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', optional($item->tanggal_terbit ?? null)->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
    <div class="field" style="grid-column: span 2"><label>Perusahaan *</label>
        <select name="perusahaan_id" id="perusahaanSelect" required data-autofill-url="{{ url('admin/api/perusahaan') }}">
            <option value="">— Pilih perusahaan —</option>
            @foreach ($perusahaans as $p)
                <option value="{{ $p->id }}" @selected(old('perusahaan_id', $item->perusahaan_id ?? null)==$p->id)>{{ $p->no_ref }} — {{ $p->nama_pelaku_usaha }}</option>
            @endforeach
        </select>
        <small class="muted" id="autofillInfo" style="font-size:11px;color:var(--muted);margin-top:4px;display:none"></small>
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
                var pen = data.latest_penawaran;
                if (pen) {
                    var setIfEmpty = function (name, val) {
                        var el = document.querySelector('[name="' + name + '"]');
                        if (el && (el.value == '0' || el.value == '' || el.value == '1')) el.value = val;
                    };
                    setIfEmpty('hok_jumlah_produk', pen.hok_jumlah_produk);
                    setIfEmpty('biaya_bpjph', pen.biaya_bpjph);
                    setIfEmpty('biaya_lph', pen.biaya_lph);
                    setIfEmpty('biaya_transportasi', pen.biaya_transportasi);
                    setIfEmpty('biaya_uji_lab', pen.biaya_uji_lab);
                    info.innerHTML = '✓ Semua biaya pre-filled dari penawaran <b>' + pen.no_penawaran + '</b> (Total: Rp ' + pen.total_biaya.toLocaleString('id-ID') + ')';
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
