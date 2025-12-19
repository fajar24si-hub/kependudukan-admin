<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeristiwaPindah extends Model
{
    use HasFactory;

    protected $table = 'peristiwa_pindah';
    protected $primaryKey = 'pindah_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'warga_id',
        'tgl_pindah',
        'alamat_tujuan',
        'kecamatan_tujuan',
        'kabupaten_tujuan',
        'provinsi_tujuan',
        'negara_tujuan',
        'alasan',
        'keterangan',
        'status',
        'no_surat'
    ];

    protected $casts = [
        'tgl_pindah' => 'date',
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
        return $this->hasMany(Media::class, 'ref_id', 'pindah_id')
                    ->where('ref_table', 'peristiwa_pindah');
    }

    /**
     * Accessor untuk status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'approved' => '<span class="badge badge-success">Disetujui</span>',
            'rejected' => '<span class="badge badge-danger">Ditolak</span>',
        ];

        return $labels[$this->status] ?? '<span class="badge badge-secondary">-</span>';
    }

    /**
     * Accessor untuk tanggal format
     */
    public function getTglPindahFormattedAttribute()
    {
        return $this->tgl_pindah->format('d/m/Y');
    }

    /**
     * Accessor untuk alamat lengkap tujuan
     */
    public function getAlamatLengkapTujuanAttribute()
    {
        $alamat = $this->alamat_tujuan;

        if ($this->kecamatan_tujuan) {
            $alamat .= ', ' . $this->kecamatan_tujuan;
        }

        if ($this->kabupaten_tujuan) {
            $alamat .= ', ' . $this->kabupaten_tujuan;
        }

        if ($this->provinsi_tujuan) {
            $alamat .= ', ' . $this->provinsi_tujuan;
        }

        if ($this->negara_tujuan && $this->negara_tujuan != 'Indonesia') {
            $alamat .= ', ' . $this->negara_tujuan;
        }

        return $alamat;
    }
}
