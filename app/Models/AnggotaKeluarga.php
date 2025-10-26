<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaKeluarga extends Model
{
    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'anggota_id';

    protected $fillable = [
        'kk_id',
        'warga_id',
        'hubungan'
    ];

    public function keluargaKK(): BelongsTo
    {
        return $this->belongsTo(KeluargaKK::class, 'kk_id', 'kk_id');
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }
}
