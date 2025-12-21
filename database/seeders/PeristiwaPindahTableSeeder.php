<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeristiwaPindah;
use App\Models\Warga;
use Carbon\Carbon;

class PeristiwaPindahTableSeeder extends Seeder
{
    private $destinations = [
        'Jakarta' => ['Jakarta Pusat', 'DKI Jakarta'],
        'Bandung' => ['Bandung', 'Jawa Barat'],
        'Surabaya' => ['Surabaya', 'Jawa Timur'],
        'Medan' => ['Medan', 'Sumatera Utara'],
        'Bali' => ['Denpasar', 'Bali'],
        'Makassar' => ['Makassar', 'Sulawesi Selatan'],
        'Yogyakarta' => ['Yogyakarta', 'DI Yogyakarta'],
        'Semarang' => ['Semarang', 'Jawa Tengah'],
    ];

    private $reasons = ['Pekerjaan', 'Pendidikan', 'Keluarga', 'Kesehatan', 'Ekonomi', 'Menikah', 'Lainnya'];

    private $statuses = ['pending', 'approved', 'rejected'];

    public function run(): void
    {
        $pindahData = [];

        // Ambil 20 warga yang belum meninggal untuk data pindah
        $wargaPindah = Warga::whereDoesntHave('peristiwaKematian')
            ->whereDoesntHave('peristiwaPindah')
            ->take(20)
            ->get();

        foreach ($wargaPindah as $index => $warga) {
            $destination = array_rand($this->destinations);
            $tglPindah = Carbon::now()->subMonths(rand(1, 12));

            $pindahData[] = [
                'warga_id' => $warga->warga_id,
                'tgl_pindah' => $tglPindah,
                'alamat_tujuan' => 'Jl. ' . $destination . ' No. ' . rand(1, 100),
                'kecamatan_tujuan' => $this->destinations[$destination][0],
                'kabupaten_tujuan' => $this->destinations[$destination][0],
                'provinsi_tujuan' => $this->destinations[$destination][1],
                'negara_tujuan' => 'Indonesia',
                'alasan' => $this->reasons[array_rand($this->reasons)],
                'keterangan' => 'Pindah karena ' . $this->reasons[array_rand($this->reasons)],
                'status' => $this->statuses[array_rand($this->statuses)],
                'no_surat' => 'SPP-' . $tglPindah->format('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'created_at' => $tglPindah->subDays(rand(1, 30)),
                'updated_at' => Carbon::now(),
            ];
        }

        if (!empty($pindahData)) {
            PeristiwaPindah::insert($pindahData);
            $this->command->info('✅ PeristiwaPindah table seeded successfully! ' . count($pindahData) . ' records created.');
        } else {
            $this->command->warn('⚠️ No PeristiwaPindah records created. Check if there are suitable candidates.');
        }
    }
}
