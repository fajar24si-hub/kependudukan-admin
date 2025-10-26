<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeluargaKK extends Model
{
    protected $table = 'keluarga_kk';
    protected $primaryKey = 'kk_id';

    protected $fillable = [
        'kk_nomor',
        'kepala_keluarga_warga_id',
        'alamat',
        'rt',
        'rw'
    ];

    public function kepalaKeluarga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_warga_id', 'warga_id');
    }

    public function anggotaKeluarga(): HasMany
    {
        return $this->hasMany(AnggotaKeluarga::class, 'kk_id', 'kk_id');
    }
}
