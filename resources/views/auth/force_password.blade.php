@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Account Security')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style type="text/css">
    .col-md-4 svg {
        max-width: 90%;
        /* Ensure the SVG doesn't exceed the width of the container */
        max-height: 90%;
        /* Ensure the SVG doesn't exceed the height of the container */
        border: 1px solid #ccc;
        border-radius: 10px;
    }

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

    .password-toggle .toggle-password-2 {
        position: absolute;
        top: 72%;
        right: 20px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .password-toggle .toggle-password-3 {
        position: absolute;
        top: 72%;
        right: 20px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h2 fw-bold">Account Security </h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Account Security
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <div class="py-6">
        <!-- row -->
        <div class="row">
            <div class="offset-xl-2 col-xl-8 col-md-12 col-12">
                <!-- card -->
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Change Password</h4>
                    </div>
                    <!-- card body -->
                    <div class="card-body p-lg-6">
                        <div class="alert alert-danger d-flex justify-content-between align-items-center">
                            <div>Kindly change your password from the default password generated for you.</div>
                        </div>
                        <!-- form -->
                        <form method="post" action="{{ route('changeDefaultPassword') }}">
                            @csrf
                            <div class="row">
                                <!-- form group -->
                                <div class="mb-3 col-12 password-toggle">
                                    <label class="form-label">Default Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="default_password" id="password"
                                        class="form-control @error('default_password') is-invalid @enderror"
                                        placeholder="Enter Default Password" required>
                                    <span class="toggle-password" onclick="togglePasswordVisibility()">
                                        <i class="fe fe-eye"></i>
                                    </span>
                                    @error('default_password')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12 password-toggle">
                                    <label class="form-label">New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="new_password" id="password2"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        placeholder="Enter New Password" required>
                                    <span class="toggle-password-2" onclick="togglePassword2Visibility()">
                                        <i class="fe fe-eye"></i>
                                    </span>
                                    @error('new_password')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12 password-toggle">
                                    <label class="form-label">Confirm New Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="new_password_confirmation" id="password3"
                                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                        placeholder="Confirm New Password" required>
                                    <span class="toggle-password-3" onclick="togglePassword3Visibility()">
                                        <i class="fe fe-eye"></i>
                                    </span>
                                    @error('new_password_confirmation')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-8"></div>
                                <!-- button -->
                                <div class="col-12">
                                    <button class="btn btn-primary" type="button"
                                        onClick="this.disabled=true; this.innerHTML='Submiting request, please wait...';this.form.submit();">Change
                                        Password</button>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>



        </div>
    </div>
</section>




<script type="text/javascript">
    document.getElementById("navSettings").classList.add('show');
    document.getElementById("security").classList.add('active');
</script>
@endsection

@section('customjs')


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

    function togglePassword2Visibility() {
        var passwordInput = document.getElementById("password2");
        var icon = document.querySelector(".toggle-password-2 i");

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

    function togglePassword3Visibility() {
        var passwordInput = document.getElementById("password3");
        var icon = document.querySelector(".toggle-password-3 i");

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
@endsection
