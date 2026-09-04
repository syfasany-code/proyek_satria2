@extends('layouts.admin_app') @section('title', 'Profil Admin') @section('content')<div class="mb-3">
    <div class="page-title">Profil Admin</div>
    <div class="small-muted">Kelola informasi administrator.</div>
</div>
<div class="row g-3">
    <div class="col-12 col-lg-7">
        <div class="card-satria p-3">
            <div class="section-title mb-3">Informasi Pribadi</div>
            <form method="POST" action="{{ route('admin.profil.update') }}">@csrf @method('PUT')<div class="row g-2">
                    <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input name="nama_admin"
                            class="form-control" value="{{ $admin->nama_admin }}"></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input name="email"
                            class="form-control" value="{{ $admin->email }}"></div>
                    <div class="col-md-6"><label class="form-label">No HP</label><input name="no_hp"
                            class="form-control" value="{{ $admin->no_hp }}"></div>
                    <div class="col-md-6"><label class="form-label">Role</label><input class="form-control"
                            value="{{ $admin->role }}" disabled></div>
                </div><button class="btn btn-satria mt-3">Ubah Profil</button></form>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card-satria p-3">
            <div class="section-title mb-3">Keamanan Akun</div>
            <form method="POST" action="{{ route('admin.profil.password') }}">@csrf @method('PUT')<input
                    type="password" name="current_password" class="form-control mb-2" placeholder="Password lama"
                    required><input type="password" name="password" class="form-control mb-2"
                    placeholder="Password baru" required><input type="password" name="password_confirmation"
                    class="form-control mb-3" placeholder="Konfirmasi password" required><button
                    class="btn btn-outline-primary">Ubah Password</button></form>
        </div>
    </div>
</div>@endsection
