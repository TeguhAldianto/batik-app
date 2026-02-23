<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke User
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Info Order
            $table->string('number')->unique(); // No Resi Unik, misal: BTK-2025001
            $table->unsignedBigInteger('total_price'); // Total Belanja + Ongkir

            // Status Transaksi (Gabungan status order & pembayaran)
            $table->enum('status', [
                'pending',      // Belum bayar (Menunggu Midtrans)
                'paid',         // Sudah bayar (Sukses)
                'processing',   // Sedang dikemas
                'shipped',      // Sedang dikirim (Input Resi Kurir)
                'completed',    // Selesai / Diterima
                'cancelled'     // Dibatalkan / Expired
            ])->default('pending');

            // Pengiriman (Simpan alamat lengkap sebagai Teks saja biar simpel)
            $table->text('shipping_address')->nullable();
            $table->unsignedBigInteger('shipping_cost')->default(0);
            $table->string('courier')->nullable(); // Misal: JNE, J&T
            $table->string('tracking_number')->nullable(); // No Resi Pengiriman Asli

            // Integrasi Midtrans
            $table->string('snap_token')->nullable(); // Token popup pembayaran

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
