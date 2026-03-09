<?php

namespace App\Filament\Admin\Resources\CustomerGroupResource\Pages;

use App\Filament\Admin\Resources\CustomerGroupResource;
use Lunar\Admin\Support\Pages\BaseCreateRecord;

class CreateCustomerGroup extends BaseCreateRecord
{
    protected static string $resource = CustomerGroupResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
