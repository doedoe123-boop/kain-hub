<?php

namespace App\Filament\Realty\Resources\DevelopmentResource\Pages;

use App\Filament\Realty\Resources\DevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDevelopments extends ListRecords
{
    protected static string $resource = DevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
