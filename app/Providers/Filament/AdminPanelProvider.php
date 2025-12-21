<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// Import Widgets
use App\Filament\Admin\Widgets\ClientStatsWidget;
use App\Filament\Admin\Widgets\LatestUsersWidget;
use App\Filament\Admin\Widgets\BookingStatsWidget;
use App\Filament\Admin\Widgets\BookingRevenueChart;
use App\Filament\Admin\Widgets\BookingStatusChart;
use App\Filament\Admin\Widgets\PaymentMethodChart;
use App\Filament\Admin\Widgets\LatestMessagesWidget;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->login()
            ->id('admin')
            ->path('admin')
            ->brandName('THE ARENA')
            ->brandLogo(asset('images/LogoR.png'))
            ->brandLogoHeight('4rem')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])

            // === CUSTOM CSS BACKGROUND ===
            ->renderHook(
                'panels::body.start',
                fn() => view('filament.custom.styles')
            )

            // === CUSTOM LOGIN VIEW ===
            ->renderHook(
                'panels::auth.login.form.after',
                fn() => view('filament.auth.login')
            )

            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                // User & Admin Stats (sort: 1)
                ClientStatsWidget::class,
                
                // Latest Users Table (sort: 2)
                LatestUsersWidget::class,
                
                // Booking & Revenue Stats (sort: 3)
                BookingStatsWidget::class,
                
                // Charts (sort: 4, 5)
                BookingRevenueChart::class,
                BookingStatusChart::class,
                PaymentMethodChart::class,
                
                // Latest Messages (sort: 6) - DI PALING BAWAH
                LatestMessagesWidget::class,
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
                \App\Http\Middleware\TrackPageVisit::class, // ✅ TAMBAHKAN INI
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}