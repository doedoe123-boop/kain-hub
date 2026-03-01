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
        <h1 style="color: #dc2626; margin: 0;">Store Application Rejected</h1>
    </div>

    <p>Hi {{ $ownerName }},</p>

    <p>We regret to inform you that your store application for <strong>{{ $storeName }}</strong> has been rejected.</p>

    <div class="content">
        <h3 style="margin-top: 0; color: #991b1b;">Reason for Rejection</h3>
        <div class="reason">
            <p style="margin: 0;">{{ $reason }}</p>
        </div>
    </div>

    <p>What you can do next:</p>
    <ul>
        <li>Review the rejection reason above carefully.</li>
        <li>Address the issues mentioned and resubmit your application.</li>
        <li>Contact our support team if you have questions.</li>
    </ul>

    <p>Regards,<br>The {{ config('app.name') }} Team</p>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
