<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = ['id_warga', 'kode_transaksi', 'tanggal_bayar', 'nominal_dibayar', 'metode', 'bukti_transfer', 'status_verifikasi', 'catatan'];
    protected $casts = ['tanggal_bayar' => 'datetime', 'nominal_dibayar' => 'decimal:2'];
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'id_warga', 'id_warga');
    }
    public function pemasukan(): HasOne
    {
        return $this->hasOne(PemasukanKas::class, 'id_pembayaran', 'id_pembayaran');
    }
}
