<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';
    protected $primaryKey = 'warga_id';
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

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ... accessor dan scope yang sudah ada tetap ...

    /**
     * Relasi ke PeristiwaKematian
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

    // ... TAMBAHAN: Method untuk pindah ...

    /**
     * Relasi ke PeristiwaPindah
     * Satu warga bisa memiliki banyak data pindah (pindah berkali-kali)
     */
    public function peristiwaPindah(): HasMany
    {
        return $this->hasMany(PeristiwaPindah::class, 'warga_id', 'warga_id');
    }

    /**
     * Cek apakah warga sudah pernah pindah
     */
    public function isPernahPindah()
    {
        return $this->peristiwaPindah()->exists();
    }

    /**
     * Mendapatkan data pindah terbaru (jika ada)
     */
    public function getPindahTerbaruAttribute()
    {
        return $this->peristiwaPindah()->latest('tgl_pindah')->first();
    }

    /**
     * Mendapatkan status tempat tinggal warga
     */
    public function getStatusTempatTinggalAttribute()
    {
        if ($this->isMeninggal()) {
            return 'Meninggal';
        }

        if ($this->isPernahPindah()) {
            $pindahTerbaru = $this->pindah_terbaru;
            if ($pindahTerbaru && $pindahTerbaru->status == 'approved') {
                return 'Pindah (' . $pindahTerbaru->tgl_pindah->format('d/m/Y') . ')';
            }
            return 'Proses Pindah';
        }

        return 'Masih Tinggal';
    }

    /**
     * Scope untuk warga yang masih tinggal (belum pindah/meninggal)
     */
    public function scopeMasihTinggal($query)
    {
        return $query->whereDoesntHave('peristiwaKematian')
                     ->whereDoesntHave('peristiwaPindah', function($q) {
                         $q->where('status', 'approved');
                     });
    }

    /**
     * Scope untuk warga yang sudah pindah
     */
    public function scopeSudahPindah($query)
    {
        return $query->has('peristiwaPindah');
    }

    /**
     * Scope untuk warga yang bisa dipilih untuk pindah
     * (masih hidup dan belum pindah yang disetujui)
     */
    public function scopeAvailableForPindah($query)
    {
        return $query->whereDoesntHave('peristiwaKematian')
                     ->where(function($q) {
                         $q->whereDoesntHave('peristiwaPindah')
                           ->orWhereHas('peristiwaPindah', function($subQ) {
                               $subQ->where('status', '!=', 'approved');
                           });
                     });
    }

    /**
     * Mendapatkan semua data pindah warga
     */
    public function getRiwayatPindahAttribute()
    {
        return $this->peristiwaPindah()->orderBy('tgl_pindah', 'desc')->get();
    }

    // ... TAMBAHAN DIBAWAH INI ...

    /**
     * Relasi ke PeristiwaKelahiran
     */
    public function peristiwaKelahiran(): HasOne
    {
        return $this->hasOne(PeristiwaKelahiran::class, 'warga_id', 'warga_id');
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
     * Statistik warga - TAMBAH STATUS PINDAH
     */
    public static function getStatistik()
    {
        return [
            'total' => self::count(),
            'laki_laki' => self::lakiLaki()->count(),
            'perempuan' => self::perempuan()->count(),
            'meninggal' => self::has('peristiwaKematian')->count(),
            'pindah' => self::has('peristiwaPindah')->count(),
            'kepala_keluarga' => self::has('keluargaKK')->count(),
            'masih_tinggal' => self::masihTinggal()->count(),
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
     * Format untuk dropdown select - FILTER HANYA WARGA AVAILABLE
     */
    public function getDropdownLabelAttribute()
    {
        return "{$this->nama} - {$this->nik}";
    }

    /**
     * Untuk API response - TAMBAH STATUS PINDAH
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
            'is_pindah' => $this->isPernahPindah(),
            'status_tempat_tinggal' => $this->status_tempat_tinggal,
            'is_kepala_keluarga' => $this->isKepalaKeluarga(),
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Untuk select2 atau dropdown search - FILTER HANYA WARGA AVAILABLE
     */
    public static function getForSelect2($search = null)
    {
        $query = self::select('warga_id', 'nama', 'nik')
            ->whereDoesntHave('peristiwaKematian') // Hanya warga hidup
            ->whereDoesntHave('peristiwaPindah', function($q) {
                $q->where('status', 'approved'); // Belum pindah yang disetujui
            })
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
                'text' => "{$warga->nama} - {$warga->nik} - Status: {$warga->status_tempat_tinggal}"
            ];
        });
    }

    /**
     * Untuk select2 khusus pindah (warga yang masih tinggal)
     */
    public static function getForPindahSelect2($search = null)
    {
        $query = self::select('warga_id', 'nama', 'nik')
            ->whereDoesntHave('peristiwaKematian')
            ->whereDoesntHave('peristiwaPindah', function($q) {
                $q->where('status', 'approved');
            })
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
