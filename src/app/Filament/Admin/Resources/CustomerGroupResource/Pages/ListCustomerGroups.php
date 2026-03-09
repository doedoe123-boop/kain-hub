<?php

namespace App\Filament\Admin\Resources\CustomerGroupResource\Pages;

use App\Filament\Admin\Resources\CustomerGroupResource;
use Filament\Actions;
use Lunar\Admin\Support\Pages\BaseListRecords;

class ListCustomerGroups extends BaseListRecords
{
    protected static string $resource = CustomerGroupResource::class;

    protected function getDefaultHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
