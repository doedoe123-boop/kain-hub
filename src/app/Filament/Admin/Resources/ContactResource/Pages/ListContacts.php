<?php

namespace App\Filament\Admin\Resources\ContactResource\Pages;

use App\Filament\Admin\Resources\ContactResource;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;
}
