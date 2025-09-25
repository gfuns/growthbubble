<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Creation Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 100px;
        }

        h1 {
            /* color: #333333; */
            font-size: 24px;
            margin-top: 0;
        }

        p {
            /* color: #555555; */
            font-size: 16px;
            line-height: 1.5;
        }

        /* p {
      margin-bottom: 20px;
    } */

        ul {
            padding-left: 20px;
        }


        .code {
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
        <div class="logo">
            <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="BPP Logo">
        </div>
        <h1>Account Creation</h1>
        <p>Dear {{ $user->last_name . ', ' . $user->other_names }}</p>
        <p>We are excited to have you join our platform. As a user of {{ env('APP_NAME') }}, you now have access to a
            wide range of utilities and services. Here's a brief overview of what you can expect:</p>

        <ul>
            <li><b>Airtime Purchase:</b> Top up your mobile phone with airtime credits instantly. Stay connected and
                never run out of talk time.</li>
            <li><b>Data Subscription:</b> Purchase data bundles for your mobile devices and enjoy seamless internet
                connectivity on the go.</li>
            <li><b>Cable Subscription:</b> Subscribe to your favorite cable TV packages and enjoy a wide variety of
                channels and entertainment options.</li>
            <li><b>Electricity Purchase:</b> Pay your electricity bills conveniently through our platform. Say goodbye
                to long queues and late payment penalties.</li>
            <li><b>Crypto P2P Trades:</b> Engage in secure peer-to-peer cryptocurrency trading. Buy and sell various
                cryptocurrencies with ease.</li>
        </ul>

        <p>We strive to provide a user-friendly experience and a secure environment for all your transactions. If you
            have any questions or need assistance, our support team is always ready to help.</p>

        <p>Thank you for choosing {{ env('APP_NAME') }}. Start exploring our services today and enjoy the convenience at
            your fingertips.</p>

        <p>Best regards,<br>{{ env('APP_NAME') }}</p>
    </div>
</body>

</html>
