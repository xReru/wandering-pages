<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
    <style>
        a {
            color: #FFFFFF !important;
            text-decoration: none; 
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #6B46C1;
            color: #FFFFFF !important;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button span {
            color: #FFFFFF !important;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>
        <p>Hello {{ $customer->first_name }},</p>
        <p>We received a request to reset your password. Click the button below to reset your password:</p>
        
        <a href="{{ url('/reset-password?token=' . $token . '&email=' . urlencode($customer->email)) }}" class="button">
            <span>Reset Password</span>
        </a>
        
        <p>If you did not request a password reset, please ignore this email or contact support if you have concerns.</p>
        
        <p>This password reset link will expire in 24 hours.</p>
        
        <div class="footer">
            <p>If you're having trouble clicking the button, copy and paste this URL into your web browser:</p>
            <p>{{ url('/reset-password?token=' . $token . '&email=' . urlencode($customer->email)) }}</p>
        </div>
    </div>
</body>
</html> 