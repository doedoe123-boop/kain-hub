@extends('emails.layouts.base')

@section('heading', '✅ Store Reinstated')

@section('body')
    <p>Hi {{ $ownerName }},</p>

    <p>Good news! Your store <strong>{{ $storeName }}</strong> has been reinstated on our marketplace.</p>

    <div class="content-card success">
        <h3>What This Means</h3>
        <p style="margin-bottom: 12px;">Your store is now active again and visible to buyers. You can access your store dashboard to manage products, view orders, and continue business as usual.</p>
        <p class="text-center">
            <a href="{{ $loginUrl }}" class="btn btn-success">Go to Your Store</a>
        </p>
        <p style="font-size: 13px; color: #64748B; margin-top: 12px; margin-bottom: 0;">
            Or copy this link: <a href="{{ $loginUrl }}" style="color: #0F2044;">{{ $loginUrl }}</a>
        </p>
    </div>

    <p>Please ensure compliance with our platform policies to avoid future suspensions.</p>

    <p>Welcome back!<br><strong>The {{ config('app.name') }} Team</strong></p>
@endsection
