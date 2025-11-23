<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateKeluargaKkDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $this->command->info('Membuat 100 data keluarga KK...');

        // Ambil 100 warga yang memenuhi syarat sebagai kepala keluarga
        $kepalaKeluarga = DB::table('warga')
            ->where('jenis_kelamin', 'L')
            ->where('status_perkawinan', 'Kawin')
            ->where('status_dalam_keluarga', 'Kepala Keluarga')
            ->limit(100)
            ->get();

        if ($kepalaKeluarga->count() < 100) {
            $this->command->error('Tidak cukup calon kepala keluarga!');
            $this->command->info('Dibutuhkan 100 calon KK, hanya tersedia: ' . $kepalaKeluarga->count());
            return;
        }

        foreach ($kepalaKeluarga as $index => $warga) {
            DB::table('keluarga_kk')->insert([
                'kk_nomor' => $faker->unique()->numerify('32############'),
                'kepala_keluarga_warga_id' => $warga->warga_id,
                'alamat' => 'Jl. ' . $faker->streetName . ' No. ' . $faker->buildingNumber,
                'rt' => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 5), 3, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (($index + 1) % 20 == 0) {
                $this->command->info("Created " . ($index + 1) . " KK...");
            }
        }

        $this->command->info('100 data keluarga KK berhasil dibuat!');
        $this->command->info('Total warga: 150, Total KK: 100');
    }
}
