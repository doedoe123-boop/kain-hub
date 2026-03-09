<?php

namespace App\Filament\Admin\Resources\CustomerGroupResource\Pages;

use App\Filament\Admin\Resources\CustomerGroupResource;
use Filament\Actions;
use Lunar\Admin\Support\Pages\BaseEditRecord;

class EditCustomerGroup extends BaseEditRecord
{
    protected static string $resource = CustomerGroupResource::class;

    protected function getDefaultHeaderActions(): array
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
