@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="page-crumb">Beranda / Dashboard</div>
    <h1 class="page-title">Dashboard</h1>
    <p class="page-desc">Ringkasan operasional sertifikasi halal LPH Hidayatullah.</p>

    <div class="stats">
        <div class="stat-card"><div class="stat-num">{{ $stats['total_pengajuan'] }}</div><div class="stat-label">Total Pengajuan</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['dalam_proses'] }}</div><div class="stat-label">Dalam Proses</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['audit_berjalan'] }}</div><div class="stat-label">Audit Berjalan</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['selesai'] }}</div><div class="stat-label">Selesai</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['total_auditor'] }}</div><div class="stat-label">Total Auditor</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['sertifikat_terbit'] }}</div><div class="stat-label">Sertifikat Terbit</div></div>
        <div class="stat-card"><div class="stat-num">{{ $stats['surat_tugas'] }}</div><div class="stat-label">Surat Tugas</div></div>
        <div class="stat-card"><div class="stat-num">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</div><div class="stat-label">Pendapatan Lunas</div></div>
    </div>

    <div class="card">
        <div class="card-head"><h3 class="card-title">Pengajuan Terbaru</h3>
            <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-sm">Lihat semua</a></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>No. Ref</th><th>Pelaku Usaha</th><th>Skala</th><th>Status</th><th>Tanggal</th></tr></thead>
                <tbody>
                    @forelse ($recent_pengajuan as $p)
                    <tr>
                        <td>{{ $p->no_ref }}</td>
                        <td>{{ $p->nama_pelaku_usaha }}</td>
                        <td>{{ $p->skala }}</td>
                        <td><span class="badge badge-info">{{ $p->status }}</span></td>
                        <td>{{ $p->created_at?->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="center muted">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
