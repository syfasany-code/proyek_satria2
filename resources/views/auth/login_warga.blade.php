<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Warga - Satria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/satria.css') }}" rel="stylesheet">
</head>

<body class="login-page">
<div class="login-card">
    <div class="text-center mb-4">
        <div class="brand-login fs-4">👥 Satria</div>
        <div class="small-muted">Sistem Administrasi Transparansi Iuran</div>
    </div>

    <h5 class="fw-bold">Masuk sebagai Warga</h5>
    <p class="small-muted">Kelola pembayaran iuran dan lihat transparansi kas.</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('warga.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Username / NIK</label>
            <input
                name="login"
                class="form-control"
                value="{{ old('login') }}"
                placeholder="Masukkan username atau NIK"
                required
            >
        </div>

        <div class="mb-2">
            <label class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            >
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    id="rememberWarga"
                >
                <label class="form-check-label small" for="rememberWarga">
                    Ingat Saya
                </label>
            </div>

            <a
                class="small text-decoration-none"
                href="{{ route('warga.password.request') }}"
            >
                Lupa Password?
            </a>
        </div>

        <button class="btn btn-satria w-100">
            Masuk
        </button>
    </form>

    <div class="text-center mt-3">
        <a
            class="small text-decoration-none"
            href="{{ route('admin.login') }}"
        >
            Login Administrator
        </a>
    </div>
</div>
</body>
</html>