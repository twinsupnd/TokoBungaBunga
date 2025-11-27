<div class="sidebar">

    <div class="sidebar-header">
        <h2>Toko Bunga</h2>
    </div>

    <ul class="sidebar-menu">
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/dashboard/profil">Profil</a></li>
        <li><a href="/dashboard/analitik">Analitik Keuangan</a></li>
        <li><a href="/dashboard/admin">Data Admin</a></li>
        <li><a href="/dashboard/laporan">Laporan</a></li>
    </ul>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

</div>
