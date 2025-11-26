<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Growth Bubbles Concierge 🎉</title>
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
        <p>Hi {{ $user->other_names }}</p>

        <p>Welcome aboard! Your Growth Bubbles Concierge account has been created successfully.</p>

        <p>You’re just one step away from getting expert marketing support on demand.</p>

        <p>To get started, please complete your first payment so we can activate your account.</p>

        <div class="code">
            <a href="{{ route("onboarding.payment") }}">
                <button class="btn btn-primary btn-md"
                    style="background: #0716AD; border: #0716AD; color:white; padding:15px; border-radius: 5px; font-weight:bold; font-size: 14px ">Complete Your Payment</button>
            </a>
        </div>

        <p>Once your payment is confirmed, we’ll guide you through onboarding so our team can get to work.</p>

        <p>Let’s make marketing easier, together.</p>

        <p>— The Growth Bubbles Team</p>
    </div>
</body>

</html>
