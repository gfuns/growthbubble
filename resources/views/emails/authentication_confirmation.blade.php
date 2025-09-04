<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Factor Authentication</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            max-width: 100px;
        }

        h2 {
            /* color: #333; */
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 20px;
        }

        .verification-code {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="{{ $message->embed(public_path('images/logo.png')) }}"
                alt="{{ env('APP_NAME') }} Logo">
        </div>

        <h2>Two Factor Authentication</h2>

        <p>Dear {{ $user->last_name . ' ' . $user->other_names }},</p>

        <p>To confirm your authentication attempt, please use the code below:</p>

        <div class="verification-code">
            {{ $otp->otp }}
        </div>

        <p>If you didn't initiate this authentication attempt into your {{ env('APP_NAME') }} account, it means someone
            else has access to your account login credentials and is trying to access your account. Please ignore this
            email and take necessary steps to secure your account.</p>



        <p>If you have any questions or need further assistance, please feel free to contact our support team.</p>

        <div class="">
            <p>Best regards,<br>{{ env('APP_NAME') }} Team</p>
        </div>


    </div>
</body>

</html>
