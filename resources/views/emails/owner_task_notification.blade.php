<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A task has been created for you.</title>
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
            max-width: 150px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #f5f5f5;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #888;
            font-size: 12px;
            border-top: 1px solid #ddd;
        }

        .social-media {
            margin-top: 10px;
        }

        .social-media a {
            display: inline-block;
            margin-right: 10px;
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-media a:hover {
            color: #33cc66;
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
        <div class="header">
            <img class="logo" src="{{ $message->embed(public_path('images/logo.png')) }}"
                alt="{{ env('APP_NAME') }} Logo">
        </div>

        <p>Hi {{ $user->other_names }},</p>

        <p>A task has been created for you by one of our staff {{ $task->creator() }}:</p>

        <table>
            <tbody>
                <tr>
                    <th>Task</th>
                    <td>{{ $task->title }}</td>
                </tr>
            </tbody>
        </table>

        <p>Our team has received it and will review the details shortly. You’ll receive another email when we begin
            work.</p>

        <p>You can check your task status anytime here:</p>


        <div class="code">
            <a href="{{ route('customer.taskDetails', [$task->id]) }}">
                <button class="btn btn-primary btn-md"
                    style="background: #0716AD; border: #0716AD; color:white; padding:15px; border-radius: 5px; font-weight:bold; font-size: 14px ">View
                    Task</button>
            </a>
        </div>

        <div class="">
            <p>— The Growth Bubbles Team</p>
        </div>


    </div>
</body>

</html>
