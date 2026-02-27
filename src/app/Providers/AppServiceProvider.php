<?php

namespace App\Providers;

use App\Http\Responses\LunarLogoutResponse;
use App\Listeners\RecordLoginHistory;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
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
            ->path('store/dashboard/tk_'.config('app.store_path_token'))
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

        // Record all login attempts (success + failure) for security audit
        Event::listen(Login::class, [RecordLoginHistory::class, 'handleLogin']);
        Event::listen(Failed::class, [RecordLoginHistory::class, 'handleFailed']);
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
