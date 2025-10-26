<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Warga extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'warga_id';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_perkawinan',
        'status_dalam_keluarga'
    ];

    public function keluargaKK(): HasOne
    {
        return $this->hasOne(KeluargaKK::class, 'kepala_keluarga_warga_id');
    }

    public function anggotaKeluarga(): HasMany
    {
        return $this->hasMany(AnggotaKeluarga::class, 'warga_id');
    }
}
