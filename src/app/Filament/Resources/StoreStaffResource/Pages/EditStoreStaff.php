<?php

namespace App\Filament\Resources\StoreStaffResource\Pages;

use App\Filament\Resources\StoreStaffResource;
use App\Models\User;
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

    /**
     * Sync selected permissions after saving.
     */
    protected function afterSave(): void
    {
        /** @var User $staffMember */
        $staffMember = $this->record;

        $permissions = $this->data['staff_permissions'] ?? [];
        $staffMember->syncPermissions($permissions);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
