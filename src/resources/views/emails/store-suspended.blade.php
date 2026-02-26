<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; }
        .content { background: #fef2f2; border-radius: 8px; padding: 24px; margin: 20px 0; border-left: 4px solid #ef4444; }
        .reason { background: #fff; border-radius: 6px; padding: 16px; margin-top: 12px; border: 1px solid #fecaca; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 32px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #dc2626; margin: 0;">Store Suspended</h1>
    </div>

    <p>Hi {{ $ownerName }},</p>

    <p>We regret to inform you that your store <strong>{{ $storeName }}</strong> has been suspended from our marketplace.</p>

    <div class="content">
        <h3 style="margin-top: 0; color: #991b1b;">Reason for Suspension</h3>
        <div class="reason">
            <p style="margin: 0;">{{ $reason }}</p>
        </div>
    </div>

    <p>While your store is suspended:</p>
    <ul>
        <li>Your store will not be visible to buyers on the marketplace.</li>
        <li>You will not be able to access your store dashboard.</li>
        <li>No new orders can be placed with your store.</li>
    </ul>

    <p>If you believe this suspension was made in error, or if you have resolved the issue, please contact our support team to request a review.</p>

    <p>Regards,<br>The {{ config('app.name') }} Team</p>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
