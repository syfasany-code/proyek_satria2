@extends('layouts.auth')

@section('title', 'Lupa Password Warga')

@section('content')
<div class="auth-card">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Lupa Password</h3>
        <p class="text-muted mb-0">
            Masukkan email yang terdaftar pada akun warga.
        </p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('warga.password.email') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="contoh@email.com"
                required
            >
        </div>

        <button class="btn btn-primary w-100 mb-3">
            Kirim Link Reset Password
        </button>

        <a
            href="{{ route('warga.login') }}"
            class="btn btn-light border w-100"
        >
            Kembali ke Login
        </a>
    </form>
</div>
@endsection