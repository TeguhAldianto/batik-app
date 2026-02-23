<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    // Agar widget ini update otomatis setiap 15 detik (Realtime-ish)
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        // Hitung Omzet Bulan Ini (Status Paid & Completed)
        $omzet = Order::whereIn('status', ['paid', 'shipped', 'completed'])
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // Hitung Order Perlu Dikirim (Status Paid)
        $toShip = Order::where('status', 'paid')->count();

        // Hitung Pending
        $pending = Order::where('status', 'pending')->count();

        return [
            Stat::make('Omzet Bulan Ini', 'Rp ' . number_format($omzet, 0, ',', '.'))
                ->description('Total pemasukan bersih')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Dummy chart kecil hiasan

            Stat::make('Perlu Dikirim', $toShip)
                ->description('Pesanan lunas menunggu resi')
                ->descriptionIcon('heroicon-m-truck')
                ->color('danger'), // Merah biar admin 'aware' harus kerja

            Stat::make('Menunggu Bayar', $pending)
                ->description('Potensi penjualan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
