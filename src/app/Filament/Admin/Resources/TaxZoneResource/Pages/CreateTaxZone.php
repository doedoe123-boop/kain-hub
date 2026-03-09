<?php

namespace App\Filament\Admin\Resources\TaxZoneResource\Pages;

use App\Filament\Admin\Resources\TaxZoneResource;
use Lunar\Admin\Support\Pages\BaseCreateRecord;

class CreateTaxZone extends BaseCreateRecord
{
    protected static string $resource = TaxZoneResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
