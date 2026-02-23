<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class WebhookController extends Controller
{
    public function handler(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            // 2. Ambil Notifikasi dari Midtrans
            $notif = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid Notification'], 400);
        }

        // 3. Ambil data penting
        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // 4. Cari Order berdasarkan Invoice Number
        // Ingat: Di checkout controller kita kirim 'number' sebagai order_id ke Midtrans
        $order = Order::where('number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 5. Logika Update Status (Sesuai Dokumentasi Midtrans)
        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->update(['status' => 'pending']);
                } else {
                    $order->update(['status' => 'paid']);
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            // Ini status paling umum untuk transfer bank/gopay sukses
            $order->update(['status' => 'paid']);

        } elseif ($transactionStatus == 'pending') {
            $order->update(['status' => 'pending']);

        } elseif ($transactionStatus == 'deny') {
            $order->update(['status' => 'cancelled']);

        } elseif ($transactionStatus == 'expire') {
            $order->update(['status' => 'cancelled']);
            // Opsional: Balikin stok jika expired
             foreach($order->items as $item) {
                 $item->product->increment('stock', $item->quantity);
             }

        } elseif ($transactionStatus == 'cancel') {
            $order->update(['status' => 'cancelled']);
             // Opsional: Balikin stok jika cancel
             foreach($order->items as $item) {
                 $item->product->increment('stock', $item->quantity);
             }
        }

        return response()->json(['message' => 'Callback received successfully']);
    }
}
