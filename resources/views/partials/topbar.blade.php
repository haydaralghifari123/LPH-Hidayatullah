@php $user = auth()->user(); @endphp
<header class="topbar">
    <div class="search">
        <input type="text" placeholder="Cari pengajuan, klien, auditor...">
    </div>
    <div class="user-area">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 2)) }}</div>
            <div>
                <div class="user-name">{{ $user->nama_lengkap ?? 'User' }}</div>
                <div class="user-role">{{ ucfirst($user->role ?? '') }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">
            @csrf
            <button class="btn btn-ghost" type="submit">Keluar</button>
        </form>
    </div>
</header>
