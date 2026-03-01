<?php

namespace App\Filament\Realty\Resources\DevelopmentResource\Pages;

use App\Filament\Realty\Resources\DevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDevelopment extends EditRecord
{
    protected static string $resource = DevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
