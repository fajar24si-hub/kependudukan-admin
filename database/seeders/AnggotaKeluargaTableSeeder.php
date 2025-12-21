<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKK;
use App\Models\Warga;
use Carbon\Carbon;

class AnggotaKeluargaTableSeeder extends Seeder
{
    public function run(): void
    {
        $anggotaData = [];

        // Ambil semua keluarga
        $keluargas = KeluargaKK::all();

        foreach ($keluargas as $keluarga) {
            // Tambahkan kepala keluarga sebagai anggota
            $anggotaData[] = [
                'kk_id' => $keluarga->kk_id,
                'warga_id' => $keluarga->kepala_keluarga_warga_id,
                'hubungan' => 'Kepala Keluarga',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Cari istri untuk kepala keluarga (warga perempuan dengan status Istri)
            $istri = Warga::where('jenis_kelamin', 'P')
                ->where('status_dalam_keluarga', 'Istri')
                ->whereDoesntHave('anggotaKeluarga')
                ->first();

            if ($istri) {
                $anggotaData[] = [
                    'kk_id' => $keluarga->kk_id,
                    'warga_id' => $istri->warga_id,
                    'hubungan' => 'Istri',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            // Tambahkan 2-5 anak per keluarga
            $jumlahAnak = rand(2, 5);
            $anakAnak = Warga::where('status_dalam_keluarga', 'Anak')
                ->whereDoesntHave('anggotaKeluarga')
                ->take($jumlahAnak)
                ->get();

            foreach ($anakAnak as $anak) {
                $anggotaData[] = [
                    'kk_id' => $keluarga->kk_id,
                    'warga_id' => $anak->warga_id,
                    'hubungan' => 'Anak',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // Insert dalam batch
        foreach (array_chunk($anggotaData, 100) as $chunk) {
            AnggotaKeluarga::insert($chunk);
        }

        $this->command->info('✅ AnggotaKeluarga table seeded successfully! ' . count($anggotaData) . ' records created.');
    }
}
