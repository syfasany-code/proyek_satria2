@php($route = Route::currentRouteName())
<aside class="satria-sidebar d-none d-lg-flex flex-column">
    <div class="px-2 mb-4">
        <div class="brand">👥 Satria</div><small>ADMINISTRATOR</small>
    </div>
    <div class="sidebar-menu flex-grow-1"><a class="{{ str_starts_with($route, 'admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">⌂ Dashboard</a><a
            class="{{ str_starts_with($route, 'admin.warga') ? 'active' : '' }}" href="{{ route('admin.warga.index') }}">♙ Data
            Warga</a><a class="{{ str_starts_with($route, 'admin.pembayaran') ? 'active' : '' }}"
            href="{{ route('admin.pembayaran.index') }}">▣ Data Pembayaran</a><a
            class="{{ str_starts_with($route, 'admin.pemasukan') ? 'active' : '' }}"
            href="{{ route('admin.pemasukan.index') }}">↗ Pemasukan Kas</a><a
            class="{{ str_starts_with($route, 'admin.pengeluaran') ? 'active' : '' }}"
            href="{{ route('admin.pengeluaran.index') }}">↘ Pengeluaran Kas</a><a
            class="{{ str_starts_with($route, 'admin.laporan') ? 'active' : '' }}"
            href="{{ route('admin.laporan.index') }}">▤ Laporan Keuangan</a><a
            class="{{ str_starts_with($route, 'admin.profil') ? 'active' : '' }}" href="{{ route('admin.profil') }}">●
            Profil Admin</a></div>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button
                class="btn btn-link text-white text-decoration-none px-2">↪ Keluar</button></form>
    </div>
</aside>
<div class="offcanvas offcanvas-start" tabindex="-1" id="adminMenu">
    <div class="offcanvas-header">
        <div>
            <div class="brand">👥 Satria</div><small>ADMINISTRATOR</small>
        </div><button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body sidebar-menu"><a href="{{ route('admin.dashboard') }}">⌂ Dashboard</a><a
            href="{{ route('admin.warga.index') }}">♙ Data Warga</a><a href="{{ route('admin.pembayaran.index') }}">▣
            Data Pembayaran</a><a href="{{ route('admin.pemasukan.index') }}">↗ Pemasukan Kas</a><a
            href="{{ route('admin.pengeluaran.index') }}">↘ Pengeluaran Kas</a><a
            href="{{ route('admin.laporan.index') }}">▤ Laporan Keuangan</a><a href="{{ route('admin.profil') }}">●
            Profil Admin</a>
        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button
                class="btn btn-link text-white px-0 mt-4">↪ Keluar</button></form>
    </div>
</div>
