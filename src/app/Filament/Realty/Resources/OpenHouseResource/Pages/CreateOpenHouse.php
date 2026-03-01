<?php

namespace App\Filament\Realty\Resources\OpenHouseResource\Pages;

use App\Filament\Realty\Resources\OpenHouseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOpenHouse extends CreateRecord
{
    protected static string $resource = OpenHouseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['store_id'] = auth()->user()->getStoreForPanel()?->id;

        return $data;
    }
}
