<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color; // Import Color
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            // --- 1. BRANDING BATIK LASEM ---
            ->colors([
                'primary' => Color::Red, // Ganti Amber jadi Merah agar senada dengan Batik
                'gray' => Color::Stone,  // Ganti abu-abu jadi Stone (agak kecoklatan/hangat)
            ])
            ->font('Playfair Display') // Gunakan font Serif yang elegan (otomatis load dari Google Fonts)
            ->brandName('BATITUNE') // Nama di pojok kiri atas

            // Opsional: Jika punya logo gambar
            // ->brandLogo(asset('images/logo.png'))
            // ->brandLogoHeight('3rem')
            // ->favicon(asset('images/favicon.png'))

            // --- 2. TATA LETAK & UX ---
            ->sidebarCollapsibleOnDesktop() // Sidebar bisa dikecilkan agar layar lebih luas
            ->maxContentWidth('full') // Agar tabel lebar (bagus untuk data order banyak)

            // --- RESOURCE & PAGES (Bawaan) ---
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Kita matikan widget bawaan karena sudah buat widget custom
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
