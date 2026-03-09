<?php

namespace App\Filament\Admin\Resources\TaxRateResource\Pages;

use App\Filament\Admin\Resources\TaxRateResource;
use Filament\Actions;
use Lunar\Admin\Support\Pages\BaseEditRecord;

class EditTaxRate extends BaseEditRecord
{
    protected static string $resource = TaxRateResource::class;

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
