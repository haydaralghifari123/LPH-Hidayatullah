@extends('portal.layout')
@section('title','Penawaran Biaya')
@section('content')
<h1 class="page-title">Penawaran Biaya</h1>
<p class="page-desc">Penawaran biaya sertifikasi dari LPH Hidayatullah.</p>

@forelse ($penawarans as $p)
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">{{ $p->no_penawaran }}</h3>
            @if ($p->status === 'disetujui')
                <span class="badge badge-success">Disetujui</span>
            @elseif ($p->status === 'terkirim')
                <span class="badge badge-info">Menunggu Persetujuan</span>
            @else
                <span class="badge badge-muted">{{ ucfirst($p->status) }}</span>
            @endif
        </div>
        <dl class="detail-grid">
            <dt>Tanggal Terbit</dt><dd>{{ optional($p->tanggal_terbit)->format('d M Y') }}</dd>
            <dt>Jumlah HOK</dt><dd>{{ $p->hok_jumlah_produk }}</dd>
            <dt>Biaya BPJPH</dt><dd>Rp {{ number_format($p->biaya_bpjph,0,',','.') }}</dd>
            <dt>Biaya LPH</dt><dd>Rp {{ number_format($p->biaya_lph,0,',','.') }}</dd>
            <dt>Biaya Transportasi</dt><dd>Rp {{ number_format($p->biaya_transportasi,0,',','.') }}</dd>
            <dt>Biaya Uji Lab</dt><dd>Rp {{ number_format($p->biaya_uji_lab,0,',','.') }}</dd>
            <dt><b>Total Biaya</b></dt><dd><b style="color:var(--primary);font-size:18px">Rp {{ number_format($p->total_biaya,0,',','.') }}</b></dd>
        </dl>
        <div class="row" style="justify-content:flex-end;margin-top:14px">
            @if ($p->status !== 'disetujui')
                <form method="POST" action="{{ route('portal.penawaran.approve', $p) }}" onsubmit="return confirm('Setujui penawaran ini?')">
                    @csrf
                    <button class="btn btn-primary" type="submit">✓ Setujui Penawaran</button>
                </form>
            @else
                <div class="muted small">Disetujui pada {{ optional($p->disetujui_klien_at)->format('d M Y H:i') }}</div>
            @endif
        </div>
    </div>
@empty
    <div class="card">
        <p class="muted center">Belum ada penawaran biaya. Tim LPH akan mengirim setelah dokumen Anda diverifikasi.</p>
    </div>
@endforelse
@endsection
