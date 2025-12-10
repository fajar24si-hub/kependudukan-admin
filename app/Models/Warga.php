<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';
    protected $primaryKey = 'warga_id'; // INI PENTING!
    public $incrementing = true;
    public $timestamps = true;

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

    /**
     * Casting untuk tipe data
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Accessor untuk nama lengkap
     */
    public function getNamaLengkapAttribute()
    {
        return $this->nama;
    }

    /**
     * Accessor untuk jenis kelamin lengkap
     */
    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Accessor untuk usia
     */
    public function getUsiaAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }

        return now()->diffInYears($this->tanggal_lahir);
    }

    /**
     * Accessor untuk format tanggal lahir
     */
    public function getTanggalLahirFormattedAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d/m/Y') : '-';
    }

    /**
     * Scope untuk warga laki-laki
     */
    public function scopeLakiLaki($query)
    {
        return $query->where('jenis_kelamin', 'L');
    }

    /**
     * Scope untuk warga perempuan
     */
    public function scopePerempuan($query)
    {
        return $query->where('jenis_kelamin', 'P');
    }

    /**
     * Scope untuk mencari berdasarkan nama atau NIK
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', "%{$search}%")
            ->orWhere('nik', 'like', "%{$search}%");
    }

    /**
     * Relasi ke PeristiwaKematian
     * Satu warga hanya bisa memiliki satu data kematian
     */
    public function peristiwaKematian(): HasOne
    {
        return $this->hasOne(PeristiwaKematian::class, 'warga_id', 'warga_id');
    }
    /**
     * Cek apakah warga sudah meninggal
     */
    public function isMeninggal()
    {
        return $this->peristiwaKematian()->exists();
    }

    /**
     * Mendapatkan data kematian jika ada
     */
    public function getDataKematianAttribute()
    {
        return $this->peristiwaKematian;
    }

    /**
     * Relasi ke PeristiwaKelahiran (jika ada)
     * Untuk relasi jika warga adalah bayi yang lahir
     */
    public function peristiwaKelahiran(): HasOne
    {
        return $this->hasOne(PeristiwaKelahiran::class, 'warga_id', 'warga_id');
    }

    /**
     * Relasi ke PeristiwaPindah (jika ada)
     */
    public function peristiwaPindah(): HasMany
    {
        return $this->hasMany(PeristiwaPindah::class, 'warga_id', 'warga_id');
    }

    /**
     * Relasi ke KeluargaKK - sebagai kepala keluarga
     */
    public function keluargaKK(): HasOne
    {
        return $this->hasOne(KeluargaKK::class, 'kepala_keluarga_warga_id', 'warga_id');
    }

    /**
     * Relasi ke AnggotaKeluarga
     */
    public function anggotaKeluarga(): HasMany
    {
        return $this->hasMany(AnggotaKeluarga::class, 'warga_id', 'warga_id');
    }

    /**
     * Relasi ke Media untuk dokumen warga
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'ref_id', 'warga_id')
            ->where('ref_table', 'warga');
    }

    /**
     * Relasi ke User jika warga memiliki akun
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'warga_id', 'warga_id');
    }

    /**
     * Cek apakah warga adalah kepala keluarga
     */
    public function isKepalaKeluarga()
    {
        return $this->keluargaKK()->exists();
    }

    /**
     * Mendapatkan keluarga tempat warga menjadi anggota
     */
    public function keluargaSebagaiAnggota()
    {
        if ($this->isKepalaKeluarga()) {
            return $this->keluargaKK;
        }

        $anggota = $this->anggotaKeluarga()->first();
        return $anggota ? $anggota->keluarga : null;
    }

    /**
     * Mendapatkan semua anggota keluarga termasuk diri sendiri
     */
    public function semuaAnggotaKeluarga()
    {
        $keluarga = $this->keluargaSebagaiAnggota();

        if (!$keluarga) {
            return collect([$this]);
        }

        return $keluarga->anggotaKeluarga()->with('warga')->get()
            ->pluck('warga')
            ->push($keluarga->kepalaKeluarga);
    }

    /**
     * Statistik warga
     */
    public static function getStatistik()
    {
        return [
            'total' => self::count(),
            'laki_laki' => self::lakiLaki()->count(),
            'perempuan' => self::perempuan()->count(),
            'meninggal' => self::has('peristiwaKematian')->count(),
            'kepala_keluarga' => self::has('keluargaKK')->count(),
        ];
    }

    /**
     * Mendapatkan warga yang masih hidup (tidak ada data kematian)
     */
    public static function hidup()
    {
        return self::whereDoesntHave('peristiwaKematian');
    }

    /**
     * Mendapatkan warga yang sudah meninggal
     */
    public static function meninggal()
    {
        return self::has('peristiwaKematian');
    }

    /**
     * Format untuk dropdown select
     */
    public function getDropdownLabelAttribute()
    {
        return "{$this->nama} - {$this->nik}";
    }

    /**
     * Untuk API response
     */
    public function toApiResponse()
    {
        return [
            'warga_id' => $this->warga_id,
            'nik' => $this->nik,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'jenis_kelamin_lengkap' => $this->jenis_kelamin_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir_formatted,
            'usia' => $this->usia,
            'agama' => $this->agama,
            'pendidikan' => $this->pendidikan,
            'pekerjaan' => $this->pekerjaan,
            'status_perkawinan' => $this->status_perkawinan,
            'status_dalam_keluarga' => $this->status_dalam_keluarga,
            'is_meninggal' => $this->isMeninggal(),
            'is_kepala_keluarga' => $this->isKepalaKeluarga(),
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Untuk select2 atau dropdown search
     */
    public static function getForSelect2($search = null)
    {
        $query = self::select('warga_id', 'nama', 'nik')
            ->whereDoesntHave('peristiwaKematian') // Hanya warga hidup
            ->orderBy('nama');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        return $query->take(50)->get()->map(function ($warga) {
            return [
                'id' => $warga->warga_id,
                'text' => "{$warga->nama} - {$warga->nik}"
            ];
        });
    }
}
