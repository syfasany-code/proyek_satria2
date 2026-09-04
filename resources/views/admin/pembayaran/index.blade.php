@extends('layouts.admin_app') @section('title', 'Data Pembayaran') @section('content')<div class="mb-3">
    <div class="page-title">Data Pembayaran</div>
    <div class="small-muted">Verifikasi pembayaran warga.</div>
</div>
<div class="card-satria p-3">
    <form class="row g-2 mb-3">
        <div class="col-md-4"><select name="status" class="form-select">
                <option value="">Semua Status</option>
                @foreach (['Pending', 'Disetujui', 'Ditolak'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-satria">Filter</button></div>
    </form>
    <div class="table-responsive">
        <table class="table table-satria">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Warga</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $i => $p)
                    <tr>
                        <td>{{ $pembayaran->firstItem() + $i }}</td>
                        <td>{{ $p->warga->nama_warga }}</td>
                        <td>{{ $p->kode_transaksi }}</td>
                        <td>{{ $p->tanggal_bayar->format('d M Y H:i') }}</td>
                        <td>Rp {{ number_format($p->nominal_dibayar, 0, ',', '.') }}</td>
                        <td>{{ $p->metode }}</td>
                        <td><span
                                class="badge rounded-pill {{ $p->status_verifikasi === 'Disetujui' ? 'badge-soft-success' : ($p->status_verifikasi === 'Ditolak' ? 'badge-soft-danger' : 'badge-soft-warning') }}">{{ $p->status_verifikasi }}</span>
                        </td>
                        <td>
                            @if ($p->status_verifikasi === 'Pending')
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#verify{{ $p->id_pembayaran }}">Verifikasi</button>@else<span
                                    class="small-muted">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @if ($p->status_verifikasi === 'Pending')
                        <div class="modal fade" id="verify{{ $p->id_pembayaran }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.pembayaran.verify', $p) }}">@csrf
                                        @method('PUT')<div class="modal-header">
                                            <h5>Verifikasi Pembayaran</h5><button class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="small">{{ $p->warga->nama_warga }} membayar <strong>Rp
                                                    {{ number_format($p->nominal_dibayar, 0, ',', '.') }}</strong>.</p>
                                            <select name="status_verifikasi" class="form-select mb-2">
                                                <option>Disetujui</option>
                                                <option>Ditolak</option>
                                            </select>
                                            <textarea name="catatan" class="form-control" placeholder="Catatan"></textarea>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-satria">Simpan
                                                Verifikasi</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>{{ $pembayaran->links() }}
</div>@endsection
