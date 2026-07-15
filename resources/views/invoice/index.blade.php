@extends('layouts.app')
@section('title','Invoice')
@section('content')
    <div class="page-crumb">Keuangan / Buat Invoice</div>
    <h1 class="page-title">Manajemen Invoice</h1>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-label">Total Invoice</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['lunas'] }}</div><div class="stat-label">Lunas</div></div>
        <div class="stat-card"><div class="stat-num">Rp {{ number_format($stats['tertagih'],0,',','.') }}</div><div class="stat-label">Tertagih</div></div>
        <div class="stat-card"><div class="stat-num">Rp {{ number_format($stats['pendapatan'],0,',','.') }}</div><div class="stat-label">Pendapatan Lunas</div></div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Daftar Invoice</h3>
            <form method="GET" class="row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px">
                <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary">+ Buat Invoice</a>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>No</th><th>No. Invoice</th><th>Tanggal</th><th>Pelaku Usaha</th><th>Skema</th><th>Total</th><th>Diskon</th><th>Grand Total</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($items as $i => $p)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td>{{ $p->no_invoice }}</td>
                        <td>{{ optional($p->tanggal_invoice)->format('d M Y') }}</td>
                        <td>{{ $p->perusahaan->nama_pelaku_usaha ?? '-' }}</td>
                        <td>{{ $p->skema_pembayaran }}</td>
                        <td>Rp {{ number_format($p->total_tagihan,0,',','.') }}</td>
                        <td>Rp {{ number_format($p->diskon,0,',','.') }}</td>
                        <td><b>Rp {{ number_format($p->grand_total,0,',','.') }}</b></td>
                        <td>
                            @if($p->status==='lunas')<span class="badge badge-success">Lunas</span>
                            @elseif($p->status==='terkirim')<span class="badge badge-info">Terkirim</span>
                            @else<span class="badge badge-muted">Draft</span>@endif
                        </td>
                        <td>
                            <a class="btn btn-sm" href="{{ route('admin.invoice.show', $p) }}">Detail</a>
                            <a class="btn btn-sm" href="{{ route('admin.invoice.edit', $p) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.invoice.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="center muted">Belum ada invoice.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $items->links() }}</div>
    </div>
@endsection
