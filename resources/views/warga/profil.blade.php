@extends('layouts.app')

@section('title', 'Profil Warga')

@section('content')
<div class="mb-3">
    <div class="page-title">Profil</div>
    <div class="small-muted">Kelola informasi akun dan data pribadi Anda.</div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-7">
        <div class="card-satria p-3">
            <div class="section-title mb-3">Data Pribadi</div>
            <form method="POST" action="{{ route('warga.profil.update') }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input name="nama_warga" class="form-control" value="{{ $warga->nama_warga }}" required></div>
                    <div class="col-md-6"><label class="form-label">NIK</label><input class="form-control" value="{{ $warga->nik }}" disabled></div>
                    <div class="col-md-6"><label class="form-label">No. HP</label><input name="no_hp" class="form-control" value="{{ $warga->no_hp }}" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="{{ $warga->email }}" required></div>
                    <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="3" required>{{ $warga->alamat }}</textarea></div>
                </div>
                <button class="btn btn-satria mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card-satria p-3 mb-3">
            <div class="section-title">Informasi Akun</div>
            <div class="list-row"><span class="small-muted">Username</span><strong>{{ $warga->username }}</strong></div>
            <div class="list-row"><span class="small-muted">Status Warga</span><span class="badge badge-soft-success">{{ $warga->status_warga }}</span></div>
            <div class="list-row"><span class="small-muted">Tarif Iuran</span><strong>Rp 15.000 / bulan</strong></div>
        </div>

        <div class="card-satria p-3">
            <div class="section-title mb-3">Ubah Password</div>
            <form method="POST" action="{{ route('warga.profil.password') }}">
                @csrf
                @method('PUT')
                <input class="form-control mb-2" type="password" name="current_password" placeholder="Password lama" required>
                <input class="form-control mb-2" type="password" name="password" placeholder="Password baru" required>
                <input class="form-control mb-3" type="password" name="password_confirmation" placeholder="Konfirmasi password" required>
                <button class="btn btn-outline-primary">Ubah Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
