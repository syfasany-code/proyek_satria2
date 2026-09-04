@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="mb-3">
    <div class="page-title">Dashboard</div>
    <div class="small-muted">Selamat datang, {{ $warga->nama_warga }} 👋<br>Berikut ringkasan keuangan Kampung Ciliwung.</div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12 col-sm-6 col-xl-3"><div class="card-satria stat-card h-100"><div class="stat-title">Total Uang Kas Terkumpul</div><div class="stat-value">Rp {{ number_format($totalIn - $totalOut, 0, ',', '.') }}</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card-satria stat-card h-100"><div class="stat-title">Total Pemasukan</div><div class="stat-value money-green">Rp {{ number_format($totalIn, 0, ',', '.') }}</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card-satria stat-card h-100"><div class="stat-title">Total Pengeluaran</div><div class="stat-value money-red">Rp {{ number_format($totalOut, 0, ',', '.') }}</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-satria stat-card h-100">
            <div class="stat-title">Status Pembayaran Iuran</div>
            <div class="mt-2"><span class="badge rounded-pill {{ $status['status'] === 'Lunas' ? 'badge-soft-success' : 'badge-soft-danger' }}">{{ $status['status'] }}</span></div>
            <div class="small-muted mt-2">
                @if($status['status'] === 'Lunas')
                    Iuran bulan berjalan sudah lunas.
                @else
                    Kekurangan: Rp {{ number_format($status['kekurangan'], 0, ',', '.') }}
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-6">
        <div class="card-satria p-3 h-100">
            <div class="d-flex justify-content-between"><div class="section-title">Riwayat Pemasukan</div></div>
            @forelse($pemasukan as $row)
                <div class="list-row d-flex justify-content-between gap-3"><div><div class="small fw-bold">● {{ $row->sumber_pemasukan }}</div><div class="small-muted">{{ $row->tanggal->format('d M Y') }}</div></div><strong class="money-green text-nowrap">Rp {{ number_format($row->nominal, 0, ',', '.') }}</strong></div>
            @empty
                <div class="small-muted py-4">Belum ada pemasukan.</div>
            @endforelse
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card-satria p-3 h-100">
            <div class="section-title">Riwayat Pengeluaran</div>
            @forelse($pengeluaran as $row)
                <div class="list-row d-flex justify-content-between gap-3"><div><div class="small fw-bold">● {{ $row->keperluan }}</div><div class="small-muted">{{ $row->tanggal->format('d M Y') }}</div></div><strong class="money-red text-nowrap">Rp {{ number_format($row->nominal, 0, ',', '.') }}</strong></div>
            @empty
                <div class="small-muted py-4">Belum ada pengeluaran.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
