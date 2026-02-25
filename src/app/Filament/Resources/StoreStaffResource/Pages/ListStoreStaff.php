<?php

namespace App\Filament\Resources\StoreStaffResource\Pages;

use App\Filament\Resources\StoreStaffResource;
use Filament\Resources\Pages\ListRecords;

class ListStoreStaff extends ListRecords
{
    protected static string $resource = StoreStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
