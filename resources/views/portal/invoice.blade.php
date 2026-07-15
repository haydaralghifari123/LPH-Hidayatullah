@extends('portal.layout')
@section('title','Invoice')
@section('content')
<h1 class="page-title">Invoice</h1>
<p class="page-desc">Tagihan yang perlu Anda bayar dan upload bukti transfer.</p>

@forelse ($invoices as $inv)
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">{{ $inv->no_invoice }}</h3>
            @if ($inv->status === 'lunas')
                <span class="badge badge-success">Lunas</span>
            @elseif ($inv->bukti_transfer_path)
                <span class="badge badge-info">Menunggu Verifikasi</span>
            @else
                <span class="badge badge-warning">Belum Dibayar</span>
            @endif
        </div>
        <dl class="detail-grid">
            <dt>Tanggal Invoice</dt><dd>{{ optional($inv->tanggal_invoice)->format('d M Y') }}</dd>
            <dt>Skema Pembayaran</dt><dd>{{ $inv->skema_pembayaran }}</dd>
            <dt>Keterangan</dt><dd>{{ $inv->keterangan ?? '-' }}</dd>
            <dt>Total Tagihan</dt><dd>Rp {{ number_format($inv->total_tagihan,0,',','.') }}</dd>
            <dt>Diskon</dt><dd>Rp {{ number_format($inv->diskon,0,',','.') }}</dd>
            <dt><b>Grand Total</b></dt><dd><b style="color:var(--primary);font-size:18px">Rp {{ number_format($inv->grand_total,0,',','.') }}</b></dd>
        </dl>

        <div class="bank-info">
            <b>Transfer ke:</b>
            Bank Syariah Indonesia (BSI) · Rek. <b>7297302056</b> · a.n. LPH HIDAYATULLAH
        </div>

        @if ($inv->status !== 'lunas')
            <form method="POST" action="{{ route('portal.invoice.uploadBukti', $inv) }}" enctype="multipart/form-data" class="form" style="margin-top:14px">
                @csrf
                <div class="grid-2">
                    <div class="field">
                        <label>Upload Bukti Transfer (PDF/JPG max 3MB) *</label>
                        <input type="file" name="bukti" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="field" style="align-self:end">
                        <button class="btn btn-primary" type="submit">📤 Kirim Bukti Transfer</button>
                    </div>
                </div>
            </form>
            @if ($inv->bukti_transfer_path)
                <div class="muted small" style="margin-top:8px">
                    Bukti terakhir: <a href="{{ asset('storage/'.$inv->bukti_transfer_path) }}" target="_blank">Lihat</a>
                    · Upload: {{ optional($inv->bukti_uploaded_at)->format('d M Y H:i') }}
                </div>
            @endif
        @endif
    </div>
@empty
    <div class="card">
        <p class="muted center">Belum ada invoice. Invoice akan diterbitkan setelah Anda menyetujui penawaran biaya.</p>
    </div>
@endforelse
@endsection
