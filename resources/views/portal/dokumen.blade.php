@extends('portal.layout')
@section('title','Dokumen')
@section('content')
<h1 class="page-title">Dokumen Persyaratan</h1>
<p class="page-desc">Upload dokumen persyaratan sertifikasi halal. Staf LPH akan memverifikasi setiap dokumen.</p>

<div class="card">
    <h3 class="card-title">Upload Dokumen Baru</h3>
    <form method="POST" action="{{ route('portal.dokumen.upload') }}" enctype="multipart/form-data" class="form">
        @csrf
        <div class="grid-2">
            <div class="field">
                <label>Jenis Dokumen *</label>
                <select name="jenis_dokumen" required>
                    <option value="">— Pilih jenis dokumen —</option>
                    @foreach ($jenisDokumen as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>File (PDF/JPG/PNG max 5MB) *</label>
                <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
        </div>
        <div class="row" style="justify-content:flex-end">
            <button class="btn btn-primary" type="submit">Upload</button>
        </div>
    </form>
</div>

<div class="card">
    <h3 class="card-title">Checklist Dokumen</h3>
    <div class="doc-checklist">
        @foreach ($jenisDokumen as $key => $label)
            @php $files = $documents->get($key) ?? collect(); @endphp
            <div class="doc-item">
                <div class="doc-item-head">
                    <div>
                        <b>{{ $label }}</b>
                        @if ($files->isEmpty())
                            <span class="badge badge-muted">Belum diupload</span>
                        @else
                            @php $approved = $files->firstWhere('status','approved'); @endphp
                            @if ($approved)
                                <span class="badge badge-success">✓ Terverifikasi</span>
                            @elseif ($files->firstWhere('status','rejected'))
                                <span class="badge badge-danger">Ditolak — upload ulang</span>
                            @else
                                <span class="badge badge-warning">Menunggu verifikasi</span>
                            @endif
                        @endif
                    </div>
                </div>
                @foreach ($files as $file)
                    <div class="doc-file">
                        <div>
                            <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">📄 {{ $file->nama_file }}</a>
                            <small class="muted">· {{ round($file->file_size / 1024) }} KB · {{ $file->created_at->format('d M Y') }}</small>
                        </div>
                        <div>
                            <span class="badge badge-{{ $file->status === 'approved' ? 'success' : ($file->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($file->status) }}</span>
                            @if ($file->catatan_staf)<div class="muted small" style="margin-top:4px">Catatan: {{ $file->catatan_staf }}</div>@endif
                            @if ($file->status !== 'approved')
                                <form method="POST" action="{{ route('portal.dokumen.destroy', $file) }}" style="display:inline" onsubmit="return confirm('Hapus dokumen?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection
