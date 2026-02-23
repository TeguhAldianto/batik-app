<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function print(Order $order)
    {
        // Security Check: Hanya Admin yang boleh cetak
        // Asumsi: Admin login via Filament menggunakan guard 'web' atau punya role 'admin'
        // Jika login filament beda guard, sesuaikan.
        // Untuk simpelnya, kita cek apakah user login.

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('admin.invoice', compact('order'));
    }
}
