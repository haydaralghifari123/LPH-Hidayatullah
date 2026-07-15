@csrf
<div class="grid-2">
    <div class="field"><label>Nama Lengkap *</label><input name="nama" value="{{ old('nama', $auditor->nama ?? '') }}" required></div>
    <div class="field"><label>No. Registrasi (opsional, auto-generate)</label><input name="no_registrasi" value="{{ old('no_registrasi', $auditor->no_registrasi ?? '') }}" placeholder="AUD-XXX"></div>
    <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email', $auditor->email ?? '') }}"></div>
    <div class="field"><label>No. Telepon</label><input name="no_telepon" value="{{ old('no_telepon', $auditor->no_telepon ?? '') }}"></div>
    <div class="field" style="grid-column: span 2"><label>Alamat</label><textarea name="alamat">{{ old('alamat', $auditor->alamat ?? '') }}</textarea></div>
    <div class="field"><label>Lokasi Kota</label><input name="lokasi_kota" value="{{ old('lokasi_kota', $auditor->lokasi_kota ?? '') }}"></div>
    <div class="field"><label>Kompetensi *</label>
        <select name="kompetensi" required>
            @foreach (['Junior','Madya','Senior'] as $k)
                <option value="{{ $k }}" @selected(old('kompetensi', $auditor->kompetensi ?? 'Junior')===$k)>{{ $k }}</option>
            @endforeach
        </select>
    </div>
    <div class="field"><label>Pendidikan S1</label><input name="pendidikan_s1" value="{{ old('pendidikan_s1', $auditor->pendidikan_s1 ?? '') }}"></div>
    <div class="field"><label>Pendidikan S2 (opsional)</label><input name="pendidikan_s2" value="{{ old('pendidikan_s2', $auditor->pendidikan_s2 ?? '') }}"></div>
    <div class="field"><label>Pendidikan S3 (opsional)</label><input name="pendidikan_s3" value="{{ old('pendidikan_s3', $auditor->pendidikan_s3 ?? '') }}"></div>
    <div class="field"><label>Status *</label>
        <select name="status" required>
            @foreach (['aktif','non-aktif','cuti'] as $s)
                <option value="{{ $s }}" @selected(old('status', $auditor->status ?? 'aktif')===$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row" style="justify-content:flex-end">
    <a href="{{ route('admin.auditor.index') }}" class="btn">Batal</a>
    <button class="btn btn-primary" type="submit">Simpan Auditor</button>
</div>
