<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Satria Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/satria.css') }}" rel="stylesheet">
</head>

<body>@include('layouts.admin_sidebar')<div class="main-wrap">
        <header class="topbar"><button class="btn btn-outline-primary mobile-menu" data-bs-toggle="offcanvas"
                data-bs-target="#adminMenu">☰</button>
            <div class="ms-auto d-flex align-items-center gap-2"><span class="small-muted">🔔</span>
                <div class="avatar">{{ strtoupper(substr(auth('admin')->user()->nama_admin, 0, 1)) }}</div>
                <div class="hide-sm"><strong style="font-size:12px">{{ auth('admin')->user()->nama_admin }}</strong>
                    <div class="small-muted">{{ auth('admin')->user()->role }}</div>
                </div>
            </div>
        </header>
        <main class="content">
            @if (session('success'))
                <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                    @endif 
                    @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/satria.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>@stack('scripts')
</body>

</html>
