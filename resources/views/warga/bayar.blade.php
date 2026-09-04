@extends('layouts.app')

@section('title', 'Bayar Tagihan Kas')

@section('content')
<div class="mb-3">
    <div class="page-title">Bayar Tagihan Kas</div>
    <div class="small-muted">Masukkan nominal bebas. Sistem akan mengalokasikan pembayaran secara otomatis berdasarkan tarif Rp 15.000 per bulan.</div>
</div>

<form method="POST" action="{{ route('warga.bayar.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-12 col-lg-4">
            <div class="card-satria p-3 h-100">
                <div class="section-title mb-3">Status Pembayaran Saat Ini</div>
                <div class="mb-3">
                    <span class="badge rounded-pill {{ $status['status'] === 'Lunas' ? 'badge-soft-success' : 'badge-soft-danger' }} fs-6">{{ $status['status'] }}</span>
                </div>
                <div class="small-muted">Tarif bulanan</div>
                <div class="summary-big">Rp {{ number_format($status['tarif_bulanan'], 0, ',', '.') }}</div>
                <div class="small-muted mt-3">Total pembayaran disetujui</div>
                <div class="fw-bold">Rp {{ number_format($status['total_pembayaran'], 0, ',', '.') }}</div>
                <div class="small-muted mt-3">Kekurangan bulan berjalan</div>
                <div class="fw-bold money-red">Rp {{ number_format($status['kekurangan'], 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card-satria p-3 h-100">
                <div class="section-title mb-3">Nominal & Metode</div>
                <label class="form-label">Nominal Dibayar</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp</span>
                    <input id="nominal_dibayar" name="nominal_dibayar" type="number" min="1" step="1" class="form-control" required data-total="{{ $status['total_pembayaran'] }}" data-bulan-wajib="{{ $status['bulan_wajib'] }}" data-tarif="{{ $status['tarif_bulanan'] }}">
                </div>

                <label class="form-label">Metode Pembayaran</label>
                <select name="metode" id="metode" class="form-select mb-3" required>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="Tunai">Tunai (Bayar Langsung)</option>
                </select>

                <label class="form-label">Bukti Transfer</label>
                <input type="file" name="bukti_transfer" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                <div class="small-muted mt-2">Unggah bukti jika menggunakan transfer bank.</div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card-satria p-3 h-100">
                <div class="section-title mb-3">Ringkasan Pembayaran</div>
                <div id="paymentPreview" class="small-muted">Masukkan nominal untuk melihat hasil perhitungan.</div>
                <hr>
                <div class="notice mb-3">Status pembayaran diubah setelah pembayaran diverifikasi oleh admin.</div>
                <button class="btn btn-satria w-100">Kirim Pembayaran</button>
            </div>
        </div>
    </div>
</form>
@endsection
