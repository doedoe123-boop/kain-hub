<?php

namespace App\Filament\Admin\Resources\StoreOwnerResource\Pages;

use App\Filament\Admin\Resources\StoreOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStoreOwner extends ViewRecord
{
    protected static string $resource = StoreOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
