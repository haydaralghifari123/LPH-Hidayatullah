@php $client = auth('client')->user(); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal') &middot; LPH Hidayatullah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
<div class="portal-shell">
    <aside class="portal-sidebar">
        <a href="{{ route('landing') }}" class="brand">
            <div class="brand-mark">L</div>
            <div>
                <div class="brand-name">LPH Hidayatullah</div>
                <div class="brand-tag">Portal Klien</div>
            </div>
        </a>
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr($client->nama_pic ?? 'K', 0, 2)) }}</div>
            <div>
                <div class="user-name">{{ $client->nama_pic ?? '' }}</div>
                <div class="user-role">{{ optional($client->perusahaan)->nama_pelaku_usaha ?? 'Klien' }}</div>
            </div>
        </div>
        <nav>
            <a href="{{ route('portal.dashboard') }}" class="{{ request()->routeIs('portal.dashboard') ? 'active' : '' }}"><x-icon name="home" size="18"/> Dashboard</a>
            <a href="{{ route('portal.profil') }}" class="{{ request()->routeIs('portal.profil') ? 'active' : '' }}"><x-icon name="user" size="18"/> Profil Perusahaan</a>
            <a href="{{ route('portal.dokumen') }}" class="{{ request()->routeIs('portal.dokumen') ? 'active' : '' }}"><x-icon name="document" size="18"/> Dokumen</a>
            <a href="{{ route('portal.penawaran') }}" class="{{ request()->routeIs('portal.penawaran') ? 'active' : '' }}"><x-icon name="wallet" size="18"/> Penawaran Biaya</a>
            <a href="{{ route('portal.invoice') }}" class="{{ request()->routeIs('portal.invoice') ? 'active' : '' }}"><x-icon name="receipt" size="18"/> Invoice</a>
        </nav>
        <form method="POST" action="{{ route('portal.logout') }}" class="logout-form">
            @csrf
            <button type="submit"><x-icon name="log-out" size="14"/> Keluar</button>
        </form>
    </aside>
    <main class="portal-main">
        <div class="portal-content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:18px">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
