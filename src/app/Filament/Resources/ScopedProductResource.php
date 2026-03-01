<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Lunar\Admin\Filament\Resources\ProductResource as LunarProductResource;

class ScopedProductResource extends LunarProductResource
{
    protected static ?string $slug = 'products';

    /**
     * Scope products to the authenticated store owner's store.
     *
     * Admins see all products; store owners see only products linked to their store.
     * Products are associated with stores via the `store_id` attribute in attribute_data.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && ! $user->isAdmin()) {
            $store = $user->getStoreForPanel();
            if ($store) {
                $query->whereJsonContains('attribute_data->store_id', $store->id);
            }
        }

        return $query;
    }
}
