<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboarding complete – you’re all set to start submitting tasks!</title>
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

        <p>We’ve received your onboarding details — thank you! Your account setup is now complete.</p>

        <p>You can now start submitting tasks directly through your client portal.</p>

        <div class="code">
            <a href="{{ route('customer.newCustomerTask', [1]) }}">
                <button class="btn btn-primary btn-md"
                    style="background: #0716AD; border: #0716AD; color:white; padding:15px; border-radius: 5px; font-weight:bold; font-size: 14px ">Submit
                    Your First Task</button>
            </a>
        </div>

        <p>If you need inspiration, here are some examples of what you can request:</p>
        <ul>
            <li>Email design and setup</li>
            <li>Social media post design</li>
            <li>Marketing tool integration</li>
            <li>Website updates or new pages</li>
        </ul>

        <p>We can’t wait to get started.</p>

        <p>— The Growth Bubbles Team</p>
    </div>
</body>

</html>
