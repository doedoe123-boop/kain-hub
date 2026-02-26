<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// =========================================================
// Admin-only routes
// =========================================================
Route::middleware(['web', 'auth', 'role:admin'])->group(function () {
    // Download store KYC documents
    Route::get('/admin/stores/{store}/document/{field}', function (\App\Models\Store $store, string $field) {
        if (! in_array($field, ['business_permit'])) {
            abort(404);
        }

        $path = $store->{$field};

        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404, 'Document not found.');
        }

        return Storage::disk('local')->download($path);
    })->name('admin.stores.document');
});
