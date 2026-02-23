<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class RajaOngkirSeeder extends Seeder
{
    public function run(): void
    {
        $apiKey = env('RAJAONGKIR_API_KEY');

        // 1. Cek API Key
        if (empty($apiKey)) {
            $this->command->error('RAJAONGKIR_API_KEY belum di-set di file .env');
            return;
        }

        // 2. Kosongkan data lama (optional, tapi biasanya diinginkan)
        $this->command->info('Menghapus data lama provinces dan cities...');
        DB::table('cities')->truncate();
        DB::table('provinces')->truncate();

        // 3. Ambil data provinsi dari RajaOngkir V2
        $this->command->info('Mengambil data provinsi dari RajaOngkir V2...');

        $provinceResponse = Http::withHeaders([
            'key' => $apiKey, // sesuai dokumentasi V2
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        if (! $provinceResponse->successful()) {
            $this->command->error(
                'Gagal ambil provinsi. HTTP Status: ' .
                $provinceResponse->status() .
                ' | Response: ' . $provinceResponse->body()
            );
            return;
        }

        $provinceJson = $provinceResponse->json();

        if (! isset($provinceJson['data']) || ! is_array($provinceJson['data'])) {
            $this->command->error('Format respons provinsi tidak sesuai. Payload: ' . json_encode($provinceJson));
            return;
        }

        // 4. Insert data provinsi
        foreach ($provinceJson['data'] as $province) {
            DB::table('provinces')->insertOrIgnore([
                'id'         => $province['id'],   // dari API V2: id
                'name'       => $province['name'], // dari API V2: name
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Berhasil menyimpan data provinsi. Mengambil data kota/kabupaten...');

        // 5. Untuk setiap provinsi, ambil data kota/kabupaten (di V2: endpoint city/district)
        foreach ($provinceJson['data'] as $province) {
            $provinceId = $province['id'];

            $this->command->info("→ Mengambil kota/kabupaten untuk provinsi ID {$provinceId} ({$province['name']}) ...");

            $cityResponse = Http::withHeaders([
                'key' => $apiKey,
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

            if (! $cityResponse->successful()) {
                $this->command->warn(
                    "Gagal ambil kota untuk provinsi ID {$provinceId}. " .
                    'HTTP Status: ' . $cityResponse->status() .
                    ' | Response: ' . $cityResponse->body()
                );
                continue;
            }

            $cityJson = $cityResponse->json();

            if (! isset($cityJson['data']) || ! is_array($cityJson['data'])) {
                $this->command->warn(
                    "Format respons kota tidak sesuai untuk provinsi ID {$provinceId}. Payload: " .
                    json_encode($cityJson)
                );
                continue;
            }

            foreach ($cityJson['data'] as $city) {
                DB::table('cities')->insertOrIgnore([
                    'id'          => $city['id'],              // V2: id
                    'province_id' => $provinceId,              // relasi ke provinces.id
                    'type'        => 'KAB/KOTA',               // V2 tidak kirim 'type', jadi isi default
                    'name'        => $city['name'],            // V2: name
                    'postal_code' => $city['zip_code'] ?? '',  // V2: zip_code
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        $this->command->info('Selesai! Data wilayah berhasil diisi dari RajaOngkir V2.');
    }
}
