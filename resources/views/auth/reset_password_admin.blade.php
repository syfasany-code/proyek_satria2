@extends('layouts.auth')

@section('title', 'Reset Password Admin')

@section('content')
<div class="auth-card">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Reset Password Admin</h3>
        <p class="text-muted mb-0">
            Buat password baru untuk akun admin.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.password.update') }}" method="POST">
        @csrf

        <input
            type="hidden"
            name="token"
            value="{{ $token }}"
        >

        <div class="mb-3">
            <label class="form-label">Email Admin</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email', $email) }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Password Baru</label>

            <input
                type="password"
                name="password"
                class="form-control"
                required
            >
        </div>

        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>

            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button class="btn btn-primary w-100">
            Simpan Password Baru
        </button>
    </form>
</div>
@endsection