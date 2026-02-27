<?php

namespace App\Jobs;

use App\Models\Store;
use App\StoreStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Purge expired documents and soft-deleted records.
 *
 * Runs daily and handles:
 * 1. Rejected store compliance docs → deleted after 30 days
 * 2. Soft-deleted records → permanently deleted after 90 days
 * 3. Orphaned files → cleaned from storage
 */
class PurgeExpiredDocumentsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(): void
    {
        $this->purgeRejectedDocuments();
        $this->purgeSoftDeletedRecords();

        Log::info('[PurgeExpiredDocumentsJob] Purge cycle completed.');
    }

    /**
     * Delete compliance documents for stores rejected more than 30 days ago.
     */
    private function purgeRejectedDocuments(): void
    {
        $stores = Store::withTrashed()
            ->where('status', StoreStatus::Rejected)
            ->where('updated_at', '<', now()->subDays(30))
            ->whereNotNull('compliance_documents')
            ->get();

        $count = 0;

        foreach ($stores as $store) {
            $docs = $store->compliance_documents ?? [];

            foreach ($docs as $doc) {
                if (isset($doc['path']) && Storage::disk('local')->exists($doc['path'])) {
                    Storage::disk('local')->delete($doc['path']);
                    $count++;
                }
            }

            // Clear the reference after deleting files
            $store->update(['compliance_documents' => null]);
        }

        if ($count > 0) {
            Log::info("[PurgeExpiredDocumentsJob] Purged {$count} compliance documents from {$stores->count()} rejected stores.");
        }
    }

    /**
     * Permanently delete soft-deleted records older than 90 days.
     */
    private function purgeSoftDeletedRecords(): void
    {
        $usersDeleted = \App\Models\User::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(90))
            ->forceDelete();

        $storesDeleted = Store::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(90))
            ->forceDelete();

        $payoutsDeleted = \App\Models\Payout::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(90))
            ->forceDelete();

        $total = $usersDeleted + $storesDeleted + $payoutsDeleted;

        if ($total > 0) {
            Log::info("[PurgeExpiredDocumentsJob] Force-deleted {$total} expired records (users: {$usersDeleted}, stores: {$storesDeleted}, payouts: {$payoutsDeleted}).");
        }
    }
}
