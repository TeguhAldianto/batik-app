<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('rajaongkir.base_url');
        $this->apiKey  = (string) config('rajaongkir.api_key');
    }

    protected function client()
    {
        return Http::withHeaders([
            'key' => $this->apiKey,
        ])->baseUrl($this->baseUrl);
    }

    // Ambil Daftar Provinsi
    public function getProvinces()
    {
        $response = $this->client()->get('/province');
        // RajaOngkir membungkus data dalam key ['rajaongkir']['results']
        return $response->json()['rajaongkir']['results'] ?? [];
    }

    // Ambil Daftar Kota
    public function getCities($provinceId)
    {
        $response = $this->client()->get('/city', [
            'province' => $provinceId
        ]);
        return $response->json()['rajaongkir']['results'] ?? [];
    }

    // Hitung Ongkir
    public function calculateCost($destination, $weight, $courier)
    {
        $origin = config('rajaongkir.origin_city_id');

        $response = $this->client()->asForm()->post('/cost', [
            'origin'      => $origin,
            'destination' => $destination,
            'weight'      => $weight,
            'courier'     => $courier,
        ]);

        return $response->json()['rajaongkir']['results'][0]['costs'] ?? [];
    }
}
