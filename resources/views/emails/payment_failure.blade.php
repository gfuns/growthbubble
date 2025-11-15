<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action needed: update your payment details</title>
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
        <p>Hi {{ $user->last_name . ', ' . $user->other_names }}</p>

        <p>We couldn’t process your most recent payment for your Growth Bubbles Concierge plan.</p>

        <p>Please update your payment details to avoid any interruption to your service.</p>

        <p>To get started, please complete your first payment so we can activate your account.</p>

        <div class="code">
            <a href="{{ route("customer.billing") }}">
                <button class="btn btn-primary btn-md"
                    style="background: #0716AD; border: #0716AD; color:white; padding:15px; border-radius: 5px; font-weight:bold; font-size: 14px ">Update Payment Details</button>
            </a>
        </div>

        <p>If payment isn’t successful within {grace_period} days, your account will be paused until it’s resolved.</p>

        <p>Need help? Just reply to this email — we’re here to assist.</p>

        <p>— The Growth Bubbles Team</p>
    </div>
</body>

</html>
