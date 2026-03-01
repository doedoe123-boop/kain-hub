<?php

namespace App\Jobs;

use App\Models\Announcement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExpireAnnouncementsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Deactivate announcements whose expiry date has passed.
     */
    public function handle(): void
    {
        Announcement::query()
            ->where('is_active', true)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->update(['is_active' => false]);
    }
}
