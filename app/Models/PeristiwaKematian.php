<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeristiwaKematian extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_kematian';
    protected $primaryKey = 'kematian_id';
    public $timestamps = false;

    protected $fillable = [
        'warga_id',
        'tgl_meninggal',
        'sebab',
        'lokasi',
        'no_surat',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
