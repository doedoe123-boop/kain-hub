<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All API routes are prefixed with /api and use the 'api' middleware group.
| Multi-store endpoints filter by store_id to enforce tenant isolation.
|
*/

// Guest auth routes
Route::post('/register/customer', [AuthController::class, 'register'])->name('api.auth.register.customer');
Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    Route::get('/user', [AuthController::class, 'user'])->name('api.auth.user');

    // Orders – see /skills/order-processing.md
    Route::get('/orders', [OrderController::class, 'index'])->name('api.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('api.orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('api.orders.store');

    // Stores – see /skills/store-management.md
    Route::get('/stores', [StoreController::class, 'index'])->name('api.stores.index');
    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('api.stores.show');
    Route::post('/stores', [StoreController::class, 'store'])->name('api.stores.store');
    Route::post('/stores/{store}/approve', [StoreController::class, 'approve'])->name('api.stores.approve');
    Route::post('/stores/{store}/suspend', [StoreController::class, 'suspend'])->name('api.stores.suspend');
});
