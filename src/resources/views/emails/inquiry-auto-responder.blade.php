@extends('emails.layouts.base')

@section('heading', 'Thank You for Your Inquiry!')

@section('body')
    <p>Hi {{ $name }},</p>

    <p>We have received your inquiry about <strong>{{ $propertyTitle }}</strong> and wanted to let you know that our team at <strong>{{ $storeName }}</strong> is looking into it.</p>

    <div class="content-card">
        <h3>What Happens Next?</h3>
        <ul>
            <li>A member of our team will review your inquiry.</li>
            <li>We will get back to you within <strong>24–48 hours</strong> with more information.</li>
            <li>If you have any urgent questions, feel free to reply to this email.</li>
        </ul>
    </div>

    <p>Thank you for your interest, and we look forward to helping you!</p>

    <p>Best regards,<br><strong>{{ $storeName }}</strong></p>
@endsection
