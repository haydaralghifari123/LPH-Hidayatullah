@extends('layouts.app')
@section('title','Detail Invoice')
@section('content')
    <div class="page-crumb">Keuangan / Buat Invoice / Detail</div>
    <h1 class="page-title">{{ $item->no_invoice }}</h1>
    <div class="card">
        <dl class="detail-grid">
            <dt>Pelaku Usaha</dt><dd>{{ $item->perusahaan->nama_pelaku_usaha ?? '-' }}</dd>
            <dt>Tanggal</dt><dd>{{ optional($item->tanggal_invoice)->format('d M Y') }}</dd>
            <dt>HOK</dt><dd>{{ $item->hok_jumlah_produk }}</dd>
            <dt>Skema Pembayaran</dt><dd>{{ $item->skema_pembayaran }}</dd>
            <dt>Keterangan</dt><dd>{{ $item->keterangan ?? '-' }}</dd>
            <dt>Total Tagihan</dt><dd>Rp {{ number_format($item->total_tagihan,0,',','.') }}</dd>
            <dt>Diskon</dt><dd>Rp {{ number_format($item->diskon,0,',','.') }}</dd>
            <dt><b>GRAND TOTAL</b></dt><dd><b style="font-size:18px;color:var(--primary)">Rp {{ number_format($item->grand_total,0,',','.') }}</b></dd>
            <dt>Status</dt><dd>{{ ucfirst($item->status) }}</dd>
        </dl>
        <div class="row" style="justify-content:flex-end;margin-top:14px">
            <a href="{{ route('admin.invoice.index') }}" class="btn">Tutup</a>
            @if ($item->perusahaan?->is_foreign)
                <a href="{{ route('admin.report.invoice-ln', $item) }}" class="btn btn-primary">📄 Invoice LN (PDF)</a>
                <a href="{{ route('admin.report.invoice-ln', ['invoice' => $item, 'format' => 'docx']) }}" class="btn btn-sm">.docx</a>
            @else
                <a href="{{ route('admin.report.invoice', $item) }}" class="btn btn-primary">📄 Invoice (PDF)</a>
                <a href="{{ route('admin.report.invoice', ['invoice' => $item, 'format' => 'docx']) }}" class="btn btn-sm">.docx</a>
            @endif
        </div>
    </div>
@endsection
