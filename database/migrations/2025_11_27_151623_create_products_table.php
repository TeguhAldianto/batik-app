<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Identitas Produk
            $table->string('name'); // Contoh: "Kemeja Sekar Jagad Merah Hati"
            $table->string('slug')->unique(); // Untuk URL SEO

            // Kategori Spesifik (Sesuai request Anda)
            $table->enum('category', [
                'kain_batik',   // Ukuran fix 2m x 1.15m
                'kemeja_pria',  // Ukuran S, M, L, XL
                'dress_wanita'  // Ukuran S, M, L, XL / All Size
            ]);

            // Ukuran
            // Nanti di Filament: Jika kategori 'kain_batik', otomatis isi "200 x 115 cm"
            $table->string('size')->default('All Size');

            // Harga & Stok (Gunakan BigInteger untuk harga Rupiah agar aman)
            $table->unsignedBigInteger('price');
            $table->integer('stock')->default(1); // Default 1 karena Batik Tulis eksklusif

            // Info Visual & Detail
            $table->text('description')->nullable(); // Bisa diisi cerita filosofi Sekar Jagad
            $table->string('image')->nullable();     // Path foto produk

            // Status Tampil
            $table->boolean('is_active')->default(true);

            $table->softDeletes(); // Agar data tidak hilang permanen jika dihapus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
