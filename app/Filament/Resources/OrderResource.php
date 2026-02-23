<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Import komponen Form
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

// Import komponen Table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action; // <--- PENTING

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Manajemen Toko';
    protected static ?string $navigationLabel = 'Pesanan Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Order')
                    ->schema([
                        TextInput::make('number')
                            ->label('No. Invoice')
                            ->disabled(),

                        TextInput::make('created_at')
                            ->label('Tanggal Order')
                            ->disabled(),

                        Select::make('status')
                            ->options([
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Sudah Dibayar',
                                'processing' => 'Sedang Diproses',
                                'shipped' => 'Dikirim',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->required(),
                    ])->columns(2),

                Section::make('Pengiriman')
                    ->schema([
                        Textarea::make('shipping_address')
                            ->label('Alamat Tujuan')
                            ->disabled(),

                        TextInput::make('courier')
                            ->label('Kurir'),

                        TextInput::make('tracking_number')
                            ->label('No. Resi (Input disini)'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable()
                    ->label('Invoice'),

                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Pelanggan'),

                TextColumn::make('total_price')
                    ->money('IDR')
                    ->label('Total Bayar'),

                // PERBAIKAN V3: BadgeColumn diganti TextColumn + badge()
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Waktu'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Tombol Cetak Invoice (Tab Baru)
                Action::make('pdf')
                    ->label('Cetak')
                    ->icon('heroicon-o-printer')
                    ->url(fn(Order $record) => route('admin.invoice.print', $record))
                    ->openUrlInNewTab(),

                // Tombol Edit (Input Resi)
                Tables\Actions\EditAction::make()
                    ->label('Input Resi'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
