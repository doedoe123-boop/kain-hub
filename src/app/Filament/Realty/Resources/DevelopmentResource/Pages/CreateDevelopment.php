<?php

namespace App\Filament\Realty\Resources\DevelopmentResource\Pages;

use App\Filament\Realty\Resources\DevelopmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDevelopment extends CreateRecord
{
    protected static string $resource = DevelopmentResource::class;

    /**
     * Automatically inject the current user's store_id.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['store_id'] = auth()->user()->getStoreForPanel()?->id;

        return $data;
    }
}
