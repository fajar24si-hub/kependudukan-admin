<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin (1 user)
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@desa.com',
            'password' => Hash::make('password123'),
            'role' => 'Super Admin',
            'foto_profil' => null,
            'email_verified_at' => Carbon::now(),
            //'last_login' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // User biasa (100 users)
        $users = [];
        for ($i = 1; $i <= 100; $i++) {
            $users[] = [
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('user123'),
                'role' => $i <= 20 ? 'admin' : ($i <= 40 ? 'operator' : 'warga'),
                'foto_profil' => null,
                'email_verified_at' => Carbon::now(),
                //'last_login' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => Carbon::now()->subMonths(rand(1, 12)),
                'updated_at' => Carbon::now(),
            ];
        }

        User::insert($users);

        $this->command->info('✅ Users table seeded successfully!');
        $this->command->info('Super Admin: admin@desa.com / password123');
        $this->command->info('Regular Users: user1@gmail.com / user123');
    }
}
