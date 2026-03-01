<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Lunar\Admin\Filament\Resources\OrderResource as LunarOrderResource;

class ScopedOrderResource extends LunarOrderResource
{
    /**
     * Scope orders to the authenticated store owner's store.
     *
     * Admins see all orders; store owners see only their store's orders.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && ! $user->isAdmin()) {
            $store = $user->getStoreForPanel();
            $query->where('store_id', $store?->id);
        }

        return $query;
    }
}
