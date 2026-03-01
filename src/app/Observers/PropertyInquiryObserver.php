<?php

namespace App\Observers;

use App\Mail\InquiryAutoResponder;
use App\Models\PropertyInquiry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PropertyInquiryObserver
{
    /**
     * Handle the PropertyInquiry "created" event.
     *
     * Sends an auto-responder email to the inquirer.
     */
    public function created(PropertyInquiry $inquiry): void
    {
        if (! $inquiry->email) {
            return;
        }

        try {
            Mail::to($inquiry->email)->queue(new InquiryAutoResponder($inquiry));
        } catch (\Throwable $e) {
            Log::warning('Failed to send inquiry auto-responder', [
                'inquiry_id' => $inquiry->id,
                'email' => $inquiry->email,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
