@extends('layouts.app')
@section('title','Manajemen Klien')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Klien Portal</div>
    <h1 class="page-title">Manajemen Klien Portal</h1>
    <p class="page-desc">Kelola akun PIC klien yang terdaftar di portal.</p>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-label">Total Akun Klien</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['aktif'] }}</div><div class="stat-label">Akun Aktif</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['nonaktif'] }}</div><div class="stat-label">Nonaktif</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['perusahaan_terhubung'] }}</div><div class="stat-label">Perusahaan Terhubung</div></div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Daftar Akun Klien</h3>
            <form method="GET" class="row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari nama / email / perusahaan" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;min-width:240px">
                <select name="status" onchange="this.form.submit()" style="padding:8px;border:1px solid var(--border);border-radius:8px">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status')==='aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status')==='nonaktif')>Nonaktif</option>
                </select>
                <button class="btn" type="submit">Cari</button>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama PIC</th><th>Email</th><th>Jabatan</th><th>Perusahaan</th><th>Terdaftar</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($clients as $i => $c)
                        <tr>
                            <td>{{ $clients->firstItem() + $i }}</td>
                            <td><b>{{ $c->nama_pic }}</b><br><small class="muted">{{ $c->no_hp ?? '-' }}</small></td>
                            <td>{{ $c->email }}</td>
                            <td>{{ $c->jabatan ?? '-' }}</td>
                            <td>
                                @if ($c->perusahaan)
                                    <a href="{{ route('admin.perusahaan.show', $c->perusahaan) }}">{{ $c->perusahaan->nama_pelaku_usaha }}</a>
                                    <br><small class="muted">{{ $c->perusahaan->no_ref }}</small>
                                @else
                                    <span class="muted">— tidak terhubung —</span>
                                @endif
                            </td>
                            <td>{{ $c->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($c->is_active)<span class="badge badge-success">Aktif</span>
                                @else<span class="badge badge-muted">Nonaktif</span>@endif
                            </td>
                            <td>
                                <a class="btn btn-sm" href="{{ route('admin.klien.show', $c) }}">Detail</a>
                                <form method="POST" action="{{ route('admin.klien.toggle', $c) }}" style="display:inline">
                                    @csrf
                                    <button class="btn btn-sm" type="submit">{{ $c->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                </form>
                                <form method="POST" action="{{ route('admin.klien.reset-password', $c) }}" style="display:inline" onsubmit="return confirm('Reset password {{ $c->nama_pic }}?')">
                                    @csrf
                                    <button class="btn btn-sm" type="submit">Reset Pass</button>
                                </form>
                                <form method="POST" action="{{ route('admin.klien.destroy', $c) }}" style="display:inline" onsubmit="return confirm('Hapus permanen akun ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="center muted">Belum ada klien terdaftar di portal.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $clients->links() }}</div>
    </div>
@endsection
