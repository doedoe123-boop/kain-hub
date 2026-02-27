<?php

use App\Http\Controllers\Admin\StoreDocumentController;
use Illuminate\Support\Facades\Route;

// =========================================================
// Admin-only routes — path uses the same token as the panel
// =========================================================
$basePath = 'moon/portal/itsec_tk_'.config('app.admin_path_token');

Route::middleware(['web', 'auth', 'role:admin'])->group(function () use ($basePath) {
    // Document signed URL generator
    Route::get("/{$basePath}/stores/{store}/document/{field}", [StoreDocumentController::class, 'show'])
        ->name('admin.stores.document');

    // Document download (signed)
    Route::get("/{$basePath}/stores/{store}/document/{field}/download", [StoreDocumentController::class, 'download'])
        ->name('admin.stores.document.download')
        ->middleware('signed');

    // Document inline preview (for admin panel display)
    Route::get("/{$basePath}/stores/{store}/document/{field}/preview", [StoreDocumentController::class, 'preview'])
        ->name('admin.stores.document.preview');

    // Compliance document inline preview
    Route::get("/{$basePath}/stores/{store}/compliance/{key}/preview", [StoreDocumentController::class, 'compliancePreview'])
        ->name('admin.stores.compliance.preview');
});
