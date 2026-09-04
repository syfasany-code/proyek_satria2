<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengeluaran extends Model
{
    protected $table = 'pengeluarans';
    protected $primaryKey = 'id_pengeluaran';
    protected $fillable = ['id_admin', 'tanggal', 'keperluan', 'keterangan', 'nominal', 'bukti_pengeluaran'];
    protected $casts = ['tanggal' => 'date', 'nominal' => 'decimal:2'];
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
