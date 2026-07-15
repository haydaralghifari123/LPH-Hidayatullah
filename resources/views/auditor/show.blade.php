@extends('layouts.app')
@section('title','Detail Auditor')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Auditor / Detail</div>
    <h1 class="page-title">{{ $auditor->nama }}</h1>
    <p class="page-desc">No. Registrasi {{ $auditor->no_registrasi }}</p>
    <div class="card">
        <dl class="detail-grid">
            <dt>Email</dt><dd>{{ $auditor->email ?? '-' }}</dd>
            <dt>No. Telepon</dt><dd>{{ $auditor->no_telepon ?? '-' }}</dd>
            <dt>Alamat</dt><dd>{{ $auditor->alamat ?? '-' }}</dd>
            <dt>Lokasi Kota</dt><dd>{{ $auditor->lokasi_kota ?? '-' }}</dd>
            <dt>Pendidikan S1</dt><dd>{{ $auditor->pendidikan_s1 ?? '-' }}</dd>
            <dt>Pendidikan S2</dt><dd>{{ $auditor->pendidikan_s2 ?? '-' }}</dd>
            <dt>Pendidikan S3</dt><dd>{{ $auditor->pendidikan_s3 ?? '-' }}</dd>
            <dt>Kompetensi</dt><dd>{{ $auditor->kompetensi }}</dd>
            <dt>Beban Kerja</dt><dd>{{ $auditor->beban_kerja }} tugas</dd>
            <dt>Status</dt><dd>{{ ucfirst($auditor->status) }}</dd>
        </dl>
        <div class="row" style="justify-content:flex-end;margin-top:14px">
            <a href="{{ route('admin.auditor.index') }}" class="btn">Tutup</a>
            <a href="{{ route('admin.auditor.edit', $auditor) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
@endsection
