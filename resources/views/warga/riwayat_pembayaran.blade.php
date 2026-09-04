@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
            <div class="page-title">Riwayat Pembayaran</div>
            <div class="small-muted">Semua transaksi pembayaran iuran Anda.</div>
        </div>
        <form class="d-flex gap-2">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach (['Pending', 'Disetujui', 'Ditolak'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="card-satria p-3">
        <div class="table-responsive">
            <table class="table table-satria">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal Bayar</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $row)
                        <tr>
                            <td>{{ $row->kode_transaksi }}</td>
                            <td>{{ $row->tanggal_bayar->format('d M Y, H:i') }}</td>
                            <td>Rp {{ number_format($row->nominal_dibayar, 0, ',', '.') }}</td>
                            <td>{{ $row->metode }}</td>
                            <td>
                                @php
                                    $badgeClass = match ($row->status_verifikasi) {
                                        'Disetujui' => 'badge-soft-success',
                                        'Ditolak' => 'badge-soft-danger',
                                        default => 'badge-soft-warning',
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $badgeClass }}">
                                    {{ $row->status_verifikasi }}
                                </span>
                            </td>
                            <td>{{ $row->catatan ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $pembayaran->links() }}
    </div>
@endsection
