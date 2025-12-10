<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeristiwaKematian extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_kematian';
    protected $primaryKey = 'kematian_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'warga_id',
        'tgl_meninggal',
        'sebab',
        'lokasi',
        'no_surat'
    ];

    /**
     * Relasi ke Warga
     */
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    /**
     * Relasi ke Media
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'ref_id', 'kematian_id')
                    ->where('ref_table', 'peristiwa_kematian');
    }
}
