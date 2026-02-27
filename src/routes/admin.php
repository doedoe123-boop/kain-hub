<?php

use App\Http\Controllers\Admin\StoreDocumentController;
use Illuminate\Support\Facades\Route;

// =========================================================
// Admin-only routes
// =========================================================
Route::middleware(['web', 'auth', 'role:admin'])->group(function () {
    // Document signed URL generator
    Route::get('/admin/stores/{store}/document/{field}', [StoreDocumentController::class, 'show'])
        ->name('admin.stores.document');

    // Document download (signed)
    Route::get('/admin/stores/{store}/document/{field}/download', [StoreDocumentController::class, 'download'])
        ->name('admin.stores.document.download')
        ->middleware('signed');

    // Document inline preview (for admin panel display)
    Route::get('/admin/stores/{store}/document/{field}/preview', [StoreDocumentController::class, 'preview'])
        ->name('admin.stores.document.preview');

    // Compliance document inline preview
    Route::get('/admin/stores/{store}/compliance/{key}/preview', [StoreDocumentController::class, 'compliancePreview'])
        ->name('admin.stores.compliance.preview');
});
