<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontController;
use App\Models\Order;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ShippingController;



// --- 1. HALAMAN DEPAN (Bisa diakses Publik) ---
// Ganti view('welcome') bawaan dengan Controller kita
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/p/{product:slug}', [FrontController::class, 'show'])->name('product.show');


// --- 2. HALAMAN DASHBOARD (Breeze Default) ---
Route::get('/dashboard', function () {
    // Ambil pesanan milik user yang sedang login, urutkan dari yang terbaru
    $orders = Order::where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('dashboard', compact('orders'));
})->middleware(['auth', 'verified'])->name('dashboard');


// --- 3. AREA MEMBER (Wajib Login) ---
Route::middleware('auth')->group(function () {
    // Profil User (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 1. Menampilkan Halaman Form Checkout (GET)
    Route::get('/checkout/{product:slug}', [CheckoutController::class, 'show'])->name('checkout.show');

    // 2. Memproses Data & Panggil Midtrans (POST)
    Route::post('/checkout/{product:slug}', [CheckoutController::class, 'process'])->name('checkout.process');

    // 3. Sukses
    Route::get('/checkout/success/{order:number}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Route Cetak Invoice Admin
Route::get('/admin/invoice/{order}', [InvoiceController::class, 'print'])
    ->middleware('auth')
    ->name('admin.invoice.print');

Route::middleware('auth')->group(function () {
    // ... route checkout lainnya ...
    Route::get('/shipping/provinces', [ShippingController::class, 'provinces'])->name('shipping.provinces');
    Route::get('/shipping/cities', [ShippingController::class, 'cities'])->name('shipping.cities');
    Route::post('/shipping/calculate', [ShippingController::class, 'calculateCost'])->name('shipping.calculate');
});

// --- 4. WEBHOOK MIDTRANS (Jalur Khusus Tanpa Login) ---
// Pastikan ini ada agar status "Paid" otomatis update
Route::post('/midtrans/callback', [WebhookController::class, 'handler']);


require __DIR__ . '/auth.php';
