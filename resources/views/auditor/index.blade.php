@extends('layouts.app')
@section('title', 'Manajemen Auditor')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Auditor</div>
    <h1 class="page-title">Manajemen Data Auditor</h1>
    <p class="page-desc">Kelola data lengkap auditor yang terdaftar di LPH Hidayatullah.</p>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-label">Total Auditor</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['aktif'] }}</div><div class="stat-label">Auditor Aktif</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['bertugas'] }}</div><div class="stat-label">Sedang Bertugas</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['cuti'] }}</div><div class="stat-label">Cuti / Non-aktif</div></div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Daftar Auditor</h3>
            <form method="GET" class="row">
                <input class="search" name="q" value="{{ request('q') }}" placeholder="Cari nama / no. registrasi" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px">
                <select name="status" onchange="this.form.submit()" style="padding:8px;border:1px solid var(--border);border-radius:8px">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status')==='aktif')>Aktif</option>
                    <option value="non-aktif" @selected(request('status')==='non-aktif')>Non-aktif</option>
                    <option value="cuti" @selected(request('status')==='cuti')>Cuti</option>
                </select>
                <a href="{{ route('admin.auditor.create') }}" class="btn btn-primary">+ Tambah Auditor</a>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Auditor</th><th>Alamat</th><th>Email</th><th>No. Registrasi</th><th>Pendidikan</th><th>Kompetensi</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($auditors as $i => $a)
                    <tr>
                        <td>{{ $auditors->firstItem() + $i }}</td>
                        <td><b>{{ $a->nama }}</b></td>
                        <td>{{ $a->alamat ?? '-' }}</td>
                        <td>{{ $a->email ?? '-' }}</td>
                        <td>{{ $a->no_registrasi }}</td>
                        <td>{{ $a->pendidikan_s1 ?? '-' }}</td>
                        <td>{{ $a->kompetensi }}</td>
                        <td>
                            @if($a->status==='aktif')<span class="badge badge-success">Aktif</span>
                            @elseif($a->status==='cuti')<span class="badge badge-warning">Cuti</span>
                            @else<span class="badge badge-muted">Non-aktif</span>@endif
                        </td>
                        <td>
                            <a class="btn btn-sm" href="{{ route('admin.auditor.show', $a) }}">Detail</a>
                            <a class="btn btn-sm" href="{{ route('admin.auditor.edit', $a) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.auditor.destroy', $a) }}" style="display:inline" onsubmit="return confirm('Hapus auditor ini?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="center muted">Belum ada auditor.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $auditors->links() }}</div>
    </div>
@endsection
