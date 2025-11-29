<div class="sidebar">

    <div class="sidebar-header">
        <h2>Toko Bunga</h2>
    </div>

    <ul class="sidebar-menu">
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
        <li><a href="{{ route('dashboard.profile') }}" class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">Profil</a></li>
        <li><a href="{{ route('dashboard.analytics') }}" class="{{ request()->routeIs('dashboard.analytics') ? 'active' : '' }}">Analitik Keuangan</a></li>
        {{-- Data Admin link removed per request --}}
        @if(auth()->check() && in_array(auth()->user()->role, ['admin','manager']))
            <li>
                <a href="{{ route('dashboard.jenis.index') }}"
                   class="{{ request()->is('dashboard/jenis*') ? 'active' : '' }}">
                    Kelola Produk
                </a>
            </li>
        @endif

        {{-- PANEL MANAGER --}}
        @if(auth()->check() && auth()->user()->role === 'manager')
            <li><a href="{{ route('manager.dashboard') }}" class="{{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">Kalendar</a></li>
            <li><a href="/dashboard/manage-admins" class="{{ request()->is('dashboard/manage-admins') ? 'active' : '' }}">Kelola Admin</a></li>
        @endif
        <li><a href="/dashboard/laporan" class="{{ request()->is('dashboard/laporan') ? 'active' : '' }}">Laporan</a></li>
    </ul>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

</div>