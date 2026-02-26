<?php

namespace App\Providers;

use App\Http\Responses\LunarLogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use Illuminate\Support\ServiceProvider;
use Lunar\Admin\Filament\Resources\StaffResource;
use Lunar\Admin\LunarPanelManager;
use Lunar\Admin\Support\Facades\LunarPanel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Remove StaffResource — we use Users, not Lunar's Staff model
        $this->excludeLunarResources([StaffResource::class]);

        LunarPanel::panel(fn ($panel) => $panel
            ->authGuard('web')
            ->login(null)
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
        )->disableTwoFactorAuth()->register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(LogoutResponse::class, LunarLogoutResponse::class);
    }

    /**
     * Remove specific resources from Lunar's default resource list.
     *
     * @param  array<class-string>  $resources
     */
    private function excludeLunarResources(array $resources): void
    {
        $current = LunarPanelManager::getResources();
        $filtered = array_values(array_diff($current, $resources));

        // Use reflection to set the protected static property
        $reflection = new \ReflectionClass(LunarPanelManager::class);
        $property = $reflection->getProperty('resources');
        $property->setValue(null, $filtered);
    }
}
