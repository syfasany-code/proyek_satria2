@extends('layouts.admin_app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end mb-3 gap-2">
    <div>
        <div class="page-title">Dashboard</div>
        <div class="small-muted">Berikut ringkasan keuangan Kampung Ciliwung.</div>
    </div>
    <form method="GET" class="d-flex flex-wrap gap-2">
        <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="form-control">
        <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="form-control">
        <button class="btn btn-satria">Filter</button>
    </form>
</div>

<div class="row g-3 mb-3">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-satria stat-card h-100">
            <div class="stat-title">Saldo Kas Saat Ini</div>
            <div class="stat-value">Rp {{ number_format($saldoKas, 0, ',', '.') }}</div>
            <div class="small-muted mt-2">Saldo kumulatif, tidak di-reset setiap bulan.</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-satria stat-card h-100">
            <div class="stat-title">Pemasukan Periode</div>
            <div class="stat-value money-green">Rp {{ number_format($pemasukanPeriode, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-satria stat-card h-100">
            <div class="stat-title">Pengeluaran Periode</div>
            <div class="stat-value money-red">Rp {{ number_format($pengeluaranPeriode, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-satria stat-card h-100">
            <div class="stat-title">Warga Terdaftar</div>
            <div class="stat-value">{{ number_format($jumlahWarga, 0, ',', '.') }}</div>
            <div class="small-muted mt-2">Total seluruh data warga.</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12">
        <div class="card-satria p-3">
            <div class="section-title mb-2">Grafik Arus Kas</div>
            <div class="chart-box"><canvas id="cashChart"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-6">
        <div class="card-satria p-3 h-100">
            <div class="section-title">Pemasukan Terbaru</div>
            @forelse($recentIn as $r)
                <div class="list-row d-flex justify-content-between gap-3">
                    <span class="small">{{ $r->keterangan }}</span>
                    <strong class="money-green text-nowrap">Rp {{ number_format($r->nominal, 0, ',', '.') }}</strong>
                </div>
            @empty
                <div class="small-muted py-4">Belum ada pemasukan.</div>
            @endforelse
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card-satria p-3 h-100">
            <div class="section-title">Pengeluaran Terbaru</div>
            @forelse($recentOut as $r)
                <div class="list-row d-flex justify-content-between gap-3">
                    <span class="small">{{ $r->keperluan }}</span>
                    <strong class="money-red text-nowrap">Rp {{ number_format($r->nominal, 0, ',', '.') }}</strong>
                </div>
            @empty
                <div class="small-muted py-4">Belum ada pengeluaran.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('cashChart'), {
    type: 'line',
    data: {
        labels: @json($months),
        datasets: [
            {label: 'Pemasukan', data: @json($inSeries), tension: .35},
            {label: 'Pengeluaran', data: @json($outSeries), tension: .35}
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {legend: {position: 'top'}},
        scales: {y: {ticks: {callback: value => 'Rp ' + Number(value).toLocaleString('id-ID')}}}
    }
});
</script>
@endpush
