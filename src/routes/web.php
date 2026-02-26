<?php

use App\Http\Controllers\SupplierProfileController;
use App\Livewire\Store\StoreOwnerRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================================================
// Store subdomain routes (must load first so domain-constrained
// routes take priority over unconstrained ones)
// =========================================================
require __DIR__.'/store.php';

// =========================================================
// Main domain routes
// =========================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public supplier profile (approved stores only)
Route::get('/suppliers/{slug}', [SupplierProfileController::class, 'show'])->name('suppliers.show');

// Store owner registration (KYC with file uploads — Livewire)
Route::middleware('guest')->group(function () {
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
});
