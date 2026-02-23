<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

// Import komponen Form satu per satu agar tidak error
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;

// Import komponen Table satu per satu
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Manajemen Toko';
    protected static ?string $navigationLabel = 'Katalog Batik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Informasi Produk')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->label('Nama Produk')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->required()
                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                    ->disabled()
                                    ->dehydrated(),

                                Select::make('category')
                                    ->label('Kategori')
                                    ->options([
                                        'kain_batik' => 'Kain Batik (2m x 1.15m)',
                                        'kemeja_pria' => 'Kemeja Pria',
                                        'dress_wanita' => 'Dress Wanita',
                                    ])
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if ($state === 'kain_batik') {
                                            $set('size', '200 x 115 cm');
                                        } else {
                                            $set('size', null);
                                        }
                                    }),

                                TextInput::make('size')
                                    ->label('Ukuran')
                                    ->required()
                                    ->placeholder('Contoh: XL, All Size, atau 200x115')
                                    // Kunci input jika kategori adalah Kain Batik
                                    ->disabled(fn (Get $get) => $get('category') === 'kain_batik')
                                    // PENTING: Agar data tetap tersimpan meski disabled
                                    ->dehydrated(),
                            ])->columns(2),

                        Section::make('Harga & Stok')
                            ->schema([
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Harga Satuan'),

                                TextInput::make('stock')
                                    ->required()
                                    ->numeric()
                                    ->default(1) // Default 1 untuk Batik Tulis
                                    ->label('Stok Tersedia'),

                                Toggle::make('is_active')
                                    ->label('Tampilkan di Website?')
                                    ->default(true),
                            ])->columns(2),
                    ])->columnSpan(2),

                Group::make()
                    ->schema([
                        Section::make('Foto & Detail')
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('products')
                                    ->imageEditor()
                                    ->label('Foto Utama'),

                                RichEditor::make('description')
                                    ->label('Filosofi & Deskripsi')
                                    ->toolbarButtons(['bold', 'italic', 'bulletList'])
                                    ->default('Motif Sekar Jagad asli Lasem. Warna dominan merah hati dengan isen-isen yang detail...'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Foto'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('Nama Produk'),

                TextColumn::make('category')
                    ->badge() // Perbaikan V3
                    ->colors([
                        'primary' => 'kemeja_pria',
                        'warning' => 'dress_wanita',
                        'success' => 'kain_batik',
                    ]),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->label('Harga'),

                TextColumn::make('stock')
                    ->numeric()
                    ->sortable()
                    ->label('Stok'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'kain_batik' => 'Kain Batik',
                        'kemeja_pria' => 'Kemeja',
                        'dress_wanita' => 'Dress',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
