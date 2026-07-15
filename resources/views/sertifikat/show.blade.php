@extends('layouts.app')
@section('title','Detail Sertifikat')
@section('content')
    <div class="page-crumb">Operasional / Surat Halal Terbit / Detail</div>
    <h1 class="page-title">{{ $item->no_sertifikat }}</h1>
    <div class="card">
        <dl class="detail-grid">
            <dt>Pelaku Usaha</dt><dd>{{ $item->perusahaan->nama_pelaku_usaha ?? '-' }}</dd>
            <dt>Jenis Daftar</dt><dd>{{ $item->jenis_daftar }}</dd>
            <dt>Jenis Produk</dt><dd>{{ $item->jenis_produk ?? '-' }}</dd>
            <dt>Merek Dagang</dt><dd>{{ $item->merek_dagang ?? '-' }}</dd>
            <dt>Tanggal Terbit</dt><dd>{{ optional($item->tanggal_terbit)->format('d M Y') }}</dd>
            <dt>Tanggal Expired</dt><dd>{{ optional($item->tanggal_expired)->format('d M Y') ?? '-' }}</dd>
            <dt>Status</dt><dd>{{ $item->status }}</dd>
            <dt>Dokumen</dt><dd>@if($item->file_pdf)<a href="{{ asset('storage/'.$item->file_pdf) }}" target="_blank">Download PDF</a>@else - @endif</dd>
        </dl>
        <div class="row" style="justify-content:flex-end;margin-top:14px">
            <a href="{{ route('admin.sertifikat.index') }}" class="btn">Tutup</a>
            <a href="{{ route('admin.sertifikat.edit', $item) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
@endsection
