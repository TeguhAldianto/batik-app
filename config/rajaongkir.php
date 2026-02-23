<?php

return [
    'api_key'        => env('RAJAONGKIR_API_KEY'),
    'base_url'       => env('RAJAONGKIR_BASE_URL', 'https://api.rajaongkir.com/starter'),
    'origin_city_id' => (int) env('ORIGIN_CITY_ID', 419),
];
