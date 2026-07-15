@php
    $user = auth()->user();
    $isOps = $user && $user->role === 'operasional';
    $isKeu = $user && $user->role === 'keuangan';
    $pendingDocs = \App\Models\ClientDocument::where('status', 'pending')->count();
@endphp
<aside class="sidebar">
    <div class="brand">
        <div class="brand-logo">L</div>
        <div>
            <div class="brand-title">LPH Hidayatullah</div>
            <div class="brand-sub">Sertifikasi Halal</div>
        </div>
    </div>

    <div class="nav-group-label">OPERASIONAL</div>
    <nav class="nav">
        <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
        @if ($isOps || $isKeu)
            <a class="nav-item {{ request()->routeIs('auditor.*') ? 'active' : '' }}" href="{{ route('admin.auditor.index') }}">Manajemen Auditor</a>
            <a class="nav-item {{ request()->routeIs('pemilihan-auditor.*') ? 'active' : '' }}" href="{{ route('admin.pemilihan-auditor.index') }}">Pemilihan Auditor</a>
            <a class="nav-item {{ request()->routeIs('perusahaan.*') ? 'active' : '' }}" href="{{ route('admin.perusahaan.index') }}">Data Perusahaan</a>
            <a class="nav-item {{ request()->routeIs('verifikasi-dokumen.*') ? 'active' : '' }}" href="{{ route('admin.verifikasi-dokumen.index') }}">
                Verifikasi Dokumen
                @if ($pendingDocs > 0)<span class="nav-badge">{{ $pendingDocs }}</span>@endif
            </a>
            <a class="nav-item {{ request()->routeIs('surat-tugas.*') ? 'active' : '' }}" href="{{ route('admin.surat-tugas.index') }}">Surat Tugas</a>
            <a class="nav-item {{ request()->routeIs('sertifikat.*') ? 'active' : '' }}" href="{{ route('admin.sertifikat.index') }}">Surat Halal Terbit</a>
            <a class="nav-item {{ request()->routeIs('klien.*') ? 'active' : '' }}" href="{{ route('admin.klien.index') }}">Manajemen Klien</a>
        @endif
    </nav>

    <div class="nav-group-label">KEUANGAN</div>
    <nav class="nav">
        @if ($isOps || $isKeu)
            <a class="nav-item {{ request()->routeIs('penawaran.*') ? 'active' : '' }}" href="{{ route('admin.penawaran.index') }}">Input Penawaran</a>
            <a class="nav-item {{ request()->routeIs('biaya-client.*') ? 'active' : '' }}" href="{{ route('admin.biaya-client.index') }}">Input Biaya Client</a>
            <a class="nav-item {{ request()->routeIs('invoice.*') ? 'active' : '' }}" href="{{ route('admin.invoice.index') }}">Buat Invoice</a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <small>&copy; {{ date('Y') }} LPH Hidayatullah &middot; v1.0</small>
    </div>
</aside>
