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
    <title>{{ env('APP_NAME') }} | Login</title>


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
                                    <h1 class="mb-1 fw-bold">Sign In</h1>
                                    <small style="font-weight: bolder;">SIGN INTO YOUR ACCOUNT</small>
                                </div>
                            </div>

                            @if (Session::has('success'))
                                <div class="alert alert-success">{{ Session::get("success") }}</div>
                            @endif
                            <!-- Form -->
                            <form class="needs-validation" novalidate method="post" action="{{ route('login') }}">
                                @csrf
                                <!-- Username -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" class="form-control" name="email"
                                        placeholder="Enter Your Registered Email Address Here" value="{{ old('email') }}" required>
                                    <div class="invalid-feedback">Please provide your registered email address.</div>
                                    @error('email')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if (Session::get('suspended'))
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">These credentials do not
                                                match our records.</strong>
                                        </span>
                                    @enderror
                            </div>
                            <!-- Password -->
                            <div class="mb-3 password-toggle">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password"
                                    id="password" placeholder="**************" required>
                                <div class="invalid-feedback">Please provide your account password.</div>
                                <span class="toggle-password" onclick="togglePasswordVisibility()">
                                    <i class="fe fe-eye"></i>
                                </span>
                                @error('password')
                                    <span role="alert">
                                        <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Checkbox -->
                            <div class="d-lg-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberme">
                                    <label class="form-check-label " for="rememberme">Remember me</label>
                                </div>
                                <div>
                                    <a href="/password/reset">Forgot your password?</a>
                                </div>
                            </div>
                            <div>
                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary ">Sign in</button>
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
