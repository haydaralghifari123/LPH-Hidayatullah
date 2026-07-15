@extends('layouts.app')
@section('title','Detail Perusahaan')
@section('content')
    <div class="page-crumb">Operasional / Data Perusahaan / Detail</div>
    <h1 class="page-title">{{ $perusahaan->nama_pelaku_usaha }}</h1>
    <p class="page-desc">{{ $perusahaan->no_ref }} &middot; {{ $perusahaan->skala }}</p>

    <div class="card">
        <h3 class="card-title">Informasi Umum</h3>
        <dl class="detail-grid">
            <dt>Merek Dagang</dt><dd>{{ $perusahaan->merek_dagang ?? '-' }}</dd>
            <dt>Business License No</dt><dd>{{ $perusahaan->business_license_no ?? '-' }}</dd>
            <dt>Jenis Ajuan</dt><dd>{{ $perusahaan->jenis_ajuan }}</dd>
            <dt>Jenis Produk</dt><dd>{{ $perusahaan->jenis_produk ?? '-' }}</dd>
            <dt>Alamat</dt><dd>{{ $perusahaan->alamat ?? '-' }}</dd>
            <dt>Kota / Provinsi</dt><dd>{{ $perusahaan->kota ?? '-' }} / {{ $perusahaan->provinsi ?? '-' }}</dd>
            <dt>Status</dt><dd><span class="badge badge-info">{{ $perusahaan->status }}</span></dd>
            <dt>Klien Luar Negeri?</dt><dd>{{ $perusahaan->is_foreign ? 'Ya' : 'Tidak' }}</dd>
        </dl>
        @if ($perusahaan->is_foreign)
            <div class="row" style="justify-content:flex-end;margin-top:10px">
                <a href="{{ route('admin.report.statement-letter', $perusahaan) }}" class="btn">📄 Statement Letter (PDF)</a>
                <a href="{{ route('admin.report.statement-letter', ['perusahaan' => $perusahaan, 'format' => 'docx']) }}" class="btn btn-sm">.docx</a>
            </div>
        @endif
    </div>

    <div class="card">
        <h3 class="card-title">Kontak PIC / Akun Portal Klien</h3>
        @if ($perusahaan->clients->isEmpty())
            <p class="muted">Belum ada PIC terhubung. Perusahaan ini kemungkinan didaftarkan oleh staf, bukan lewat portal klien.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Nama PIC</th><th>Email</th><th>Jabatan</th><th>No. HP</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($perusahaan->clients as $c)
                            <tr>
                                <td><b>{{ $c->nama_pic }}</b></td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->jabatan ?? '-' }}</td>
                                <td>{{ $c->no_hp ?? '-' }}</td>
                                <td>
                                    @if ($c->is_active)<span class="badge badge-success">Aktif</span>
                                    @else<span class="badge badge-muted">Nonaktif</span>@endif
                                </td>
                                <td><a class="btn btn-sm" href="{{ route('admin.klien.show', $c) }}">Kelola</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card">
        <h3 class="card-title">Surat Tugas</h3>
        <ul>
            @forelse($perusahaan->suratTugas as $st)
                <li>{{ $st->no_surat }} &middot; auditor: {{ $st->auditor->nama ?? '-' }} &middot; audit {{ optional($st->tanggal_audit)->format('d M Y') }}</li>
            @empty
                <li class="muted">Belum ada surat tugas.</li>
            @endforelse
        </ul>
    </div>

    <div class="card">
        <h3 class="card-title">Sertifikat</h3>
        @if ($perusahaan->sertifikat)
            <p>{{ $perusahaan->sertifikat->no_sertifikat }} &middot; status {{ $perusahaan->sertifikat->status }}</p>
        @else
            <p class="muted">Belum ada sertifikat diterbitkan.</p>
        @endif
    </div>
@endsection
