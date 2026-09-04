<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $table = 'wargas';

    protected $primaryKey = 'id_warga';

    public $incrementing = true;

    protected $fillable = [
        'nik',
        'nama_warga',
        'email',
        'no_hp',
        'alamat',
        'status_warga',
        'username',
        'password',
        'tanggal_bergabung',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    public function pembayarans(): HasMany
    {
        return $this->hasMany(
            Pembayaran::class,
            'id_warga',
            'id_warga'
        );
    }
}