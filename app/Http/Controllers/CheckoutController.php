<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // 1. Menampilkan Halaman Checkout (PERBAIKAN UTAMA DI SINI)
    public function show(Product $product)
    {
        if ($product->stock < 1) {
            return back()->with('error', 'Maaf, stok habis.');
        }

        // PERBAIKAN: Panggil view 'front.checkout' (Halaman Induk yang punya Layout)
        // BUKAN 'front.checkout-form' (Potongan Form)
        return view('front.checkout', compact('product'));
    }

    // 2. Memproses Data & Panggil Midtrans (POST)
    public function process(Request $request, Product $product)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'shipping_cost'    => 'required|numeric|min:0',
            'courier'          => 'required|string',
            'courier_service'  => 'required|string',
            'receiver_name'    => 'required|string',
            'receiver_phone'   => 'required|string',
        ]);

        if ($product->stock < 1) {
            return redirect()->route('product.show', $product)->with('error', 'Maaf, stok habis.');
        }

        $user = Auth::user();

        try {
            $order = DB::transaction(function () use ($product, $user, $request) {

                $shippingCost = (int) $request->shipping_cost;
                $totalPrice = $product->price + $shippingCost;

                // Format Alamat Lengkap
                $fullAddress = "PENERIMA: " . $request->receiver_name . " (" . $request->receiver_phone . ")\n";
                $fullAddress .= "ALAMAT: " . $request->shipping_address . "\n";
                $fullAddress .= "KURIR: " . strtoupper($request->courier) . " - " . $request->courier_service;

                $order = Order::create([
                    'user_id' => $user->id,
                    'number' => 'BTK-' . mt_rand(1000, 9999) . time(),
                    'total_price' => $totalPrice,
                    'shipping_cost' => $shippingCost,
                    'status' => 'pending',
                    'shipping_address' => $fullAddress,
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'unit_price' => $product->price,
                ]);

                $product->decrement('stock');

                return $order;
            });

            // Midtrans Config
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order->number,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->receiver_name,
                    'email' => $user->email,
                    'phone' => $request->receiver_phone,
                ],
                'item_details' => [
                    [
                        'id' => $product->id,
                        'price' => (int) $product->price,
                        'quantity' => 1,
                        'name' => substr($product->name, 0, 50),
                    ],
                    [
                        'id' => 'ONGKIR',
                        'price' => (int) $order->shipping_cost,
                        'quantity' => 1,
                        'name' => 'Biaya Pengiriman (' . strtoupper($request->courier) . ')',
                    ]
                ]
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            // Tampilkan halaman pembayaran (popup)
            // Pastikan Anda punya view 'front.checkout-payment' atau sesuaikan view ini
            // Untuk sementara kita pakai view 'front.checkout' tapi logic popupnya harus dihandle
            // Atau redirect ke halaman khusus payment success/pending
            return view('front.checkout-payment', compact('order', 'product', 'snapToken'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 3. Halaman Sukses
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('front.success', compact('order'));
    }
}
