<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan (Tahun Ini)';
    protected static ?int $sort = 2; // Urutan ke-2 setelah Stats

    protected function getData(): array
    {
        // Ambil data penjualan per bulan tahun ini
        $data = Trend::query(Order::whereIn('status', ['paid', 'shipped', 'completed']))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('total_price');

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan (Rp)',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => '#8B0000', // Warna Batik Red
                    'backgroundColor' => 'rgba(139, 0, 0, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
