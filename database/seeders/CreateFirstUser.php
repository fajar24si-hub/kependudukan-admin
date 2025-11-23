<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah user sudah ada
        $existingUser = User::where('email', 'gatot@pcr.ac.id')->first();

        if (!$existingUser) {
            User::create([
                'name' => 'Admin',
                'email' => 'gatot@pcr.ac.id',
                'password' => Hash::make('gatotkaca'),
                'email_verified_at' => now(),
            ]);
            $this->command->info('User pertama berhasil dibuat!');
        } else {
            $this->command->info('User sudah ada, tidak dibuat lagi.');
        }
    }
}
