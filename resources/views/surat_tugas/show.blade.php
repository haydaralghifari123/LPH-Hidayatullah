@extends('layouts.app')
@section('title','Detail Surat Tugas')
@section('content')
    <div class="page-crumb">Operasional / Surat Tugas / Detail</div>
    <h1 class="page-title">Surat Tugas {{ $item->no_surat }}</h1>
    <div class="card">
        <dl class="detail-grid">
            <dt>Tanggal Terbit</dt><dd>{{ optional($item->tanggal_terbit)->format('d M Y') }}</dd>
            <dt>Tanggal Audit</dt><dd>{{ optional($item->tanggal_audit)->format('d M Y') }}</dd>
            <dt>Pelaku Usaha</dt><dd>{{ $item->perusahaan->nama_pelaku_usaha ?? '-' }}</dd>
            <dt>Auditor</dt><dd>{{ $item->auditor->nama ?? '-' }}</dd>
            <dt>Lokasi</dt><dd>{{ $item->lokasi ?? '-' }}</dd>
            <dt>Scope Audit</dt><dd>{{ $item->scope_audit ?? '-' }}</dd>
            <dt>Audit Rating</dt><dd>{{ $item->audit_rating ? "Grade {$item->audit_rating}" : 'Belum dinilai' }}</dd>
            <dt>Catatan</dt><dd>{{ $item->catatan ?? '-' }}</dd>
            <dt>Status Kirim</dt><dd>{{ ucfirst($item->status_kirim) }}</dd>
        </dl>
        <div class="row" style="justify-content:flex-end;margin-top:14px">
            <a href="{{ route('admin.surat-tugas.index') }}" class="btn">Tutup</a>
            <a href="{{ route('admin.report.surat-tugas', $item) }}" class="btn">📄 Surat Tugas (DOCX)</a>
            @if ($item->audit_rating)
                <a href="{{ route('admin.report.audit-report', $item) }}" class="btn">📊 Audit Report (DOCX)</a>
            @endif
            <a href="{{ route('admin.surat-tugas.edit', $item) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
@endsection
