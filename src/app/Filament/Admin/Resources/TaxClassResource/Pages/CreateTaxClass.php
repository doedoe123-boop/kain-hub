<?php

namespace App\Filament\Admin\Resources\TaxClassResource\Pages;

use App\Filament\Admin\Resources\TaxClassResource;
use Lunar\Admin\Support\Pages\BaseCreateRecord;

class CreateTaxClass extends BaseCreateRecord
{
    protected static string $resource = TaxClassResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
