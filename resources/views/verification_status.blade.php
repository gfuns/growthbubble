@if ($status == 'Successful')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Email Verified | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CDN (optional for grid/buttons) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: #f5faff;
                font-family: 'Inter', sans-serif;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }

            .logo {
                margin-bottom: 30px;
            }

            .verify-modal {
                background-color: white;
                border-radius: 16px;
                padding: 40px 30px;
                max-width: 500px;
                width: 100%;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
                position: relative;
                text-align: center;
            }

            .verify-icon {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                border: 2px dashed #28a745;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px auto;
                font-size: 36px;
                color: #28a745;
            }

            .verify-modal h2 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 10px;
                color: #1e1e1e;
            }

            .verify-modal p {
                font-size: 0.95rem;
                color: #555;
                margin-bottom: 30px;
            }

            .verify-btn {
                background-color: #14532d;
                color: white;
                font-weight: 600;
                border: none;
                padding: 12px 20px;
                border-radius: 8px;
                width: 100%;
                text-decoration: none;
                display: inline-block;
            }

            .verify-btn:hover {
                background-color: #0e4023;
            }

            .close-btn {
                position: absolute;
                top: 15px;
                right: 20px;
                font-size: 18px;
                color: #aaa;
                cursor: pointer;
            }

            .close-btn:hover {
                color: #000;
            }
        </style>
    </head>

    <body>

        <!-- Logo -->
       <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="Growth Bubble Logo" style="max-width: 45px;"> <span style="font-size: 26px;">Growth Bubble</span>
  </div>

        <!-- Modal -->
        <div class="verify-modal">
            <div class="close-btn">&times;</div>

            <div class="verify-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <h2>Email verified!</h2>
            <p>Your email has been successfully verified. You can now proceed to your dashboard and explore the
                platform.</p>

            <a href="{{ url('/login') }}" class="verify-btn">Proceed To Dashboard</a>
        </div>

    </body>

    </html>
@else
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification Failed | {{ env('APP_NAME') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f5faff;
      font-family: 'Inter', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .logo {
      margin-bottom: 30px;
    }

    .verify-modal {
      background-color: white;
      border-radius: 16px;
      padding: 40px 30px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
      position: relative;
      text-align: center;
    }

    .verify-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      border: 2px dashed #dc3545;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px auto;
      font-size: 36px;
      color: #dc3545;
    }

    .verify-modal h2 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #1e1e1e;
    }

    .verify-modal p {
      font-size: 0.95rem;
      color: #555;
      margin-bottom: 30px;
    }

    .verify-btn {
      background-color: #dc3545;
      color: white;
      font-weight: 600;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      width: 100%;
      text-decoration: none;
      display: inline-block;
    }

    .verify-btn:hover {
      background-color: #bb2d3b;
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 18px;
      color: #aaa;
      cursor: pointer;
    }

    .close-btn:hover {
      color: #000;
    }
  </style>
</head>
<body>

  <!-- Logo -->
  <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="Growth Bubble Logo" style="max-width: 45px;"> <span style="font-size: 26px;">Growth Bubble</span>
  </div>

  <!-- Modal -->
  <div class="verify-modal">
    <div class="close-btn">&times;</div>

    <div class="verify-icon">
      <i class="bi bi-x-lg"></i>
    </div>

    <h2>Verification Failed</h2>
    <p>We're sorry, we couldn't verify your email address. The link may be invalid or expired.</p>

    <a href="#" class="verify-btn">Resend Verification Link</a>
    {{-- <a href="{{ url('/resend-verification') }}" class="verify-btn">Resend Verification Link</a> --}}
  </div>

</body>
</html>


@endif
