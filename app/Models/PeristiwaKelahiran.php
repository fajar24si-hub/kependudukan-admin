<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeristiwaKelahiran extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_kelahiran';
    protected $primaryKey = 'kelahiran_id';

    protected $fillable = [
        'warga_id',
        'tgl_lahir',
        'tempat_lahir',
        'ayah_warga_id',
        'ibu_warga_id',
        'no_akta'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Warga (anak)
     */
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    public function ayah()
    {
        return $this->belongsTo(Warga::class, 'ayah_warga_id', 'warga_id');
    }

    public function ibu()
    {
        return $this->belongsTo(Warga::class, 'ibu_warga_id', 'warga_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'kelahiran_id')
            ->where('ref_table', 'peristiwa_kelahiran');
    }

    /**
     * Accessor untuk tanggal lahir format
     */
    public function getTglLahirFormattedAttribute()
    {
        return $this->tgl_lahir->format('d/m/Y');
    }

    /**
     * Accessor untuk tempat dan tanggal lahir lengkap
     */
    public function getTempatTglLahirAttribute()
    {
        return $this->tempat_lahir . ', ' . $this->tgl_lahir_formatted;
    }
}
