<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CreateFirstUser::class,        // User admin pertama
            CreateUsersDummy::class,       // 100 users dummy
            CreateWargaDummy::class,       // 150 warga dummy
            CreateKeluargaKkDummy::class,  // 100 keluarga KK
        ]);
    }
}
