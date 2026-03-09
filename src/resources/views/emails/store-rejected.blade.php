@extends('emails.layouts.base')

@section('heading', 'Store Application Rejected')

@section('body')
    <p>Hi {{ $ownerName }},</p>

    <p>We regret to inform you that your store application for <strong>{{ $storeName }}</strong> has been rejected.</p>

    <div class="content-card danger">
        <h3>Reason for Rejection</h3>
        <div style="background: #fff; border-radius: 6px; padding: 14px; border: 1px solid #FECACA;">
            <p class="mb-0">{{ $reason }}</p>
        </div>
    </div>

    <p>What you can do next:</p>
    <ul>
        <li>Review the rejection reason above carefully.</li>
        <li>Address the issues mentioned and resubmit your application.</li>
        <li>Contact our support team if you have questions.</li>
    </ul>

    <p>Regards,<br><strong>The {{ config('app.name') }} Team</strong></p>
@endsection
