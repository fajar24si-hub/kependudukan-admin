<?php

namespace App\Models;  // ✅ Harus App\Models

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeristiwaKelahiran extends Model  // ✅ Perhatikan huruf besar/kecil
{
    use HasFactory;

    // ✅ Tentukan nama tabel
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

    // Relasi ke media
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'kelahiran_id')
            ->where('ref_table', 'peristiwa_kelahiran');
    }
}
