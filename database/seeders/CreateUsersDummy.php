<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CreateUsersDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Hapus users dummy sebelumnya (opsional, hati-hati di production)
        // User::where('email', 'like', '%@example.%')->delete();

        foreach (range(1, 100) as $index) {
            // Generate email unik
            $email = $faker->unique()->safeEmail;

            User::create([
                'name' => $faker->name,
                'email' => $email,
                'password' => Hash::make('password123'), // password default
                'email_verified_at' => $faker->randomElement([now(), null]), // beberapa user terverifikasi
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('100 users dummy berhasil dibuat!');
    }
}
