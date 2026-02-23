<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin utama
        User::updateOrCreate(
            ['email' => 'admin@batitune.com'],
            [
                'name'              => 'Admin Utama',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'), // ganti ke yang kuat
            ]
        );

        // Misal: tambah beberapa user random pakai factory (email-nya otomatis unik)
        User::factory()->count(5)->create();
    }
}
