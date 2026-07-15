@extends('portal.layout')
@section('title','Dashboard')
@section('content')
<h1 class="page-title">Selamat datang, {{ $client->nama_pic }}</h1>
<p class="page-desc">
    @if ($perusahaan)
        Progres sertifikasi <b>{{ $perusahaan->nama_pelaku_usaha }}</b> — No. Ref: <code>{{ $perusahaan->no_ref }}</code>
    @else
        Lengkapi profil perusahaan Anda untuk memulai proses sertifikasi.
    @endif
</p>

<div class="card">
    <h3 class="card-title">Progres Pengajuan</h3>
    <div class="progress-track">
        @foreach ($steps as $i => $step)
            <div class="progress-step {{ $step['done'] ? 'done' : '' }}">
                <div class="progress-dot">{{ $step['done'] ? '✓' : $i + 1 }}</div>
                <div class="progress-label">{{ $step['label'] }}</div>
            </div>
            @if (! $loop->last)
                <div class="progress-connector {{ $step['done'] ? 'done' : '' }}"></div>
            @endif
        @endforeach
    </div>
</div>

@if ($perusahaan)
    <div class="stats">
        <div class="stat-card">
            <div class="stat-num">{{ $perusahaan->documents()->count() }}</div>
            <div class="stat-label">Dokumen Diupload</div>
            <a href="{{ route('portal.dokumen') }}" class="stat-link">Kelola →</a>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $perusahaan->penawarans->count() }}</div>
            <div class="stat-label">Penawaran Diterima</div>
            <a href="{{ route('portal.penawaran') }}" class="stat-link">Lihat →</a>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $perusahaan->invoices->count() }}</div>
            <div class="stat-label">Invoice</div>
            <a href="{{ route('portal.invoice') }}" class="stat-link">Lihat →</a>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $perusahaan->sertifikat ? '✓' : '—' }}</div>
            <div class="stat-label">Sertifikat</div>
            @if ($perusahaan->sertifikat && $perusahaan->sertifikat->file_pdf)
                <a href="{{ asset('storage/'.$perusahaan->sertifikat->file_pdf) }}" target="_blank" class="stat-link">Download →</a>
            @endif
        </div>
    </div>

    @if ($perusahaan->suratTugas->isNotEmpty())
        <div class="card">
            <h3 class="card-title">Jadwal Audit</h3>
            @foreach ($perusahaan->suratTugas as $st)
                <dl class="detail-grid">
                    <dt>No. Surat Tugas</dt><dd>{{ $st->no_surat }}</dd>
                    <dt>Auditor</dt><dd>{{ $st->auditor->nama ?? '-' }}</dd>
                    <dt>Tanggal Audit</dt><dd>{{ optional($st->tanggal_audit)->format('d M Y') }}</dd>
                    <dt>Lokasi</dt><dd>{{ $st->lokasi ?? '-' }}</dd>
                    <dt>Rating Audit</dt><dd>{{ $st->audit_rating ? "Grade {$st->audit_rating}" : 'Belum ada rating' }}</dd>
                </dl>
                @if (! $loop->last)<hr>@endif
            @endforeach
        </div>
    @endif
@else
    <div class="card">
        <p class="muted">Anda belum memiliki data perusahaan terhubung. <a href="{{ route('portal.profil') }}">Lengkapi profil sekarang →</a></p>
    </div>
@endif
@endsection
