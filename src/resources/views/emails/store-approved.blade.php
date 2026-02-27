<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; }
        .content { background: #f9fafb; border-radius: 8px; padding: 24px; margin: 20px 0; }
        .btn { display: inline-block; background: #4f46e5; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; margin-top: 16px; }
        .warning { background: #fef3c7; border: 1px solid #f59e0b; border-radius: 6px; padding: 16px; margin-top: 16px; font-size: 13px; color: #92400e; }
        .token-box { background: #eef2ff; border: 1px solid #c7d2fe; border-radius: 6px; padding: 12px 16px; margin: 12px 0; word-break: break-all; font-family: monospace; font-size: 13px; color: #4338ca; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 32px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #4f46e5; margin: 0;">🎉 Congratulations!</h1>
    </div>

    <p>Hi {{ $ownerName }},</p>

    <p>Great news! Your store <strong>{{ $storeName }}</strong> has been reviewed and <strong>approved</strong> on our marketplace.</p>

    <div class="content">
        <h3 style="margin-top: 0;">Getting Started</h3>
        <p>You can now log in to your store dashboard and start managing your products, orders, and settings.</p>

        <p><strong>Your unique store login link:</strong></p>
        <div class="token-box">{{ $loginUrl }}</div>

        <p><a href="{{ $loginUrl }}" class="btn">Go to Your Store</a></p>

        <div class="warning">
            <strong>🔒 Important — Keep this link private!</strong><br>
            This login URL is unique to your store. Do not share it publicly. Only share it with your authorized staff members who need access to your store dashboard.
        </div>
    </div>

    <p>If you have any questions or need help getting started, feel free to reach out to our support team.</p>

    <p>Welcome aboard!<br>The Marketplace Team</p>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
