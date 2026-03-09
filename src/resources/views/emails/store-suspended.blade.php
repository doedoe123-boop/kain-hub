@extends('emails.layouts.base')

@section('heading', 'Store Suspended')

@section('body')
    <p>Hi {{ $ownerName }},</p>

    <p>We regret to inform you that your store <strong>{{ $storeName }}</strong> has been suspended from our marketplace.</p>

    <div class="content-card danger">
        <h3>Reason for Suspension</h3>
        <div style="background: #fff; border-radius: 6px; padding: 14px; border: 1px solid #FECACA;">
            <p class="mb-0">{{ $reason }}</p>
        </div>
    </div>

    <p>While your store is suspended:</p>
    <ul>
        <li>Your store will not be visible to buyers on the marketplace.</li>
        <li>You will not be able to access your store dashboard.</li>
        <li>No new orders can be placed with your store.</li>
    </ul>

    <p>If you believe this suspension was made in error, or if you have resolved the issue, please contact our support team to request a review.</p>

    <p>Regards,<br><strong>The {{ config('app.name') }} Team</strong></p>
@endsection
