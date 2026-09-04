<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemasukanKas extends Model
{
    protected $table = 'pemasukan_kas';
    protected $primaryKey = 'id_pemasukan';
    protected $fillable = ['id_pembayaran', 'tanggal', 'sumber_pemasukan', 'keterangan', 'nominal'];
    protected $casts = ['tanggal' => 'date', 'nominal' => 'decimal:2'];
    public function pembayaran(): BelongsTo
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id_pembayaran');
    }
}
