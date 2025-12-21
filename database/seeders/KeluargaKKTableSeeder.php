<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeluargaKK;
use App\Models\Warga;
use Carbon\Carbon;

class KeluargaKKTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil 50 warga pria yang akan jadi kepala keluarga
        $kepalaKeluargas = Warga::where('jenis_kelamin', 'L')
            ->where('status_dalam_keluarga', 'Kepala Keluarga')
            ->take(50)
            ->get();

        $keluargaData = [];

        foreach ($kepalaKeluargas as $index => $warga) {
            $keluargaData[] = [
                'kk_nomor' => '3273' . rand(100000000000, 999999999999),
                'kepala_keluarga_warga_id' => $warga->warga_id,
                'alamat' => 'Jl. Desa No. ' . ($index + 1),
                'rt' => str_pad(rand(1, 10), 3, '0', STR_PAD_LEFT),
                'rw' => str_pad(rand(1, 5), 3, '0', STR_PAD_LEFT),
                'created_at' => Carbon::now()->subMonths(rand(1, 24)),
                'updated_at' => Carbon::now(),
            ];
        }

        KeluargaKK::insert($keluargaData);

        $this->command->info('✅ KeluargaKK table seeded successfully! ' . count($keluargaData) . ' records created.');
    }
}
