@extends('layouts.app')
@section('title','Review Dokumen')
@section('content')
    <div class="page-crumb">Operasional / Verifikasi Dokumen / Review</div>
    <h1 class="page-title">Review Dokumen</h1>
    <p class="page-desc">{{ $document->perusahaan->nama_pelaku_usaha ?? '-' }} &middot; {{ $document->jenis_dokumen }}</p>

    <div class="grid-2">
        <div class="card">
            <h3 class="card-title">Detail Dokumen</h3>
            <dl class="detail-grid">
                <dt>Jenis Dokumen</dt><dd>{{ $document->jenis_dokumen }}</dd>
                <dt>Nama File</dt><dd>{{ $document->nama_file }}</dd>
                <dt>Ukuran</dt><dd>{{ round($document->file_size / 1024) }} KB</dd>
                <dt>Diupload oleh</dt><dd>{{ $document->client->nama_pic ?? '-' }} ({{ $document->client->email ?? '-' }})</dd>
                <dt>Tanggal Upload</dt><dd>{{ $document->created_at->format('d M Y, H:i') }}</dd>
                <dt>Perusahaan</dt><dd>{{ $document->perusahaan->nama_pelaku_usaha ?? '-' }} <br><small class="muted">{{ $document->perusahaan->no_ref ?? '-' }}</small></dd>
                <dt>Status Saat Ini</dt>
                <dd>
                    @if ($document->status === 'approved')
                        <span class="badge badge-success">✓ Disetujui</span>
                    @elseif ($document->status === 'rejected')
                        <span class="badge badge-danger">✗ Ditolak</span>
                    @else
                        <span class="badge badge-warning">Menunggu</span>
                    @endif
                </dd>
                @if ($document->catatan_staf)
                    <dt>Catatan Staf</dt><dd>{{ $document->catatan_staf }}</dd>
                @endif
            </dl>

            <div style="margin-top:14px">
                <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="btn btn-primary">📄 Buka Dokumen di Tab Baru</a>
            </div>

            <hr style="margin:20px 0">

            <h4 style="margin-bottom:12px">Tindakan Verifikasi</h4>

            <form method="POST" action="{{ route('admin.verifikasi-dokumen.approve', $document) }}" class="form">
                @csrf
                <div class="field">
                    <label>Catatan (opsional)</label>
                    <input name="catatan_staf" placeholder="misal: Dokumen lengkap dan sesuai" value="{{ old('catatan_staf') }}">
                </div>
                <button class="btn" style="background:#16a34a;color:#fff;border-color:#16a34a" type="submit">✓ Setujui Dokumen</button>
            </form>

            <form method="POST" action="{{ route('admin.verifikasi-dokumen.reject', $document) }}" class="form" style="margin-top:14px;padding-top:14px;border-top:1px dashed var(--border)">
                @csrf
                <div class="field">
                    <label>Alasan Penolakan <span style="color:var(--danger)">*</span></label>
                    <textarea name="catatan_staf" required minlength="5" placeholder="Jelaskan alasan penolakan agar klien bisa upload ulang dokumen yang benar"></textarea>
                </div>
                <button class="btn btn-danger" type="submit">✗ Tolak Dokumen</button>
            </form>

            @if ($document->status !== 'pending')
                <form method="POST" action="{{ route('admin.verifikasi-dokumen.reset', $document) }}" style="margin-top:14px" onsubmit="return confirm('Reset status ke Menunggu?')">
                    @csrf
                    <button class="btn btn-ghost btn-sm" type="submit">↺ Reset ke Menunggu</button>
                </form>
            @endif

            <div style="margin-top:14px">
                <a href="{{ route('admin.verifikasi-dokumen.index') }}" class="btn btn-sm">← Kembali ke Daftar</a>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">Preview Dokumen</h3>
            @php
                $ext = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                $url = asset('storage/'.$document->file_path);
            @endphp
            @if (in_array($ext, ['jpg','jpeg','png']))
                <img src="{{ $url }}" alt="Preview" style="width:100%;border-radius:8px;border:1px solid var(--border)">
            @elseif ($ext === 'pdf')
                <iframe src="{{ $url }}" style="width:100%;height:600px;border:1px solid var(--border);border-radius:8px"></iframe>
            @else
                <p class="muted center">Format tidak dapat di-preview. Klik "Buka Dokumen di Tab Baru" untuk melihat.</p>
            @endif
        </div>
    </div>

    @if ($sibling->isNotEmpty())
        <div class="card">
            <h3 class="card-title">Dokumen Lain dari Perusahaan Ini</h3>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Jenis</th><th>Nama File</th><th>Upload</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($sibling as $s)
                        <tr>
                            <td>{{ $s->jenis_dokumen }}</td>
                            <td><a href="{{ asset('storage/'.$s->file_path) }}" target="_blank">{{ Str::limit($s->nama_file, 40) }}</a></td>
                            <td class="muted small">{{ $s->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($s->status === 'approved')<span class="badge badge-success">Disetujui</span>
                                @elseif ($s->status === 'rejected')<span class="badge badge-danger">Ditolak</span>
                                @else <span class="badge badge-warning">Menunggu</span>@endif
                            </td>
                            <td><a href="{{ route('admin.verifikasi-dokumen.show', $s) }}" class="btn btn-sm">Review</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
