<?php

namespace App\Filament\Admin\Resources\StoreOwnerResource\Pages;

use App\Filament\Admin\Resources\StoreOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStoreOwner extends EditRecord
{
    protected static string $resource = StoreOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}
