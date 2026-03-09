@extends('emails.layouts.base')

@section('heading', '📦 Moving Reminder')

@section('body')
    <p>Hi {{ $booking->contact_name }},</p>

    <p>This is a friendly reminder that your move is scheduled for <strong>tomorrow</strong>.</p>

    <div class="content-card warning">
        <h3>Booking Details</h3>
        <table class="data-table">
            <tr>
                <td class="label">Date &amp; Time</td>
                <td class="value">{{ $booking->scheduled_at->format('F j, Y \a\t g:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Pickup</td>
                <td class="value">{{ $booking->pickup_address }}, {{ $booking->pickup_city }}</td>
            </tr>
            <tr>
                <td class="label">Delivery</td>
                <td class="value">{{ $booking->delivery_address }}, {{ $booking->delivery_city }}</td>
            </tr>
        </table>
    </div>

    <p>Please ensure someone is available at the pickup address. If you have any concerns, please contact the moving company directly.</p>

    <p class="text-center">
        <a href="{{ url('/moving/' . $booking->id) }}" class="btn btn-navy">View Booking Details</a>
    </p>

    <p>Thank you for using {{ config('app.name') }}!</p>
@endsection
