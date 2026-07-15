@extends('layouts.app')
@section('title', 'Data Perusahaan')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Data Perusahaan</div>
    <h1 class="page-title">Data Perusahaan &amp; Auditor</h1>
    <p class="page-desc">Daftar semua perusahaan yang mengajukan sertifikasi beserta auditor yang ditugaskan.</p>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-label">Total Pengajuan</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['proses'] }}</div><div class="stat-label">Dalam Proses</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['audit_berjalan'] }}</div><div class="stat-label">Audit Berjalan</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['selesai'] }}</div><div class="stat-label">Selesai</div></div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Daftar Pengajuan</h3>
            <form method="GET" class="row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px">
                <a href="{{ route('admin.perusahaan.create') }}" class="btn btn-primary">+ Tambah Pengajuan</a>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>No</th><th>No. Ref</th><th>Nama Pelaku Usaha</th><th>PIC Portal</th><th>Merek</th><th>Skala</th><th>Wilayah</th><th>Auditor</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($perusahaans as $i => $p)
                    <tr>
                        <td>{{ $perusahaans->firstItem() + $i }}</td>
                        <td>{{ $p->no_ref }}</td>
                        <td><b>{{ $p->nama_pelaku_usaha }}</b><br><small class="muted">{{ $p->jenis_ajuan }}</small></td>
                        <td>
                            @if ($p->clients->isEmpty())
                                <span class="muted small">— tidak ada —</span>
                            @else
                                @foreach ($p->clients as $c)
                                    <a href="{{ route('admin.klien.show', $c) }}">{{ $c->nama_pic }}</a>
                                    @if ($c->is_active)<span class="badge badge-success">✓</span>@endif
                                    @if (!$loop->last)<br>@endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $p->merek_dagang ?? '-' }}</td>
                        <td>{{ $p->skala }}</td>
                        <td>{{ trim(($p->kota ?? '') . ', ' . ($p->provinsi ?? ''), ', ') ?: '-' }}</td>
                        <td>{{ optional($p->suratTugas->first()?->auditor)->nama ?? '-' }}</td>
                        <td><span class="badge badge-info">{{ $p->status }}</span></td>
                        <td>
                            <a class="btn btn-sm" href="{{ route('admin.perusahaan.show', $p) }}">Detail</a>
                            <a class="btn btn-sm" href="{{ route('admin.perusahaan.edit', $p) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.perusahaan.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Hapus pengajuan ini?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="center muted">Belum ada pengajuan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $perusahaans->links() }}</div>
    </div>
@endsection
