<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter kategori dari URL, misal: ?category=kain_batik
        $categoryId = $request->query('category');

        // Query Dasar: Produk harus aktif
        $query = Product::where('is_active', true);

        // Jika ada filter kategori, tambahkan kondisi
        if ($categoryId) {
            $query->where('category', $categoryId);
        }

        // Ambil data (Urutkan terbaru)
        $products = $query->latest()->get();

        return view('front.home', compact('products'));
    }

    public function show(Product $product)
    {
        // Menampilkan detail produk
        // Route Model Binding akan otomatis mencari berdasarkan slug
        return view('front.detail', compact('product'));
    }
}
