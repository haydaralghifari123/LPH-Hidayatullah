@extends('layouts.app')
@section('title','Detail Akun Klien')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Klien / Detail</div>
    <h1 class="page-title">{{ $client->nama_pic }}</h1>
    <p class="page-desc">
        {{ $client->email }} · terdaftar {{ $client->created_at->format('d M Y H:i') }}
        @if ($client->is_active)
            <span class="badge badge-success">Aktif</span>
        @else
            <span class="badge badge-muted">Nonaktif</span>
        @endif
    </p>

    <div class="card">
        <h3 class="card-title">Data PIC</h3>
        <dl class="detail-grid">
            <dt>Nama Lengkap</dt><dd>{{ $client->nama_pic }}</dd>
            <dt>Email</dt><dd>{{ $client->email }}</dd>
            <dt>No. HP</dt><dd>{{ $client->no_hp ?? '-' }}</dd>
            <dt>Jabatan</dt><dd>{{ $client->jabatan ?? '-' }}</dd>
            <dt>Terdaftar</dt><dd>{{ $client->created_at->format('d M Y H:i') }}</dd>
        </dl>
        <div class="row" style="justify-content:flex-end;margin-top:14px">
            <form method="POST" action="{{ route('admin.klien.toggle', $client) }}" style="display:inline">@csrf
                <button class="btn" type="submit">{{ $client->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}</button>
            </form>
            <form method="POST" action="{{ route('admin.klien.reset-password', $client) }}" style="display:inline" onsubmit="return confirm('Reset password klien ini?')">@csrf
                <button class="btn" type="submit">Reset Password</button>
            </form>
            <a href="{{ route('admin.klien.index') }}" class="btn">Kembali</a>
        </div>
    </div>

    @if ($client->perusahaan)
        <div class="card">
            <h3 class="card-title">Perusahaan Terhubung</h3>
            <dl class="detail-grid">
                <dt>No. Ref</dt><dd>{{ $client->perusahaan->no_ref }}</dd>
                <dt>Nama Pelaku Usaha</dt><dd>{{ $client->perusahaan->nama_pelaku_usaha }}</dd>
                <dt>Merek Dagang</dt><dd>{{ $client->perusahaan->merek_dagang ?? '-' }}</dd>
                <dt>Skala</dt><dd>{{ $client->perusahaan->skala }}</dd>
                <dt>Jenis Ajuan</dt><dd>{{ $client->perusahaan->jenis_ajuan }}</dd>
                <dt>Status Pengajuan</dt><dd><span class="badge badge-info">{{ $client->perusahaan->status }}</span></dd>
                <dt>Klien LN?</dt><dd>{{ $client->perusahaan->is_foreign ? 'Ya' : 'Tidak' }}</dd>
            </dl>
            <div class="row" style="justify-content:flex-end;margin-top:10px">
                <a href="{{ route('admin.perusahaan.show', $client->perusahaan) }}" class="btn btn-primary">Buka Data Perusahaan →</a>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">Ringkasan Aktivitas</h3>
            <div class="stats">
                <div class="stat-card"><div class="stat-num">{{ $client->documents->count() }}</div><div class="stat-label">Dokumen Diupload</div></div>
                <div class="stat-card"><div class="stat-num">{{ $client->perusahaan->penawarans->count() }}</div><div class="stat-label">Penawaran</div></div>
                <div class="stat-card"><div class="stat-num">{{ $client->perusahaan->invoices->count() }}</div><div class="stat-label">Invoice</div></div>
                <div class="stat-card"><div class="stat-num">{{ $client->perusahaan->suratTugas->count() }}</div><div class="stat-label">Surat Tugas</div></div>
            </div>
        </div>
    @else
        <div class="card">
            <p class="muted">Akun ini belum terhubung dengan data perusahaan manapun.</p>
        </div>
    @endif
@endsection
