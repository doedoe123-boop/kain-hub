<?php

namespace App\Filament\Resources\StoreStaffResource\Pages;

use App\Filament\Resources\StoreStaffResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStoreStaff extends ListRecords
{
    protected static string $resource = StoreStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
