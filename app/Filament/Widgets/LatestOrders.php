<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 3; // Urutan ke-3
    protected int | string | array $columnSpan = 'full'; // Agar tabel lebar penuh

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil 5 order terbaru
                \App\Models\Order::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('number')->label('Invoice'),
                Tables\Columns\TextColumn::make('user.name')->label('Pelanggan'),
                Tables\Columns\TextColumn::make('total_price')->money('IDR'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Waktu'),
            ])
            ->actions([
                // Tombol aksi agar bisa langsung lihat detail order
                Tables\Actions\Action::make('Lihat')
                    ->url(fn(\App\Models\Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
