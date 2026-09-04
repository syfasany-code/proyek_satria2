@extends('layouts.admin_app') @section('title', 'Pemasukan Kas') @section('content')<div class="d-flex justify-content-between mb-3">
    <div>
        <div class="page-title">Pemasukan Kas</div>
        <div class="small-muted">Catat dan kelola pemasukan kas.</div>
    </div><button class="btn btn-satria" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Pemasukan</button>
</div>
<div class="card-satria p-3">
    <div class="table-responsive">
        <table class="table table-satria">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Sumber</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $r)
                    <tr>
                        <td>{{ $r->tanggal->format('d M Y') }}</td>
                        <td>{{ $r->sumber_pemasukan }}</td>
                        <td>{{ $r->keterangan }}</td>
                        <td class="money-green fw-bold">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                        <td>
                            @if (!$r->id_pembayaran)
                                <form method="POST" action="{{ route('admin.pemasukan.destroy', $r) }}"
                                    data-confirm="Hapus pemasukan ini?">@csrf @method('DELETE')<button
                                    class="btn btn-sm btn-outline-danger">Hapus</button></form>@else<span
                                    class="small-muted">Pembayaran</span>
                            @endif
                        </td>
                </tr>@empty<tr>
                        <td colspan="5" class="text-center py-4">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total Pemasukan</th>
                    <th colspan="2">Rp {{ number_format($items->sum('nominal'), 0, ',', '.') }}*</th>
                </tr>
            </tfoot>
        </table>
    </div>{{ $items->links() }}<div class="small-muted">* Total pada halaman aktif. Ringkasan periode tersedia di
        Laporan Keuangan.</div>
</div>
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.pemasukan.store') }}">@csrf<div class="modal-header">
                    <h5>Tambah Pemasukan</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"><input type="date" name="tanggal" class="form-control mb-2"
                        value="{{ now()->format('Y-m-d') }}" required><input name="sumber_pemasukan"
                        class="form-control mb-2" placeholder="Sumber pemasukan" required>
                    <textarea name="keterangan" class="form-control mb-2" placeholder="Keterangan" required></textarea><input type="number" name="nominal" class="form-control"
                        placeholder="Nominal" min="1" required>
                </div>
                <div class="modal-footer"><button class="btn btn-satria">Simpan</button></div>
            </form>
        </div>
    </div>
</div>@endsection
