<?php

namespace App\Http\Controllers;

use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected RajaOngkirService $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function provinces()
    {
        try {
            $provinces = $this->rajaOngkir->getProvinces();

            // Format data agar mudah dibaca JS
            $data = collect($provinces)->map(function($item) {
                return [
                    'id' => $item['province_id'],
                    'name' => $item['province']
                ];
            })->values();

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()]);
        }
    }

    public function cities(Request $request)
    {
        try {
            $cities = $this->rajaOngkir->getCities($request->province_id);

            $data = collect($cities)->map(function($item) {
                return [
                    'id' => $item['city_id'],
                    'name' => $item['type'] . ' ' . $item['city_name'],
                    'postal_code' => $item['postal_code']
                ];
            })->values();

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['data' => []]);
        }
    }

    public function calculateCost(Request $request)
    {
        $request->validate([
            'destination_id' => 'required',
            'courier'        => 'required|string',
            'weight'         => 'required|integer',
        ]);

        try {
            $costs = $this->rajaOngkir->calculateCost(
                $request->destination_id,
                $request->weight,
                $request->courier
            );

            // Mapping format layanan agar bersih di Frontend
            $services = collect($costs)->map(function ($cost) {
                return [
                    'service_code' => $cost['service'],
                    'service_name' => $cost['service'], // REG, OKE, YES
                    'etd'          => $cost['cost'][0]['etd'] . ' HARI',
                    'cost'         => $cost['cost'][0]['value']
                ];
            });

            return response()->json(['data' => $services]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
