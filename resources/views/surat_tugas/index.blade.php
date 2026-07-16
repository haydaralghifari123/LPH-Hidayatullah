@extends('layouts.app')
@section('title','Surat Tugas')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Surat Tugas</div>
    <h1 class="page-title">Manajemen Surat Tugas</h1>
    <p class="page-desc">Kelola surat tugas auditor yang telah dan akan diterbitkan.</p>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-label">Total Surat Tugas</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['belum'] }}</div><div class="stat-label">Belum Dikirim</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['terkirim'] }}</div><div class="stat-label">Sudah Dikirim</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['pekan_ini'] }}</div><div class="stat-label">Audit Pekan Ini</div></div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Daftar Surat Tugas</h3>
            <form method="GET" class="row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px">
                <a href="{{ route('admin.surat-tugas.create') }}" class="btn btn-primary">+ Buat Surat Tugas</a>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>No</th><th>No. Surat</th><th>Tgl Terbit</th><th>Tgl Audit</th><th>Pelaku Usaha</th><th>Auditor</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($items as $i => $st)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td>{{ $st->no_surat }}</td>
                        <td>{{ optional($st->tanggal_terbit)->format('d M Y') }}</td>
                        <td>{{ optional($st->tanggal_audit)->format('d M Y') }}</td>
                        <td>{{ $st->perusahaan->nama_pelaku_usaha ?? '-' }}</td>
                        <td>{{ $st->auditor->nama ?? '-' }}</td>
                        <td>{{ $st->lokasi ?? '-' }}</td>
                        <td>
                            @if($st->status_kirim === 'terkirim')<span class="badge badge-success">Terkirim</span>
                            @else<span class="badge badge-warning">Belum</span>@endif
                        </td>
                        <td>
                            <a class="btn btn-sm" href="{{ route('admin.surat-tugas.show', $st) }}">Detail</a>
                            <a class="btn btn-sm" href="{{ route('admin.report.surat-tugas', $st) }}" title="Download DOCX (persis template)">📄</a>
                            <a class="btn btn-sm" href="{{ route('admin.surat-tugas.edit', $st) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.surat-tugas.destroy', $st) }}" style="display:inline" onsubmit="return confirm('Hapus surat tugas?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="center muted">Belum ada surat tugas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $items->links() }}</div>
    </div>
@endsection
