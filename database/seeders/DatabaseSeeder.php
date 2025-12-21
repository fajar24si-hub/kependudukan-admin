<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            WargaTableSeeder::class,
            KeluargaKKTableSeeder::class,
            AnggotaKeluargaTableSeeder::class,
            PeristiwaKelahiranTableSeeder::class,
            PeristiwaKematianTableSeeder::class,
            PeristiwaPindahTableSeeder::class,
        ]);
    }
}
