<?php

namespace App\Mail;

use App\Models\PropertyInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryAutoResponder extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public PropertyInquiry $inquiry,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We Received Your Inquiry!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-auto-responder',
            with: [
                'name' => $this->inquiry->name,
                'propertyTitle' => $this->inquiry->property?->title ?? 'a property',
                'storeName' => $this->inquiry->store?->name ?? 'our team',
            ],
        );
    }
}
