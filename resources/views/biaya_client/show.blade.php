@extends('layouts.app')
@section('title','Detail Biaya')
@section('content')
    <div class="page-crumb">Keuangan / Biaya Client / Detail</div>
    <h1 class="page-title">{{ $item->no_biaya }}</h1>
    <div class="card">
        <dl class="detail-grid">
            <dt>Perusahaan</dt><dd>{{ $item->perusahaan->nama_pelaku_usaha ?? '-' }}</dd>
            <dt>Tanggal</dt><dd>{{ optional($item->tanggal_terbit)->format('d M Y') }}</dd>
            <dt>HOK</dt><dd>{{ $item->hok_jumlah_produk }}</dd>
            <dt>Biaya BPJPH</dt><dd>Rp {{ number_format($item->biaya_bpjph,0,',','.') }}</dd>
            <dt>Biaya LPH</dt><dd>Rp {{ number_format($item->biaya_lph,0,',','.') }}</dd>
            <dt>Biaya Transportasi</dt><dd>Rp {{ number_format($item->biaya_transportasi,0,',','.') }}</dd>
            <dt>Biaya Uji Lab</dt><dd>Rp {{ number_format($item->biaya_uji_lab,0,',','.') }}</dd>
            <dt><b>TOTAL</b></dt><dd><b>Rp {{ number_format($item->total_biaya,0,',','.') }}</b></dd>
        </dl>
    </div>
@endsection
