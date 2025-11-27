<!DOCTYPE html>
<html lang="en">

<head> <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="keywords" content="">
    <meta name="author" content="Gabriel Nwankwo">


    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Libs CSS -->
    <link href="{{ asset('assets/fonts/feather/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
    <title>Password Reset | {{ env('APP_NAME') }}</title>


    <style type="text/css">
        .password-toggle {
            position: relative;
        }

        .password-toggle input[type="password"] {
            padding-right: 30px;
        }

        .password-toggle .toggle-password {
            position: absolute;
            top: 72%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        [data-theme="dark"] ::placeholder {
            color: white;
        }
    </style>
</head>

<body>
    <!-- Page content -->
    <main>
        <section class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center g-0 min-vh-100">

                <div class="col-lg-5 col-md-8 py-8 py-xl-0">
                    <!-- Card -->
                    <div class="card shadow ">
                        <!-- Card body -->
                        <div class="card-body p-6">
                            <div class="mb-4 row">
                                <div class="col-md-3 col-4">
                                    <a href="/"><img src="{{ asset('images/logo.png') }}" class="mb-4"
                                            alt="" style="max-height: 80px"></a>
                                </div>
                                <div class="col-md-9 col-8">
                                    <h2 class="mt-2 mb-1 fw-bold">Password Reset</h2>
                                    <small class="text-black" style="font-weight: bolder;">REGAIN ACCESS TO YOUR
                                        ACCOUNT</small>
                                </div>
                            </div>

                            @if (Session::has('error'))
                                <div class="alert alert-danger">Provided email does not exist on our records.</div>
                            @endif

                            @if (Session::has('passwordResetFailed'))
                                <div class="alert alert-danger">We could not verify the token for this request.</div>
                            @endif

                            @if (Session::has('success'))
                                <div class="alert alert-success">Password Reset Mail Sent Successfully.</div>
                            @endif

                            <p class="text-black"><strong>Hi there,</strong>
                                <br>Have you forgotten your password? No worries. We'll
                                email you instructions to reset your password.
                            </p>
                            <!-- Form -->
                            <form class="needs-validation" novalidate method="post" action="{{ route('initiatePasswordReset') }}">
                                @csrf
                                <!-- Username -->
                                <div class="mb-3">
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Enter your registered email address"
                                        value="{{ old('email') }}" required>
                                    <div class="invalid-feedback">Please enter your registered email address.</div>
                                </div>

                                <div>
                                    <!-- Button -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary ">Reset Password</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
    @include('sweetalert::alert')
    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>


    <script type="text/javascript">
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var icon = document.querySelector(".toggle-password i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fe-eye");
                icon.classList.add("fe-eye-off");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fe-eye-off");
                icon.classList.add("fe-eye");
            }
        }
    </script>

</body>

</html>
