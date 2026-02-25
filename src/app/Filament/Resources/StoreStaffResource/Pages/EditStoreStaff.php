<?php

namespace App\Filament\Resources\StoreStaffResource\Pages;

use App\Filament\Resources\StoreStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStoreStaff extends EditRecord
{
    protected static string $resource = StoreStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
