@extends('layouts.app')
@section('title','Verifikasi Dokumen')
@section('content')
    <div class="page-crumb">Operasional / Verifikasi Dokumen Klien</div>
    <h1 class="page-title">Verifikasi Dokumen Klien</h1>
    <p class="page-desc">Review dan setujui/tolak dokumen persyaratan yang diupload klien via Portal.</p>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total'] }}</div><div class="stat-label">Total Dokumen</div></div>
        <div class="stat-card"><div class="stat-num" style="color:#d97706">{{ $stats['pending'] }}</div><div class="stat-label">Menunggu Verifikasi</div></div>
        <div class="stat-card"><div class="stat-num" style="color:#16a34a">{{ $stats['approved'] }}</div><div class="stat-label">Disetujui</div></div>
        <div class="stat-card"><div class="stat-num" style="color:#dc2626">{{ $stats['rejected'] }}</div><div class="stat-label">Ditolak</div></div>
    </div>

    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Daftar Dokumen</h3>
            <form method="GET" class="row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari nama perusahaan" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px">
                <select name="perusahaan_id" onchange="this.form.submit()" style="padding:8px;border:1px solid var(--border);border-radius:8px">
                    <option value="">Semua Perusahaan</option>
                    @foreach ($perusahaans as $p)
                        <option value="{{ $p->id }}" @selected(request('perusahaan_id')==$p->id)>{{ $p->nama_pelaku_usaha }}</option>
                    @endforeach
                </select>
                <select name="status" onchange="this.form.submit()" style="padding:8px;border:1px solid var(--border);border-radius:8px">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status')==='pending')>Menunggu</option>
                    <option value="approved" @selected(request('status')==='approved')>Disetujui</option>
                    <option value="rejected" @selected(request('status')==='rejected')>Ditolak</option>
                </select>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th><th>Perusahaan</th><th>Jenis Dokumen</th><th>Nama File</th>
                        <th>Upload</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($documents as $i => $d)
                    <tr>
                        <td>{{ $documents->firstItem() + $i }}</td>
                        <td>
                            <b>{{ $d->perusahaan->nama_pelaku_usaha ?? '-' }}</b>
                            <div class="muted small">{{ $d->perusahaan->no_ref ?? '-' }}</div>
                        </td>
                        <td>{{ $d->jenis_dokumen }}</td>
                        <td>
                            <a href="{{ asset('storage/'.$d->file_path) }}" target="_blank">
                                📎 {{ Str::limit($d->nama_file, 30) }}
                            </a>
                            <div class="muted small">{{ round($d->file_size / 1024) }} KB</div>
                        </td>
                        <td class="muted small">{{ $d->created_at->format('d M Y') }}<br>{{ $d->created_at->format('H:i') }}</td>
                        <td>
                            @if ($d->status === 'approved')
                                <span class="badge badge-success">✓ Disetujui</span>
                            @elseif ($d->status === 'rejected')
                                <span class="badge badge-danger">✗ Ditolak</span>
                            @else
                                <span class="badge badge-warning">Menunggu</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm" href="{{ route('admin.verifikasi-dokumen.show', $d) }}">Review</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="center muted">Belum ada dokumen dari klien.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $documents->links() }}</div>
    </div>
@endsection
