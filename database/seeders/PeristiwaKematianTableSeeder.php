<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeristiwaKematian;
use App\Models\Warga;
use Carbon\Carbon;

class PeristiwaKematianTableSeeder extends Seeder
{
    private $causes = ['Sakit Jantung', 'Stroke', 'Kecelakaan', 'Penyakit Paru', 'Diabetes', 'Usia Tua', 'Penyakit Ginjal', 'Kanker'];

    private $locations = ['Rumah', 'Rumah Sakit', 'Puskesmas', 'Di Jalan', 'Tempat Kerja', 'Rumah Keluarga'];

    public function run(): void
    {
        $kematianData = [];

        // Ambil 15 warga yang tua (usia > 60) untuk data kematian
        $wargaMeninggal = Warga::whereDoesntHave('peristiwaKematian')
            ->whereDoesntHave('peristiwaPindah')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 60')
            ->take(15)
            ->get();

        foreach ($wargaMeninggal as $index => $warga) {
            $tglMeninggal = Carbon::now()->subMonths(rand(1, 24));

            $kematianData[] = [
                'warga_id' => $warga->warga_id,
                'tgl_meninggal' => $tglMeninggal,
                'sebab' => $this->causes[array_rand($this->causes)],
                'lokasi' => $this->locations[array_rand($this->locations)],
                'no_surat' => 'SKM-' . $tglMeninggal->format('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'created_at' => $tglMeninggal->addDays(rand(1, 7)),
                'updated_at' => Carbon::now(),
            ];
        }

        if (!empty($kematianData)) {
            PeristiwaKematian::insert($kematianData);
            $this->command->info('✅ PeristiwaKematian table seeded successfully! ' . count($kematianData) . ' records created.');
        } else {
            $this->command->warn('⚠️ No PeristiwaKematian records created. Check if there are suitable candidates.');
        }
    }
}
