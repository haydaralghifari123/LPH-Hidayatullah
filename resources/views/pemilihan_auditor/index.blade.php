@extends('layouts.app')
@section('title','Pemilihan Auditor')
@section('content')
    <div class="page-crumb">Operasional / Pemilihan Auditor</div>
    <h1 class="page-title">Pemilihan Auditor</h1>
    <p class="page-desc">Sistem akan merekomendasikan auditor berdasarkan kompetensi, jarak lokasi, dan beban kerja.</p>

    <div class="card">
        <form method="GET" class="form">
            <div class="grid-2">
                <div class="field"><label>Pilih Pengajuan</label>
                    <select name="perusahaan_id" onchange="this.form.submit()" required>
                        <option value="">— Pilih No. Referensi —</option>
                        @foreach ($perusahaans as $p)
                            <option value="{{ $p->id }}" @selected(request('perusahaan_id')==$p->id)>{{ $p->no_ref }} — {{ $p->nama_pelaku_usaha }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($selected)
                    <dl class="detail-grid" style="margin:0">
                        <dt>Pelaku Usaha</dt><dd>{{ $selected->nama_pelaku_usaha }}</dd>
                        <dt>Jenis Ajuan</dt><dd>{{ $selected->jenis_ajuan }}</dd>
                        <dt>Lokasi</dt><dd>{{ trim(($selected->kota ?? '') . ', ' . ($selected->provinsi ?? ''), ', ') ?: '-' }}</dd>
                    </dl>
                @endif
            </div>
        </form>
    </div>

    @if ($selected && $recommendations->isNotEmpty())
        <div class="card">
            <h3 class="card-title">Rekomendasi Auditor</h3>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Skor</th><th>Nama</th><th>Kompetensi</th><th>Lokasi</th><th>Beban Kerja</th><th>Jarak</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @foreach ($recommendations as $a)
                        <tr>
                            <td><b>{{ $a->skor }}</b></td>
                            <td>{{ $a->nama }} <small class="muted">({{ $a->no_registrasi }})</small></td>
                            <td>{{ $a->kompetensi }}</td>
                            <td>{{ $a->lokasi_kota ?? '-' }}</td>
                            <td>{{ $a->beban_kerja }} tugas</td>
                            <td>{{ $a->jarak_estimasi }} km*</td>
                            <td>
                                <form method="POST" action="{{ route('admin.pemilihan-auditor.assign') }}" style="display:flex;gap:6px;align-items:center">
                                    @csrf
                                    <input type="hidden" name="perusahaan_id" value="{{ $selected->id }}">
                                    <input type="hidden" name="auditor_id" value="{{ $a->id }}">
                                    <input type="date" name="tanggal_audit" required style="padding:5px;border:1px solid var(--border);border-radius:6px;font-size:12px">
                                    <button class="btn btn-sm btn-primary">Tugaskan</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <p class="muted small">*Estimasi jarak dihitung berdasarkan kesamaan kota auditor &amp; lokasi pengajuan.</p>
        </div>
    @endif
@endsection
