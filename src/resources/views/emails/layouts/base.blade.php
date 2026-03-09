<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <style>
        /* Reset */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }

        /* Base */
        body {
            font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #1E293B;
            background-color: #F8FAFC;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* Layout */
        .email-wrapper { width: 100%; background-color: #F8FAFC; padding: 32px 0; }
        .email-container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #0F2044 0%, #1A2F5A 100%);
            padding: 28px 32px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        .email-header .brand {
            color: #F95D2F;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        /* Body */
        .email-body { padding: 32px; }
        .email-body p { margin: 0 0 16px; color: #475569; font-size: 15px; }
        .email-body strong { color: #1E293B; }

        /* Content card */
        .content-card {
            background: #F8FAFC;
            border-radius: 10px;
            padding: 24px;
            margin: 24px 0;
            border: 1px solid #E2E8F0;
        }
        .content-card h3 {
            margin: 0 0 12px;
            font-size: 15px;
            font-weight: 600;
            color: #0F2044;
        }

        /* Alert variants */
        .content-card.success {
            background: #ECFDF5;
            border-color: #A7F3D0;
        }
        .content-card.success h3 { color: #047857; }

        .content-card.warning {
            background: #FFFBEB;
            border-color: #FDE68A;
        }
        .content-card.warning h3 { color: #92400E; }

        .content-card.danger {
            background: #FEF2F2;
            border-color: #FECACA;
        }
        .content-card.danger h3 { color: #991B1B; }

        /* Buttons */
        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            transition: background-color 0.2s;
        }
        .btn-primary {
            background-color: #F95D2F;
            color: #ffffff !important;
        }
        .btn-navy {
            background-color: #0F2044;
            color: #ffffff !important;
        }
        .btn-success {
            background-color: #059669;
            color: #ffffff !important;
        }

        /* Reference box */
        .reference-box {
            background: #EEF2FB;
            border: 1px solid #D6E0F5;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 12px 0;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: 700;
            color: #0F2044;
            text-align: center;
            letter-spacing: 2px;
        }

        /* Token / URL box */
        .url-box {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 12px 0;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #0F2044;
        }

        /* Security notice */
        .security-notice {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-radius: 8px;
            padding: 14px 16px;
            margin-top: 16px;
            font-size: 13px;
            color: #92400E;
        }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; margin: 12px 0; }
        .data-table td { padding: 10px 0; border-bottom: 1px solid #E2E8F0; font-size: 14px; }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table .label { color: #64748B; }
        .data-table .value { text-align: right; font-weight: 600; color: #1E293B; }
        .data-table .highlight { color: #059669; font-size: 16px; }

        /* List */
        .email-body ul { padding-left: 20px; margin: 0 0 16px; }
        .email-body li { color: #475569; font-size: 14px; margin-bottom: 8px; }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Footer */
        .email-footer {
            text-align: center;
            padding: 20px 32px;
            border-top: 1px solid #E2E8F0;
        }
        .email-footer p {
            font-size: 12px;
            color: #94A3B8;
            margin: 0;
        }
        .email-footer a { color: #64748B; text-decoration: none; }

        /* Utility */
        .text-center { text-align: center; }
        .mt-0 { margin-top: 0; }
        .mb-0 { margin-bottom: 0; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center">
                    <div class="email-container">
                        {{-- Header --}}
                        <div class="email-header">
                            <span class="brand">{{ config('app.name') }}</span>
                            <h1>@yield('heading')</h1>
                        </div>

                        {{-- Body --}}
                        <div class="email-body">
                            @yield('body')
                        </div>

                        {{-- Footer --}}
                        <div class="email-footer">
                            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
