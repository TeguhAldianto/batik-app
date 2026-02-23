<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRajaOngkirDummy();
        $this->seedProductsDummy();
        $this->seedOrdersDummy();
    }

    /**
     * Seed data dummy provinsi & kota (RajaOngkir) untuk
     * wilayah Lasem, Kab. Rembang, Jawa Tengah.
     */
    protected function seedRajaOngkirDummy(): void
    {
        // ID ini kamu boleh sesuaikan nanti dengan ID asli dari API
        $provinceId = 33;  // Jawa Tengah
        $rembangId  = 419; // Kab. Rembang (contoh ID umum RajaOngkir)

        // PROVINSI
        DB::table('provinces')->updateOrInsert(
            ['id' => $provinceId],
            [
                'name'       => 'Jawa Tengah',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // BEBERAPA KOTA DI JAWA TENGAH (dummy)
        $cities = [
            [
                'id'          => $rembangId,
                'province_id' => $provinceId,
                'name'        => 'Kabupaten Rembang',
                'type'        => 'Kabupaten',
                'postal_code' => '59271',
            ],
            [
                'id'          => 501,
                'province_id' => $provinceId,
                'name'        => 'Kota Semarang',
                'type'        => 'Kota',
                'postal_code' => '50135',
            ],
            [
                'id'          => 502,
                'province_id' => $provinceId,
                'name'        => 'Kabupaten Kudus',
                'type'        => 'Kabupaten',
                'postal_code' => '59311',
            ],
        ];

        foreach ($cities as $city) {
            DB::table('cities')->updateOrInsert(
                ['id' => $city['id']],
                [
                    'province_id' => $city['province_id'],
                    'name'        => $city['name'],
                    'type'        => $city['type'],
                    'postal_code' => $city['postal_code'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }

    /**
     * Seed produk dummy (batik Lasem).
     */
    protected function seedProductsDummy(): void
    {
        // Kalau belum ada produk sama sekali, buat 6 random pakai factory
        if (Product::count() === 0) {
            Product::factory()->count(6)->create();
        }

        // Tambah beberapa produk "spesial" yang statis
        $products = [
            [
                'name'        => 'Kain Batik Tulis Lasem Sekar Jagad',
                'slug'        => 'kain-batik-tulis-lasem-sekar-jagad',
                'category'    => 'kain_batik',
                'size'        => '200 x 115 cm',
                'price'       => 950_000,
                'stock'       => 1,
                'description' => 'Kain batik tulis Lasem motif Sekar Jagad dengan pewarnaan merah Lasem yang khas.',
                'image'       => null,
                'is_active'   => true,
                'weight'      => 300,
            ],
            [
                'name'        => 'Kemeja Batik Lasem Motif Naga',
                'slug'        => 'kemeja-batik-lasem-motif-naga',
                'category'    => 'kemeja_pria',
                'size'        => 'L',
                'price'       => 650_000,
                'stock'       => 3,
                'description' => 'Kemeja batik tulis Lasem motif Naga dengan nuansa merah marun elegan.',
                'image'       => null,
                'is_active'   => true,
                'weight'      => 400,
            ],
            [
                'name'        => 'Dress Batik Lasem Bunga Melati',
                'slug'        => 'dress-batik-lasem-bunga-melati',
                'category'    => 'dress_wanita',
                'size'        => 'All Size',
                'price'       => 720_000,
                'stock'       => 2,
                'description' => 'Dress batik Lasem dengan motif bunga melati, cocok untuk acara semi formal.',
                'image'       => null,
                'is_active'   => true,
                'weight'      => 500,
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }

    /**
     * Seed order + order_items dummy.
     */
    protected function seedOrdersDummy(): void
    {
        // Ambil 1 user buyer (bukan admin). Kalau tidak ada, buat satu.
        $buyer = User::where('email', '!=', 'admin@batitune.com')->first();

        if (! $buyer) {
            $buyer = User::factory()->create([
                'name'  => 'Pelanggan Lasem',
                'email' => 'customer@batitune.com',
            ]);
        }

        // Ambil beberapa produk untuk dimasukkan ke order
        $products = Product::take(3)->get();

        if ($products->isEmpty()) {
            return; // tidak ada produk, tidak bisa buat order
        }

        $shippingAddress = "Dusun Karangturi, Lasem, Kabupaten Rembang, Jawa Tengah, 59271";

        // ORDER 1: status paid
        $order1 = Order::updateOrCreate(
            ['number' => 'BTK-2025001'],
            [
                'user_id'          => $buyer->id,
                'total_price'      => 0, // akan dihitung di bawah
                'status'           => 'paid',
                'shipping_address' => $shippingAddress,
                'shipping_cost'    => 25_000,
                'courier'          => 'jne',
                'tracking_number'  => 'JNE1234567890ID',
                'snap_token'       => null,
            ]
        );

        // ORDER 2: status pending
        $order2 = Order::updateOrCreate(
            ['number' => 'BTK-2025002'],
            [
                'user_id'          => $buyer->id,
                'total_price'      => 0,
                'status'           => 'pending',
                'shipping_address' => $shippingAddress,
                'shipping_cost'    => 25_000,
                'courier'          => 'jne',
                'tracking_number'  => null,
                'snap_token'       => 'dummy-snap-token-123',
            ]
        );

        // Hapus item lama kalau ada (supaya idempoten)
        OrderItem::whereIn('order_id', [$order1->id, $order2->id])->delete();

        // Isi order_items + hitung total
        $this->attachItemsAndRecalcTotal($order1, $products, 1);
        $this->attachItemsAndRecalcTotal($order2, $products, 2);
    }

    /**
     * Tambahkan order_items ke satu order, lalu hitung ulang total_price.
     */
    protected function attachItemsAndRecalcTotal(Order $order, $products, int $qtyMultiplier = 1): void
    {
        $total = $order->shipping_cost ?? 0;

        foreach ($products as $index => $product) {
            $qty = $qtyMultiplier; // order kedua bisa punya qty berbeda

            $unitPrice = $product->price;
            $subtotal  = $qty * $unitPrice;
            $total    += $subtotal;

            OrderItem::updateOrCreate(
                [
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                ],
                [
                    'quantity'   => $qty,
                    'unit_price' => $unitPrice,
                ]
            );
        }

        $order->update([
            'total_price' => $total,
        ]);
    }
}
