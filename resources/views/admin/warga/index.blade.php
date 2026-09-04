@extends('layouts.admin_app')

@section('title', 'Data Warga')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-3 gap-2">
        <div>
            <div class="page-title">Data Warga</div>
            <div class="small-muted">Kelola data warga Kampung Ciliwung dan lihat status pembayaran.</div>
        </div>
        <button class="btn btn-satria" data-bs-toggle="modal" data-bs-target="#addWarga">+ Tambah Warga</button>
    </div>

    <div class="card-satria p-3">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-12 col-lg-6">
                <label class="form-label">Pencarian</label>
                <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau NIK...">
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label">Status Pembayaran</label>
                <select name="status_pembayaran" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Lunas" @selected(request('status_pembayaran') === 'Lunas')>Lunas</option>
                    <option value="Menunggak" @selected(request('status_pembayaran') === 'Menunggak')>Menunggak</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-end gap-2">
                <button class="btn btn-satria flex-grow-1">Filter</button>
                <a href="{{ route('admin.warga.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-satria align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Status Warga</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wargas as $i => $w)
                        <tr>
                            <td>{{ $wargas->firstItem() + $i }}</td>
                            <td class="fw-bold">{{ $w->nama_warga }}</td>
                            <td>{{ $w->nik }}</td>
                            <td>{{ $w->no_hp }}</td>
                            <td>{{ $w->alamat }}</td>
                            <td>
                                <span
                                    class="badge rounded-pill {{ $w->status_warga === 'Aktif' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ $w->status_warga }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge rounded-pill {{ $w->status_pembayaran['status'] === 'Lunas' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ $w->status_pembayaran['status'] }}
                                </span>
                                @if ($w->status_pembayaran['status'] === 'Menunggak')
                                    <div class="small-muted mt-1">Kurang Rp
                                        {{ number_format($w->status_pembayaran['kekurangan'], 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $w->id_warga }}">✎</button>
                                <form class="d-inline" method="POST" action="{{ route('admin.warga.destroy', $w) }}"
                                    data-confirm="Hapus warga ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">⌫</button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="edit{{ $w->id_warga }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.warga.update', $w) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Warga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6"><label class="form-label">Nama</label><input
                                                        name="nama_warga" class="form-control" value="{{ $w->nama_warga }}"
                                                        required></div>
                                                <div class="col-md-6"><label class="form-label">NIK</label><input
                                                        name="nik" class="form-control" value="{{ $w->nik }}"
                                                        required></div>
                                                <div class="col-md-6"><label class="form-label">Email</label><input
                                                        name="email" type="email" class="form-control"
                                                        value="{{ $w->email }}" required></div>
                                                <div class="col-md-6"><label class="form-label">No HP</label><input
                                                        name="no_hp" class="form-control" value="{{ $w->no_hp }}"
                                                        required></div>
                                                <div class="col-12"><label class="form-label">Alamat</label>
                                                    <textarea name="alamat" class="form-control" rows="2" required>{{ $w->alamat }}</textarea>
                                                </div>
                                                <div class="col-md-6"><label class="form-label">Username</label><input
                                                        name="username" class="form-control" value="{{ $w->username }}"
                                                        required></div>
                                                <div class="col-md-3"><label class="form-label">Status Warga</label><select
                                                        name="status_warga" class="form-select">
                                                        <option value="Aktif" @selected($w->status_warga === 'Aktif')>Aktif</option>
                                                        <option value="Nonaktif" @selected($w->status_warga === 'Nonaktif')>Nonaktif
                                                        </option>
                                                    </select></div>
                                                <div class="col-md-3"><label class="form-label">Tanggal
                                                        Bergabung</label><input type="date" name="tanggal_bergabung"
                                                        class="form-control"
                                                        value="{{ optional($w->tanggal_bergabung)->format('Y-m-d') }}"
                                                        required></div>
                                                <div class="col-12">
                                                    <div class="notice">Status pembayaran hanya bisa dilihat dan dihitung
                                                        otomatis dari pembayaran yang sudah disetujui.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-satria">Simpan</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 small-muted">Belum ada data warga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $wargas->links() }}
    </div>

    <div class="modal fade" id="addWarga" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.warga.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Warga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Nama</label><input name="nama_warga"
                                    class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">NIK</label><input name="nik"
                                    class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input name="email"
                                    type="email" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">No HP</label><input name="no_hp"
                                    class="form-control" required></div>
                            <div class="col-12"><label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-md-4"><label class="form-label">Username</label><input name="username"
                                    class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label">Password</label><input name="password"
                                    type="password" class="form-control" minlength="8" required></div>
                            <div class="col-md-4"><label class="form-label">Tanggal Bergabung</label><input
                                    name="tanggal_bergabung" type="date" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}" required></div>
                            <div class="col-md-6"><label class="form-label">Status Warga</label><select
                                    name="status_warga" class="form-select">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select></div>
                        </div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-satria">Tambah Warga</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection
