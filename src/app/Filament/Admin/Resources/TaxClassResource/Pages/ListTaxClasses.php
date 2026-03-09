<?php

namespace App\Filament\Admin\Resources\TaxClassResource\Pages;

use App\Filament\Admin\Resources\TaxClassResource;
use Filament\Actions;
use Lunar\Admin\Support\Pages\BaseListRecords;

class ListTaxClasses extends BaseListRecords
{
    protected static string $resource = TaxClassResource::class;

    protected function getDefaultHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
