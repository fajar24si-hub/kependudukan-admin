<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerifyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalWarga = DB::table('warga')->count();
        $totalKK = DB::table('keluarga_kk')->count();
        $calonKK = DB::table('warga')
            ->where('jenis_kelamin', 'L')
            ->where('status_perkawinan', 'Kawin')
            ->where('status_dalam_keluarga', 'Kepala Keluarga')
            ->count();

        $this->command->info('=== VERIFIKASI DATA ===');
        $this->command->info("Total Warga: {$totalWarga}");
        $this->command->info("Total Keluarga KK: {$totalKK}");
        $this->command->info("Calon Kepala Keluarga: {$calonKK}");
        $this->command->info("Rata-rata anggota per KK: " . round(($totalWarga - $calonKK) / $totalKK, 2));
    }
}
