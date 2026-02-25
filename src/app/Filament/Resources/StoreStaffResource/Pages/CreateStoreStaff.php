<?php

namespace App\Filament\Resources\StoreStaffResource\Pages;

use App\Filament\Resources\StoreStaffResource;
use App\UserRole;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateStoreStaff extends CreateRecord
{
    protected static string $resource = StoreStaffResource::class;

    /**
     * Automatically set role and store_id before creating.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var \App\Models\User $owner */
        $owner = Auth::user();

        $data['role'] = UserRole::Staff->value;
        $data['store_id'] = $owner->store?->id;

        return $data;
    }

    /**
     * Assign the staff Spatie role after creation.
     */
    protected function afterCreate(): void
    {
        /** @var \App\Models\User $staffMember */
        $staffMember = $this->record;
        $staffMember->assignRole('staff');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
