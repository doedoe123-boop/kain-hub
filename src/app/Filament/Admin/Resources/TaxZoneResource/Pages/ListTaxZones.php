<?php

namespace App\Filament\Admin\Resources\TaxZoneResource\Pages;

use App\Filament\Admin\Resources\TaxZoneResource;
use Filament\Actions;
use Lunar\Admin\Support\Pages\BaseListRecords;

class ListTaxZones extends BaseListRecords
{
    protected static string $resource = TaxZoneResource::class;

    protected function getDefaultHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
