<?php

namespace App\Filament\Realty\Resources\RentalAgreementResource\Pages;

use App\Filament\Realty\Resources\RentalAgreementResource;
use App\Services\RentalAgreementService;
use Filament\Resources\Pages\CreateRecord;

class CreateRentalAgreement extends CreateRecord
{
    protected static string $resource = RentalAgreementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return app(RentalAgreementService::class)->normalizePanelAgreementData(
            $data,
            auth()->user()->getStoreForPanel()?->id,
        );
    }
}
