<?php

namespace App\Filament\Admin\Resources\TaxClassResource\Pages;

use App\Filament\Admin\Resources\TaxClassResource;
use Filament\Actions;
use Lunar\Admin\Support\Pages\BaseEditRecord;

class EditTaxClass extends BaseEditRecord
{
    protected static string $resource = TaxClassResource::class;

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
