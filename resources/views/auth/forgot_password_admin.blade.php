@extends('layouts.auth')

@section('title', 'Lupa Password Admin')

@section('content')
<div class="auth-card">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Lupa Password Admin</h3>
        <p class="text-muted mb-0">
            Masukkan email admin yang terdaftar.
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

    <form action="{{ route('admin.password.email') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email Admin</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="admin@email.com"
                required
            >
        </div>

        <button class="btn btn-primary w-100 mb-3">
            Kirim Link Reset Password
        </button>

        <a
            href="{{ route('admin.login') }}"
            class="btn btn-light border w-100"
        >
            Kembali ke Login
        </a>
    </form>
</div>
@endsection