<?php

use App\Livewire\Store\StoreLogin;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================================================
// Store subdomain routes ({slug}.localhost)
// =========================================================
Route::domain('{storeSlug}.'.config('app.domain'))
    ->middleware(['web', 'store.subdomain'])
    ->group(function () {
        // Token-protected store login page (each store has a unique token)
        Route::get('/portal/{token}/login', StoreLogin::class)
            ->middleware('guest')
            ->name('store.subdomain.login');

        // Subdomain root redirects to login with token
        Route::get('/', function () {
            if (Auth::check()) {
                $store = app('currentStore');

                // Real estate stores → realty panel, others → Lunar panel
                if ($store?->sector === 'real_estate') {
                    return redirect('/realty/dashboard/tk_'.config('app.realty_path_token'));
                }

                return redirect('/store/dashboard/tk_'.config('app.store_path_token'));
            }

            $store = app('currentStore');

            if ($store && $store->login_token) {
                return redirect('/portal/'.$store->login_token.'/login');
            }

            // Fallback if store has no token yet (pending stores)
            return abort(404);
        })->name('store.subdomain.home');

        // Logout from subdomain
        Route::post('/logout', function () {
            Auth::guard('web')->logout();

            session()->invalidate();
            session()->regenerateToken();

            $store = app('currentStore');

            if ($store && $store->login_token) {
                return redirect('/portal/'.$store->login_token.'/login');
            }

            return redirect('/');
        })->middleware('auth')->name('store.subdomain.logout');
    });
