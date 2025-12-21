<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeristiwaKelahiran;
use App\Models\Warga;
use Carbon\Carbon;

class PeristiwaKelahiranTableSeeder extends Seeder
{
    public function run(): void
    {
        $kelahiranData = [];

        // Ambil 30 warga yang masih muda (usia < 30) untuk jadi orang tua
        $calonOrangTua = Warga::whereHas('anggotaKeluarga', function($query) {
                $query->whereIn('hubungan', ['Kepala Keluarga', 'Istri']);
            })
            ->whereDoesntHave('peristiwaKelahiran')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 40')
            ->take(30)
            ->get();

        foreach ($calonOrangTua as $index => $orangTua) {
            // Cari pasangan berdasarkan keluarga yang sama
            $keluarga = $orangTua->keluargaSebagaiAnggota();

            if ($keluarga) {
                $pasangan = $keluarga->anggotaKeluarga()
                    ->where('warga_id', '!=', $orangTua->warga_id)
                    ->whereIn('hubungan', ['Kepala Keluarga', 'Istri'])
                    ->first();

                if ($pasangan) {
                    // Cari warga yang belum punya data kelahiran dan masih muda untuk jadi anak
                    $anak = Warga::whereDoesntHave('peristiwaKelahiran')
                        ->whereDoesntHave('peristiwaKematian')
                        ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 18')
                        ->first();

                    if ($anak) {
                        $kelahiranData[] = [
                            'warga_id' => $anak->warga_id,
                            'tgl_lahir' => $anak->tanggal_lahir,
                            'tempat_lahir' => $anak->tempat_lahir,
                            'ayah_warga_id' => $orangTua->jenis_kelamin == 'L' ? $orangTua->warga_id : $pasangan->warga_id,
                            'ibu_warga_id' => $orangTua->jenis_kelamin == 'P' ? $orangTua->warga_id : $pasangan->warga_id,
                            'no_akta' => 'AKTA-' . date('Y') . '-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
        }

        if (!empty($kelahiranData)) {
            PeristiwaKelahiran::insert($kelahiranData);
            $this->command->info('✅ PeristiwaKelahiran table seeded successfully! ' . count($kelahiranData) . ' records created.');
        } else {
            $this->command->warn('⚠️ No PeristiwaKelahiran records created. Check if there are suitable candidates.');
        }
    }
}
