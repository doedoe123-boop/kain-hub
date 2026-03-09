@extends('emails.layouts.base')

@section('heading', 'Inquiry Update')

@section('body')
    <p>Hi {{ $name }},</p>

    <p>We have an update on your inquiry about <strong>{{ $propertyTitle }}</strong> from <strong>{{ $storeName }}</strong>.</p>

    <div class="content-card">
        <p class="mt-0">
            <strong>Current Status:</strong>&nbsp;
            @php
                $badgeColors = match ($status->value) {
                    'contacted' => 'background: #FFFBEB; color: #92400E;',
                    'viewing_scheduled' => 'background: #EEF2FB; color: #0F2044;',
                    'negotiating' => 'background: #ECFDF5; color: #047857;',
                    default => 'background: #F1F5F9; color: #475569;',
                };
            @endphp
            <span class="badge" style="{{ $badgeColors }}">{{ $status->label() }}</span>
        </p>

        @if ($status->value === 'contacted')
            <p class="mb-0">One of our agents has reached out or will be contacting you shortly. Please keep an eye on your phone and email.</p>
        @elseif ($status->value === 'viewing_scheduled')
            <p>A property viewing has been scheduled for you.</p>
            @if ($viewingDate)
                <p><strong>Viewing Date &amp; Time:</strong> {{ \Carbon\Carbon::parse($viewingDate)->format('F j, Y \a\t g:i A') }}</p>
            @endif
            <p class="mb-0">Please make sure to be available at the scheduled time. If you need to reschedule, reply to this email or contact us directly.</p>
        @elseif ($status->value === 'negotiating')
            <p class="mb-0">Great news — your inquiry has progressed to the negotiation stage. Our agent will be in touch with the details.</p>
        @elseif ($status->value === 'closed')
            <p class="mb-0">Your inquiry has been closed. If you believe this was done in error or if you have further questions, feel free to reach out to us.</p>
        @else
            <p class="mb-0">Your inquiry status has been updated. Our team will follow up with you shortly.</p>
        @endif
    </div>

    <p>If you have any questions, please reply to this email or contact <strong>{{ $storeName }}</strong> directly.</p>

    <p>Best regards,<br><strong>{{ $storeName }}</strong></p>
@endsection
