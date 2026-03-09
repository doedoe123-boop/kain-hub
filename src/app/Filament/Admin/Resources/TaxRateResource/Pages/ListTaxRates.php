<?php

namespace App\Filament\Admin\Resources\TaxRateResource\Pages;

use App\Filament\Admin\Resources\TaxRateResource;
use Filament\Actions;
use Lunar\Admin\Support\Pages\BaseListRecords;

class ListTaxRates extends BaseListRecords
{
    protected static string $resource = TaxRateResource::class;

    protected function getDefaultHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
