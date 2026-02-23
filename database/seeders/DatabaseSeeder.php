<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User test (boleh dipakai untuk login cepat di dev)
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'              => 'Test User',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'), // ganti kalau mau
            ]
        );

        // Jalankan seeder lain
        $this->call([
            UserSeeder::class,      // admin + random users (punyamu yang sekarang)
            DummyDataSeeder::class, // produk, order, rajaongkir dummy
            // RajaOngkirSeeder::class, // kalau nanti mau isi data asli dari API, bisa diaktifkan
        ]);
    }
}
