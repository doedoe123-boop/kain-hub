<?php

namespace App\Filament\Realty\Resources\TestimonialResource\Pages;

use App\Filament\Realty\Resources\TestimonialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTestimonial extends CreateRecord
{
    protected static string $resource = TestimonialResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['store_id'] = auth()->user()->getStoreForPanel()?->id;

        return $data;
    }
}
