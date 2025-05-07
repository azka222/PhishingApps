<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
        }

        .header img {
            width: 100px;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .otp {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Logo">
        </div>
        <div class="content">
            <h1>OTP Verification</h1>
            <p>Your One-Time Password (OTP) for verification is:</p>
            <div class="otp">{{ $otp }}</div>
            <p>Please use this OTP to complete your verification process. This OTP is valid for 10 minutes.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
