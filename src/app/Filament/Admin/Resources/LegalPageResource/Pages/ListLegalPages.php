<?php

namespace App\Filament\Admin\Resources\LegalPageResource\Pages;

use App\Filament\Admin\Resources\LegalPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLegalPages extends ListRecords
{
    protected static string $resource = LegalPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
