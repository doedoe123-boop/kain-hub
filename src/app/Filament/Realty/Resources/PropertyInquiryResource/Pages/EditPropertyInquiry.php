<?php

namespace App\Filament\Realty\Resources\PropertyInquiryResource\Pages;

use App\Filament\Realty\Resources\PropertyInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyInquiry extends EditRecord
{
    protected static string $resource = PropertyInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
