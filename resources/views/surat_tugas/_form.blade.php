@csrf
<div class="grid-2">
    <div class="field"><label>No. Surat (auto-generate)</label><input name="no_surat" value="{{ old('no_surat', $item->no_surat ?? '') }}" placeholder="ST-YYYY-XXXX"></div>
    <div class="field"><label>Tanggal Terbit *</label><input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', optional($item->tanggal_terbit ?? null)->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
    <div class="field"><label>Perusahaan / Pelaku Usaha *</label>
        <select name="perusahaan_id" id="perusahaanSelect" required data-autofill-url="{{ url('admin/api/perusahaan') }}">
            <option value="">— Pilih Pengajuan —</option>
            @foreach ($perusahaans as $p)
                <option value="{{ $p->id }}" @selected(old('perusahaan_id', $item->perusahaan_id ?? null)==$p->id)>{{ $p->no_ref }} — {{ $p->nama_pelaku_usaha }}</option>
            @endforeach
        </select>
        <small class="muted" id="autofillInfo" style="font-size:11px;color:var(--muted);margin-top:4px;display:none"></small>
    </div>
    <div class="field"><label>Auditor *</label>
        <select name="auditor_id" required>
            <option value="">— Pilih Auditor —</option>
            @foreach ($auditors as $a)
                <option value="{{ $a->id }}" @selected(old('auditor_id', $item->auditor_id ?? null)==$a->id)>{{ $a->nama }} ({{ $a->no_registrasi }})</option>
            @endforeach
        </select>
    </div>
    <div class="field"><label>Tanggal Audit *</label><input type="date" name="tanggal_audit" value="{{ old('tanggal_audit', optional($item->tanggal_audit ?? null)->format('Y-m-d')) }}" required></div>
    <div class="field"><label>Status Kirim *</label>
        <select name="status_kirim" required>
            <option value="belum" @selected(old('status_kirim',$item->status_kirim ?? 'belum')==='belum')>Belum</option>
            <option value="terkirim" @selected(old('status_kirim',$item->status_kirim ?? '')==='terkirim')>Terkirim</option>
        </select>
    </div>
    <div class="field" style="grid-column: span 2"><label>Lokasi</label><input name="lokasi" value="{{ old('lokasi', $item->lokasi ?? '') }}"></div>
    <div class="field" style="grid-column: span 2"><label>Scope Audit</label><input name="scope_audit" value="{{ old('scope_audit', $item->scope_audit ?? '') }}" placeholder="misal: Food & Beverage Manufacturing"></div>
    <div class="field"><label>Audit Rating (setelah audit)</label>
        <select name="audit_rating">
            <option value="">— Belum dinilai —</option>
            @foreach (['A','B','C','D'] as $r)
                <option value="{{ $r }}" @selected(old('audit_rating', $item->audit_rating ?? '')===$r)>Grade {{ $r }}</option>
            @endforeach
        </select>
    </div>
    <div class="field" style="grid-column: span 2"><label>Catatan Tambahan / Hasil Audit</label><textarea name="catatan">{{ old('catatan', $item->catatan ?? '') }}</textarea></div>
</div>
<div class="row" style="justify-content:flex-end">
    <a href="{{ route('admin.surat-tugas.index') }}" class="btn">Batal</a>
    <button class="btn btn-primary" type="submit">Simpan Surat Tugas</button>
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
                var lokasi = document.querySelector('[name="lokasi"]');
                var scope = document.querySelector('[name="scope_audit"]');
                if (lokasi && !lokasi.value.trim()) lokasi.value = p.lokasi_full;
                if (scope && !scope.value.trim()) scope.value = p.jenis_ajuan;
                info.innerHTML = '✓ Lokasi pre-filled dari alamat perusahaan';
                info.style.color = 'var(--success)';
            })
            .catch(function () {
                info.textContent = '⚠ Gagal mengambil data';
                info.style.color = 'var(--danger)';
            });
    });
})();
</script>
