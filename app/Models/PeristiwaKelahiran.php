<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeristiwaKelahiran extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_kelahiran';
    protected $primaryKey = 'kelahiran_id';
    public $timestamps = false;

    protected $fillable = [
        'warga_id',
        'tgl_lahir',
        'tempat_lahir',
        'ayah_warga_id',
        'ibu_warga_id',
        'no_akta',
    ];

    // Relasi ke tabel warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function ayah()
    {
        return $this->belongsTo(Warga::class, 'ayah_warga_id');
    }

    public function ibu()
    {
        return $this->belongsTo(Warga::class, 'ibu_warga_id');
    }
}
