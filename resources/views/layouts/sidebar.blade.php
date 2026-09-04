@php($route = Route::currentRouteName())
<aside class="satria-sidebar d-none d-lg-flex flex-column">
    <div class="px-2 mb-4">
        <div class="brand">👥 Satria</div><small>Sistem Administrasi Transparansi Iuran</small>
    </div>
    <div class="sidebar-menu flex-grow-1"> <a class="{{ str_starts_with($route, 'warga.dashboard') ? 'active' : '' }}"
            href="{{ route('warga.dashboard') }}">⌂ Dashboard</a><a
            class="{{ str_starts_with($route, 'warga.bayar') ? 'active' : '' }}" href="{{ route('warga.bayar') }}">▣ Bayar
            Tagihan Kas</a><a class="{{ str_starts_with($route, 'warga.riwayat') ? 'active' : '' }}"
            href="{{ route('warga.riwayat') }}">▤ Riwayat Pembayaran</a><a
            class="{{ str_starts_with($route, 'warga.profil') ? 'active' : '' }}" href="{{ route('warga.profil') }}">●
            Profil</a></div>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('warga.logout') }}">@csrf<button
                class="btn btn-link text-white text-decoration-none px-2">↪ Keluar</button></form>
    </div>
</aside>
<div class="offcanvas offcanvas-start" tabindex="-1" id="wargaMenu">
    <div class="offcanvas-header">
        <div>
            <div class="brand">👥 Satria</div><small>Sistem Administrasi Transparansi Iuran</small>
        </div><button class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body sidebar-menu"><a href="{{ route('warga.dashboard') }}">⌂ Dashboard</a><a
            href="{{ route('warga.bayar') }}">▣ Bayar Tagihan Kas</a><a href="{{ route('warga.riwayat') }}">▤ Riwayat
            Pembayaran</a><a href="{{ route('warga.profil') }}">● Profil</a>
        <form method="POST" action="{{ route('warga.logout') }}">@csrf<button
                class="btn btn-link text-white px-0 mt-4">↪ Keluar</button></form>
    </div>
</div>
