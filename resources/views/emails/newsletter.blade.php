<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Newsletter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content">
        {!! $content !!}
    </div>
    <div class="footer">
        <p>This email was sent to you because you subscribed to our newsletter.</p>
        <p>To unsubscribe, please click <a href="{{ config('app.url') }}/unsubscribe">here</a>.</p>
    </div>
</body>
</html> 