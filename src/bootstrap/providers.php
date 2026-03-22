<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\LipatBahayPanelProvider;
use App\Providers\Filament\RealEstatePanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    LipatBahayPanelProvider::class,
    RealEstatePanelProvider::class,
];
