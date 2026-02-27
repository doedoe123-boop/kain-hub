<?php

use App\Jobs\PurgeExpiredDocumentsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Data lifecycle — daily cleanup of expired documents and soft-deleted records
Schedule::job(new PurgeExpiredDocumentsJob)->daily()->at('03:00');
