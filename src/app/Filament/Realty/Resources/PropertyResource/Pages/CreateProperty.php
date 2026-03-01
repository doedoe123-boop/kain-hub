<?php

namespace App\Filament\Realty\Resources\PropertyResource\Pages;

use App\Filament\Realty\Resources\PropertyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

    /**
     * Automatically inject the current user's store_id.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['store_id'] = auth()->user()->getStoreForPanel()?->id;

        return $data;
    }
}
