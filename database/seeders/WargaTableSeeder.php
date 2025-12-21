<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga;
use Carbon\Carbon;

class WargaTableSeeder extends Seeder
{
    private $firstNames = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fajar', 'Gita', 'Hadi', 'Indra', 'Joko',
                          'Kartika', 'Lina', 'Maya', 'Nina', 'Oki', 'Putri', 'Rudi', 'Sari', 'Tono', 'Umi'];

    private $lastNames = ['Santoso', 'Wijaya', 'Kusuma', 'Putra', 'Sari', 'Hartono', 'Wati', 'Pratama', 'Setiawan', 'Siregar',
                         'Sinaga', 'Simanjuntak', 'Sihombing', 'Nasution', 'Situmorang', 'Lubis', 'Hasibuan', 'Butar-butar', 'Manalu', 'Panjaitan'];

    private $places = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 'Yogyakarta', 'Malang', 'Bogor', 'Depok', 'Tangerang'];

    private $jobs = ['PNS', 'Wiraswasta', 'Petani', 'Guru', 'Dokter', 'Perawat', 'Karyawan Swasta', 'Buruh', 'Pedagang', 'Pensiunan'];

    private $educations = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'];

    private $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

    public function run(): void
    {
        $wargaData = [];

        // Generate 200 warga data
        for ($i = 1; $i <= 200; $i++) {
            $gender = $i % 2 == 0 ? 'L' : 'P';
            $firstName = $this->firstNames[array_rand($this->firstNames)];
            $lastName = $this->lastNames[array_rand($this->lastNames)];

            $birthDate = Carbon::now()->subYears(rand(18, 80))->subDays(rand(0, 365));

            $wargaData[] = [
                'nik' => '3273' . rand(100000000000, 999999999999),
                'nama' => $firstName . ' ' . $lastName . ($i % 10 == 0 ? ' Jr.' : ''),
                'jenis_kelamin' => $gender,
                'tempat_lahir' => $this->places[array_rand($this->places)],
                'tanggal_lahir' => $birthDate,
                'agama' => $this->religions[array_rand($this->religions)],
                'pendidikan' => $this->educations[array_rand($this->educations)],
                'pekerjaan' => $this->jobs[array_rand($this->jobs)],
                'status_perkawinan' => $this->getMaritalStatus($birthDate),
                'status_dalam_keluarga' => $this->getFamilyStatus($gender, $i),
                'created_at' => Carbon::now()->subMonths(rand(1, 24)),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert in batches
        foreach (array_chunk($wargaData, 50) as $chunk) {
            Warga::insert($chunk);
        }

        $this->command->info('✅ Warga table seeded successfully! 200 records created.');
    }

    private function getMaritalStatus(Carbon $birthDate): string
    {
        $age = $birthDate->age;

        if ($age < 20) return 'Belum Kawin';
        if ($age < 25) return rand(0, 1) ? 'Belum Kawin' : 'Kawin';
        if ($age < 50) return 'Kawin';
        if ($age < 60) return rand(0, 1) ? 'Kawin' : 'Cerai Hidup';
        return rand(0, 1) ? 'Cerai Hidup' : 'Cerai Mati';
    }

    private function getFamilyStatus(string $gender, int $index): string
    {
        $statuses = ['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Famili Lain'];

        if ($index <= 50) {
            return $gender == 'L' ? 'Kepala Keluarga' : 'Istri';
        }

        if ($index <= 100) {
            return 'Anak';
        }

        if ($index <= 150) {
            return $gender == 'L' ? 'Suami' : 'Istri';
        }

        return $statuses[array_rand($statuses)];
    }
}
