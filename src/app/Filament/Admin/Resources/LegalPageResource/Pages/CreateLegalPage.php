<?php

namespace App\Filament\Admin\Resources\LegalPageResource\Pages;

use App\Filament\Admin\Resources\LegalPageResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLegalPage extends CreateRecord
{
    protected static string $resource = LegalPageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['updated_by'] = Auth::id();

        return $data;
    }
}
