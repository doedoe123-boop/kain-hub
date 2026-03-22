<?php

namespace App\Mail;

use App\Models\Property;
use App\Models\SavedSearch;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SavedSearchResultsMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @param  Collection<int, Property>  $properties
     */
    public function __construct(
        public readonly SavedSearch $savedSearch,
        public readonly Collection $properties,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New properties matching "'.$this->savedSearch->name.'"',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.saved-search-results',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
