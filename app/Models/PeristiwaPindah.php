<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeristiwaPindah extends Model
{
    use HasFactory;

    protected $primaryKey = 'pindah_id';
    protected $fillable = [
        'warga_id',
        'tgl_pindah',
        'alamat_tujuan',
        'alasan',
        'no_surat'
    ];

    // Relasi ke media
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'pindah_id')
                    ->where('ref_table', 'peristiwa_pindah');
    }

    public function getMediaFilesAttribute()
    {
        return $this->media->map(function ($item) {
            return [
                'file_name' => $item->file_name,
                'caption' => $item->caption,
                'mime_type' => $item->mime_type,
                'sort_order' => $item->sort_order
            ];
        });
    }
}
