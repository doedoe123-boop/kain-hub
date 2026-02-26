<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; }
        .content { background: #f0fdf4; border-radius: 8px; padding: 24px; margin: 20px 0; border-left: 4px solid #22c55e; }
        .btn { display: inline-block; background: #4f46e5; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; margin-top: 16px; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 32px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #16a34a; margin: 0;">Store Reinstated</h1>
    </div>

    <p>Hi {{ $ownerName }},</p>

    <p>Good news! Your store <strong>{{ $storeName }}</strong> has been reinstated on our marketplace.</p>

    <div class="content">
        <h3 style="margin-top: 0; color: #15803d;">What This Means</h3>
        <p>Your store is now active again and visible to buyers. You can access your store dashboard to manage products, view orders, and continue business as usual.</p>
        <p><a href="{{ $loginUrl }}" class="btn">Go to Your Store</a></p>
        <p style="font-size: 14px; color: #6b7280; margin-top: 12px;">
            Or copy this link: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
        </p>
    </div>

    <p>Please ensure compliance with our platform policies to avoid future suspensions.</p>

    <p>Welcome back!<br>The {{ config('app.name') }} Team</p>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
