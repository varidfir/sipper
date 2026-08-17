<style>
    .sipper-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        height: 100dvh;
        background: #fff;
        border-right: 1px solid #e7ebf2;
        padding: 24px 16px;
        z-index: 1000;
        overflow-y: auto;
        overflow-x: hidden;
        box-sizing: border-box;
    }
    .sipper-sidebar * { box-sizing: border-box; }
    .sipper-brand { display:flex; align-items:center; gap:12px; padding:2px 10px 28px; text-decoration:none; color:inherit; }
    .sipper-brand-icon { width:42px; height:42px; flex:0 0 42px; border-radius:12px; background:#2563eb; display:grid; place-items:center; color:#fff; font-weight:800; font-size:18px; box-shadow:0 8px 20px rgba(37,99,235,.22); overflow:hidden; }
    .sipper-brand-icon img { width:100%; height:100%; object-fit:cover; display:block; }
    .sipper-brand strong { display:block; font-size:16px; line-height:1.2; }
    .sipper-brand span { display:block; color:#94a0b2; font-size:11px; margin-top:3px; }
    .sipper-nav-title { padding:0 10px 8px; color:#a0a9b8; font-size:10px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
    .sipper-nav { display:grid; gap:5px; }
    .sipper-nav a { display:flex; align-items:center; gap:11px; padding:11px 12px; border-radius:11px; color:#687386; font-size:13px; font-weight:600; text-decoration:none; transition:background .15s,color .15s; }
    .sipper-nav a:hover { background:#f3f6fb; color:#1f2937; }
    .sipper-nav a.active { background:#eff5ff; color:#2563eb; }
    .sipper-nav-icon { width:18px; flex:0 0 18px; text-align:center; font-size:15px; }
    .sipper-sidebar-bottom { margin-top:22px; border-top:1px solid #e7ebf2; padding-top:16px; }
    .sipper-user-mini { display:flex; align-items:center; gap:10px; padding:9px; text-decoration:none; color:inherit; border-radius:10px; }
    .sipper-user-mini:hover { background:#f8fafc; }
    .sipper-avatar { width:34px; height:34px; flex:0 0 34px; border-radius:10px; background:#eaf1ff; color:#2563eb; display:grid; place-items:center; font-weight:800; font-size:13px; overflow:hidden; }
    .sipper-avatar img { width:100%; height:100%; object-fit:cover; display:block; }
    .sipper-user-name { font-size:12px; font-weight:700; }
    .sipper-user-role { font-size:10px; color:#94a0b2; margin-top:2px; }
    .sipper-content { min-height:100vh; margin-left:250px; width:calc(100% - 250px); box-sizing:border-box; }
    @media (max-width: 760px) {
        .sipper-sidebar { width:220px; padding:18px 12px; }
        .sipper-content { margin-left:220px; width:calc(100% - 220px); }
        .sipper-brand { padding-left:7px; padding-right:7px; }
        .sipper-nav a { font-size:12px; }
    }
</style>

@php
    $sidebarUser = auth()->user();
    $sidebarIsAdmin = strtolower($sidebarUser?->role ?? '') === 'admin';
@endphp

<aside class="sipper-sidebar" aria-label="Navigasi utama">
    <a href="{{ route('dashboard') }}" class="sipper-brand">
        <div class="sipper-brand-icon">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <div><strong>Berita Acara</strong><span>Dispenduk</span></div>
    </a>

    <div class="sipper-nav-title">Menu Utama</div>
    <nav class="sipper-nav">
        <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="sipper-nav-icon">⌂</span>Dashboard</a>
        <a class="{{ request()->routeIs('permohonan.index') || request()->routeIs('permohonan.show') || request()->routeIs('permohonan.edit') ? 'active' : '' }}" href="{{ route('permohonan.index') }}"><span class="sipper-nav-icon">▤</span>Data Permohonan</a>
        <a class="{{ request()->routeIs('permohonan.create') ? 'active' : '' }}" href="{{ route('permohonan.create') }}"><span class="sipper-nav-icon">＋</span>Input Rekap</a>
        <a class="{{ request()->routeIs('permohonan.recap') ? 'active' : '' }}" href="{{ route('permohonan.recap') }}"><span class="sipper-nav-icon">▥</span>Ringkasan Rekap</a>
        <a class="{{ request()->routeIs('permohonan.export') ? 'active' : '' }}" href="{{ route('permohonan.export') }}"><span class="sipper-nav-icon">⇩</span>Export Data</a>
    </nav>

    @if($sidebarIsAdmin)
        <div class="sipper-nav-title" style="margin-top:22px">Administrasi</div>
        <nav class="sipper-nav">
            <a class="{{ request()->routeIs('kecamatan.*') ? 'active' : '' }}" href="{{ route('kecamatan.index') }}"><span class="sipper-nav-icon">⌖</span>Kecamatan</a>
            <a class="{{ request()->routeIs('desa.*') ? 'active' : '' }}" href="{{ route('desa.index') }}"><span class="sipper-nav-icon">⌂</span>Desa</a>
            <a class="{{ request()->routeIs('jenis-pelayanan.*') ? 'active' : '' }}" href="{{ route('jenis-pelayanan.index') }}"><span class="sipper-nav-icon">☷</span>Jenis Pelayanan</a>
            <a class="{{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}"><span class="sipper-nav-icon">♙</span>Pengguna</a>
            <a class="{{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}"><span class="sipper-nav-icon">⚙</span>Pengaturan Admin</a>
        </nav>
    @endif

    <div class="sipper-sidebar-bottom">
        <a href="{{ route('profile.show') }}" class="sipper-user-mini">
            <div class="sipper-avatar">
                <img src="{{ asset('images/logo.png') }}" alt="Avatar">
            </div>
            <div><div class="sipper-user-name">{{ $sidebarUser?->name ?? 'Administrator' }}</div><div class="sipper-user-role">{{ ucfirst($sidebarUser?->role ?? '') }}</div></div>
        </a>
        @if($sidebarIsAdmin)
            <div style="margin-top:10px">
                <form method="POST" action="{{ route('logout') }}" style="margin:0">
                    @csrf
                    <button type="submit" style="width:100%;display:flex;align-items:center;justify-content:space-between;border:1px solid #fee2e2;border-radius:10px;padding:10px 12px;background:#fff7f7;color:#dc2626;font-size:12px;font-weight:700;cursor:pointer"> <span class="q-left">↪ Keluar</span><span class="arrow">›</span></button>
                </form>
            </div>
        @endif
    </div>
</aside>
