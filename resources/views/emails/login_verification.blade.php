<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $data['subject'] ?? 'Login Verification' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 40px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #2a7d3e, #8bc34a);
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
            line-height: 1.6;
        }

        .otp-box {
            display: inline-block;
            padding: 12px 20px;
            background: #2a7d3e;
            color: white;
            border-radius: 6px;
            font-size: 20px;
            letter-spacing: 2px;
            margin: 10px 0;
        }

        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="header">
            <h1>{{ $data['title'] ?? 'Welcome to Our Service' }}</h1>
        </div>

        <div class="content">
            <p>Hi {{ $data['name'] ?? 'User' }},</p>
            <p>We received a request to log in to your account using this email address.</p>

            @if (isset($data['otp']))
                <p>Please use the OTP below to complete your login:</p>
                <div class="otp-box">{{ $data['otp'] }}</div>
            @else
                <p>{{ $data['message'] ?? 'Thank you for using our service!' }}</p>
            @endif

            <p>If you did not initiate this request, please ignore this email.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ $data['company_name'] ?? 'Your Company' }}. All rights reserved.
        </div>
    </div>

</body>

</html>
