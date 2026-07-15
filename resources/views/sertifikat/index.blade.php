@extends('layouts.app')
@section('title','Surat Halal Terbit')
@section('content')
    <div class="page-crumb">Operasional / Surat Halal Terbit</div>
    <h1 class="page-title">Manajemen Surat Halal Terbit</h1>
    <p class="page-desc">Daftar sertifikasi halal yang telah diterbitkan untuk klien.</p>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-label">Total Sertifikat</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['menunggu'] }}</div><div class="stat-label">Menunggu Terbit</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['bulan_ini'] }}</div><div class="stat-label">Terbit Bulan Ini</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['akan_expired'] }}</div><div class="stat-label">Akan Expired</div></div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Daftar Sertifikat</h3>
            <form method="GET" class="row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px">
                <select name="status" onchange="this.form.submit()" style="padding:8px;border:1px solid var(--border);border-radius:8px">
                    <option value="">Semua Status</option>
                    @foreach (['Menunggu','Terbit','Expired'] as $s)
                        <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.sertifikat.create') }}" class="btn btn-primary">+ Terbitkan Sertifikat</a>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>No</th><th>No. Sertifikat</th><th>Pelaku Usaha</th><th>Jenis Produk</th><th>Merek</th><th>Skala</th><th>Provinsi</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($items as $i => $s)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td>{{ $s->no_sertifikat }}</td>
                        <td>{{ $s->perusahaan->nama_pelaku_usaha ?? '-' }}</td>
                        <td>{{ $s->jenis_produk ?? '-' }}</td>
                        <td>{{ $s->merek_dagang ?? '-' }}</td>
                        <td>{{ $s->perusahaan->skala ?? '-' }}</td>
                        <td>{{ $s->perusahaan->provinsi ?? '-' }}</td>
                        <td>
                            @if($s->status==='Terbit')<span class="badge badge-success">{{ $s->status }}</span>
                            @elseif($s->status==='Expired')<span class="badge badge-danger">{{ $s->status }}</span>
                            @else<span class="badge badge-warning">{{ $s->status }}</span>@endif
                        </td>
                        <td>
                            @if($s->file_pdf)
                                <a href="{{ asset('storage/'.$s->file_pdf) }}" target="_blank">PDF</a>
                            @else - @endif
                        </td>
                        <td>
                            <a class="btn btn-sm" href="{{ route('admin.sertifikat.show', $s) }}">Detail</a>
                            <a class="btn btn-sm" href="{{ route('admin.sertifikat.edit', $s) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.sertifikat.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Hapus sertifikat?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="center muted">Belum ada sertifikat.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $items->links() }}</div>
    </div>
@endsection
