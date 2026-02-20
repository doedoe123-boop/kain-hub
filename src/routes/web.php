<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Store\StoreLogin;
use App\Livewire\Store\StoreOwnerRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================================================
// Store subdomain routes ({slug}.localhost)
// Must be defined BEFORE main routes so domain-constrained
// routes take priority over non-constrained ones.
// =========================================================
Route::domain('{storeSlug}.' . config('app.domain'))
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

// =========================================================
// Main domain routes
// =========================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Guest-only routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/register/store-owner', StoreOwnerRegistration::class)->name('register.store-owner');
    Route::get('/register/store-owner/success', fn () => view('store.registration-success'))->name('register.store-owner.success');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        Auth::guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    // Store owner dashboard — approved stores go to Lunar panel
    Route::middleware('role:store_owner')->group(function () {
        Route::get('/store/dashboard', function () {
            if (auth()->user()->store?->isApproved()) {
                return redirect('/lunar');
            }

            return view('store.dashboard');
        })->name('store.dashboard');

        Route::get('/store/pending', function () {
            return view('store.dashboard');
        })->name('store.pending');
    });

    // Admin-only: download store documents
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/stores/{store}/document/{field}', function (\App\Models\Store $store, string $field) {
            if (! in_array($field, ['business_permit'])) {
                abort(404);
            }

            $path = $store->{$field};

            if (! $path || ! \Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
                abort(404, 'Document not found.');
            }

            return \Illuminate\Support\Facades\Storage::disk('local')->download($path);
        })->name('admin.stores.document');
    });
});
