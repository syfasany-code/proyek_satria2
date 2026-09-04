@extends('layouts.admin_app') @section('title', 'Laporan Keuangan') @section('content')<div
    class="d-flex justify-content-between align-items-end mb-3">
    <div>
        <div class="page-title">Laporan Keuangan</div>
        <div class="small-muted">Ringkasan kas berdasarkan periode.</div>
    </div>
    <div class="d-flex gap-2"><button class="btn btn-outline-secondary" onclick="window.print()">Cetak</button><a
            class="btn btn-success"
            href="{{ route('admin.laporan.export', ['from' => $from->format('Y-m-d'), 'to' => $to->format('Y-m-d')]) }}">Export
            CSV</a></div>
</div>
<div class="card-satria p-3 mb-3">
    <form class="row g-2">
        <div class="col-md-4"><label class="form-label">Dari</label><input type="date" name="from"
                class="form-control" value="{{ $from->format('Y-m-d') }}"></div>
        <div class="col-md-4"><label class="form-label">Sampai</label><input type="date" name="to"
                class="form-control" value="{{ $to->format('Y-m-d') }}"></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-satria w-100">Terapkan</button></div>
    </form>
</div>
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card-satria stat-card">
            <div class="stat-title">Total Pemasukan</div>
            <div class="stat-value money-green">Rp {{ number_format($totalIn, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-satria stat-card">
            <div class="stat-title">Total Pengeluaran</div>
            <div class="stat-value money-red">Rp {{ number_format($totalOut, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-satria stat-card">
            <div class="stat-title">Saldo Akhir Periode</div>
            <div class="stat-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
        </div>
    </div>
</div>
<div class="card-satria p-3">
    <div class="section-title mb-2">Ringkasan Arus Kas</div>
    <div class="table-responsive">
        <table class="table table-satria">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemasukan as $r)
                    <tr>
                        <td>{{ $r->tanggal->format('d M Y') }}</td>
                        <td><span class="badge badge-soft-success">Pemasukan</span></td>
                        <td>{{ $r->keterangan }}</td>
                        <td class="money-green">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach @foreach ($pengeluaran as $r)
                        <tr>
                            <td>{{ $r->tanggal->format('d M Y') }}</td>
                            <td><span class="badge badge-soft-danger">Pengeluaran</span></td>
                            <td>{{ $r->keterangan }}</td>
                            <td class="money-red">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>@endsection
