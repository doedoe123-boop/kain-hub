<?php

namespace App\Filament\Realty\Resources\OpenHouseResource\Pages;

use App\Filament\Realty\Resources\OpenHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOpenHouse extends EditRecord
{
    protected static string $resource = OpenHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
