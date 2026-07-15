@extends('layouts.app')
@section('title','Input Penawaran')
@section('content')
    <div class="page-crumb">Keuangan / Input Penawaran</div>
    <h1 class="page-title">Daftar Penawaran</h1>
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Riwayat Penawaran</h3>
            <form method="GET" class="row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px">
                <a href="{{ route('admin.penawaran.create') }}" class="btn btn-primary">+ Buat Penawaran</a>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>No</th><th>No. Penawaran</th><th>Tanggal</th><th>Pelaku Usaha</th><th>HOK</th><th>Total Biaya</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($items as $i => $p)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td>{{ $p->no_penawaran }}</td>
                        <td>{{ optional($p->tanggal_terbit)->format('d M Y') }}</td>
                        <td>{{ $p->perusahaan->nama_pelaku_usaha ?? '-' }}</td>
                        <td>{{ $p->hok_jumlah_produk }}</td>
                        <td>Rp {{ number_format($p->total_biaya,0,',','.') }}</td>
                        <td>{{ ucfirst($p->status) }}</td>
                        <td>
                            <a class="btn btn-sm" href="{{ route('admin.penawaran.show', $p) }}">Detail</a>
                            <a class="btn btn-sm" href="{{ route('admin.penawaran.edit', $p) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.penawaran.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="center muted">Belum ada penawaran.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $items->links() }}</div>
    </div>
@endsection
