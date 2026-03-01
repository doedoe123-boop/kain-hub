<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; }
        .content { background: #f9fafb; border-radius: 8px; padding: 24px; margin: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 32px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #4f46e5; margin: 0;">Thank You for Your Inquiry!</h1>
    </div>

    <p>Hi {{ $name }},</p>

    <p>We have received your inquiry about <strong>{{ $propertyTitle }}</strong> and wanted to let you know that our team at <strong>{{ $storeName }}</strong> is looking into it.</p>

    <div class="content">
        <h3 style="margin-top: 0;">What Happens Next?</h3>
        <ul>
            <li>A member of our team will review your inquiry.</li>
            <li>We will get back to you within <strong>24–48 hours</strong> with more information.</li>
            <li>If you have any urgent questions, feel free to reply to this email.</li>
        </ul>
    </div>

    <p>Thank you for your interest, and we look forward to helping you!</p>

    <p>Best regards,<br><strong>{{ $storeName }}</strong></p>

    <div class="footer">
        <p>This is an automated message. Please do not reply directly unless you need assistance.</p>
    </div>
</body>
</html>
