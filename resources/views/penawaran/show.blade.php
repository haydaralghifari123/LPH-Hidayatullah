@extends('layouts.app')
@section('title','Detail Penawaran')
@section('content')
    <div class="page-crumb">Keuangan / Input Penawaran / Detail</div>
    <h1 class="page-title">{{ $item->no_penawaran }}</h1>
    <div class="card">
        <dl class="detail-grid">
            <dt>Perusahaan</dt><dd>{{ $item->perusahaan->nama_pelaku_usaha ?? '-' }}</dd>
            <dt>Tanggal</dt><dd>{{ optional($item->tanggal_terbit)->format('d M Y') }}</dd>
            <dt>HOK / Jumlah Produk</dt><dd>{{ $item->hok_jumlah_produk }}</dd>
            <dt>Biaya BPJPH</dt><dd>Rp {{ number_format($item->biaya_bpjph,0,',','.') }}</dd>
            <dt>Biaya LPH</dt><dd>Rp {{ number_format($item->biaya_lph,0,',','.') }}</dd>
            <dt>Biaya Transportasi</dt><dd>Rp {{ number_format($item->biaya_transportasi,0,',','.') }}</dd>
            <dt>Biaya Uji Lab</dt><dd>Rp {{ number_format($item->biaya_uji_lab,0,',','.') }}</dd>
            <dt><b>TOTAL</b></dt><dd><b>Rp {{ number_format($item->total_biaya,0,',','.') }}</b></dd>
            <dt>Status</dt><dd>{{ ucfirst($item->status) }}</dd>
        </dl>
        <div class="row" style="justify-content:flex-end;margin-top:14px">
            <a href="{{ route('admin.penawaran.index') }}" class="btn">Tutup</a>
            @if ($item->perusahaan?->is_foreign)
                <a href="{{ route('admin.report.quotation', $item) }}" class="btn btn-primary">📄 Quotation LN (PDF)</a>
                <a href="{{ route('admin.report.quotation', ['penawaran' => $item, 'format' => 'docx']) }}" class="btn btn-sm">.docx</a>
            @else
                <a href="{{ route('admin.report.pembiayaan', $item) }}" class="btn btn-primary">📄 Surat Pembiayaan (PDF)</a>
                <a href="{{ route('admin.report.pembiayaan', ['penawaran' => $item, 'format' => 'docx']) }}" class="btn btn-sm">.docx</a>
            @endif
        </div>
    </div>
@endsection
