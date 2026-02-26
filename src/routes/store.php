<?php

use App\Livewire\Store\StoreLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================================================
// Store subdomain routes ({slug}.localhost)
// =========================================================
Route::domain('{storeSlug}.'.config('app.domain'))
    ->middleware(['web', 'store.subdomain'])
    ->group(function () {
        // Store login page (guests only on this subdomain)
        Route::get('/login', StoreLogin::class)
            ->middleware('guest')
            ->name('store.subdomain.login');

        // Subdomain root redirects to Lunar panel
        Route::get('/', function () {
            if (Auth::check()) {
                return redirect('/lunar');
            }

            return redirect('/login');
        })->name('store.subdomain.home');

        // Logout from subdomain
        Route::post('/logout', function () {
            Auth::guard('web')->logout();

            session()->invalidate();
            session()->regenerateToken();

            return redirect('/login');
        })->middleware('auth')->name('store.subdomain.logout');
    });
