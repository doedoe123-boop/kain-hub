@extends('emails.layouts.base')

@section('heading', '🎉 Congratulations!')

@section('body')
    <p>Hi {{ $ownerName }},</p>

    <p>Great news! Your store <strong>{{ $storeName }}</strong> has been reviewed and <strong>approved</strong> on our marketplace.</p>

    <div class="content-card success">
        <h3>Getting Started</h3>
        <p style="margin-bottom: 12px;">You can now log in to your store dashboard and start managing your products, orders, and settings.</p>

        <p style="margin-bottom: 4px;"><strong>Your unique store login link:</strong></p>
        <div class="url-box">{{ $loginUrl }}</div>

        <p class="text-center">
            <a href="{{ $loginUrl }}" class="btn btn-success">Go to Your Store</a>
        </p>

        <div class="security-notice">
            <strong>🔒 Important — Keep this link private!</strong><br>
            This login URL is unique to your store. Do not share it publicly. Only share it with your authorized staff members who need access to your store dashboard.
        </div>
    </div>

    <p>If you have any questions or need help getting started, feel free to reach out to our support team.</p>

    <p>Welcome aboard!<br><strong>The {{ config('app.name') }} Team</strong></p>
@endsection
