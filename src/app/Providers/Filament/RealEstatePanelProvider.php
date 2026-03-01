<?php

namespace App\Providers\Filament;

use App\Http\Responses\LunarLogoutResponse;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class RealEstatePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('realty')
            ->path('realty/dashboard/tk_'.config('app.realty_path_token'))
            ->brandName('Property Dashboard')
            ->login(null)
            ->authGuard('web')
            ->colors([
                'primary' => Color::Emerald,
                'danger' => Color::Rose,
                'success' => Color::Green,
                'warning' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Realty/Resources'), for: 'App\\Filament\\Realty\\Resources')
            ->discoverPages(in: app_path('Filament/Realty/Pages'), for: 'App\\Filament\\Realty\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Realty/Widgets'), for: 'App\\Filament\\Realty\\Widgets')
            ->widgets([])
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

    public function boot(): void
    {
        $this->app->bind(LogoutResponse::class, LunarLogoutResponse::class);
    }
}
