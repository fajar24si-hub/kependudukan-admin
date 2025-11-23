<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateWargaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $this->command->info('Membuat 150 data warga dummy...');

        // Data 1-100: Calon Kepala Keluarga (Laki-laki, sudah menikah)
        foreach (range(1, 100) as $index) {
            DB::table('warga')->insert([
                'nik' => $faker->unique()->numerify('32##############'),
                'nama' => $faker->name('male'),
                'jenis_kelamin' => 'L',
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '1980-12-31'), // Umur 25-60 tahun
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pendidikan' => $faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2']),
                'pekerjaan' => $faker->randomElement([
                    'Pegawai Negeri', 'Pegawai Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Karyawan'
                ]),
                'status_perkawinan' => 'Kawin',
                'status_dalam_keluarga' => 'Kepala Keluarga',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($index % 20 == 0) {
                $this->command->info("Created {$index} calon kepala keluarga...");
            }
        }

        // Data 101-150: Anggota Keluarga (Istri & Anak)
        foreach (range(101, 150) as $index) {
            $jenisKelamin = $faker->randomElement(['L', 'P']);
            $statusKeluarga = $faker->randomElement(['Istri', 'Anak', 'Anak', 'Anak']); // Lebih banyak anak

            DB::table('warga')->insert([
                'nik' => $faker->unique()->numerify('32##############'),
                'nama' => $statusKeluarga == 'Istri' ? $faker->name('female') : $faker->name($jenisKelamin == 'L' ? 'male' : 'female'),
                'jenis_kelamin' => $jenisKelamin,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $statusKeluarga == 'Istri'
                    ? $faker->date('Y-m-d', '1985-12-31')
                    : $faker->date('Y-m-d', '2010-12-31'), // Anak lebih muda
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pendidikan' => $statusKeluarga == 'Istri'
                    ? $faker->randomElement(['SMA', 'D3', 'S1'])
                    : $faker->randomElement(['SD', 'SMP', 'SMA', 'Belum Sekolah']),
                'pekerjaan' => $statusKeluarga == 'Istri'
                    ? $faker->randomElement(['Ibu Rumah Tangga', 'Pegawai Swasta', 'Wiraswasta'])
                    : ($faker->boolean(30) ? 'Pelajar/Mahasiswa' : 'Tidak Bekerja'),
                'status_perkawinan' => $statusKeluarga == 'Istri' ? 'Kawin' : 'Belum Kawin',
                'status_dalam_keluarga' => $statusKeluarga,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($index % 10 == 0) {
                $this->command->info("Created {$index} warga...");
            }
        }

        $this->command->info('150 data warga dummy berhasil dibuat! (100 calon KK + 50 anggota keluarga)');
    }
}
