<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\View\View;

class SupplierProfileController extends Controller
{
    /**
     * Display the public supplier profile page.
     *
     * Only approved stores are visible to the public.
     */
    public function show(string $slug): View
    {
        $store = Store::query()
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->with('owner:id,name,created_at')
            ->firstOrFail();

        return view('suppliers.profile', compact('store'));
    }
}
