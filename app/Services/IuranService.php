<?php

namespace App\Services;

use App\Models\Warga;
use Illuminate\Support\Carbon;

class IuranService
{
    public const TARIF_BULANAN = 15000;

    public function totalPembayaranDisetujui(Warga $warga, ?Carbon $asOf = null): float
    {
        $asOf = $asOf ?: now();

        return (float) $warga->pembayarans()
            ->where('status_verifikasi', 'Disetujui')
            ->where('tanggal_bayar', '<=', $asOf)
            ->sum('nominal_dibayar');
    }

    public function bulanWajibSampai(Warga $warga, ?Carbon $asOf = null): int
    {
        $asOf = ($asOf ?: now())->copy()->startOfMonth();
        $mulai = Carbon::parse($warga->tanggal_bergabung)->startOfMonth();

        if ($mulai->greaterThan($asOf)) {
            return 0;
        }

        return $mulai->diffInMonths($asOf) + 1;
    }

    public function hitungStatus(Warga $warga, ?float $totalPembayaran = null, ?Carbon $asOf = null): array
    {
        $asOf = ($asOf ?: now())->copy();
        $totalPembayaran = $totalPembayaran ?? $this->totalPembayaranDisetujui($warga, $asOf);
        $bulanWajib = $this->bulanWajibSampai($warga, $asOf);
        $totalWajibSampaiSekarang = $bulanWajib * self::TARIF_BULANAN;
        $totalBulanTerbayar = (int) floor($totalPembayaran / self::TARIF_BULANAN);
        $sisaKredit = round($totalPembayaran - ($totalBulanTerbayar * self::TARIF_BULANAN), 2);
        $kekuranganSaatIni = max(0, round($totalWajibSampaiSekarang - $totalPembayaran, 2));
        $status = $kekuranganSaatIni <= 0 ? 'Lunas' : 'Menunggak';

        return [
            'tarif_bulanan' => self::TARIF_BULANAN,
            'total_pembayaran' => round($totalPembayaran, 2),
            'bulan_wajib' => $bulanWajib,
            'bulan_lunas' => min($totalBulanTerbayar, $bulanWajib),
            'sisa_kredit' => $sisaKredit,
            'kekurangan' => $kekuranganSaatIni,
            'status' => $status,
        ];
    }

    public function previewPembayaran(Warga $warga, float $nominal, ?Carbon $asOf = null): array
    {
        $asOf = $asOf ?: now();
        $totalSekarang = $this->totalPembayaranDisetujui($warga, $asOf);

        return $this->hitungStatus($warga, $totalSekarang + max(0, $nominal), $asOf);
    }
}
