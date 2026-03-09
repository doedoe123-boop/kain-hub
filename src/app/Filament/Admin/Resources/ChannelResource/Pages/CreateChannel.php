<?php

namespace App\Filament\Admin\Resources\ChannelResource\Pages;

use App\Filament\Admin\Resources\ChannelResource;
use Lunar\Admin\Support\Pages\BaseCreateRecord;

class CreateChannel extends BaseCreateRecord
{
    protected static string $resource = ChannelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
