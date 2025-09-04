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
                            <li class="breadcrumb-item">
                                <a href="#">Account Settings</a>
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
                        <!-- form -->
                        <form method="post" action="{{ route('admin.updatePassword') }}">
                            @csrf
                            <div class="row">
                                <!-- form group -->
                                <div class="mb-3 col-12 password-toggle">
                                    <label class="form-label">Current Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="current_password" id="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        placeholder="Enter Current Password" required>
                                    <span class="toggle-password" onclick="togglePasswordVisibility()">
                                        <i class="fe fe-eye"></i>
                                    </span>
                                    @error('current_password')
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

            <div class="offset-xl-2 col-xl-8 col-md-12 col-12">
                <!-- card -->
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Two Factor Authentication</h4>
                    </div>
                    <!-- card body -->
                    <div class="card-body">
                        <div class="mb-5">
                            <h4 class="mb-0">Receive 2FA Code Via Email</h4>
                            <!-- List group -->
                            <ul class="list-group list-group-flush">
                                <!-- List group item -->
                                <li class="list-group-item d-flex align-items-center justify-content-between px-0 py-2">
                                    <div>Receive an authentication code via your registered email address for every new
                                        sign-in attempt.</div>
                                    <div>
                                        <div class="form-check form-switch">
                                            <input data-id="email_auth2fa" type="checkbox"
                                                class="form-check-input emailAuth2FA" id="email2fa"
                                                @if (Auth::user()->auth_2fa == 'Email') {{ "checked" }} @endif>
                                            <label class="form-check-label" for="email2fa"></label>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </div>
                        <div class="mb-5">
                            <h4 class="mb-0">Google Authenticator</h4>
                            <!-- List group -->
                            <ul class="list-group list-group-flush">
                                <!-- List group item -->
                                <li class="list-group-item d-flex align-items-center justify-content-between px-0 py-2">
                                    <div class="row">
                                        <div>Get your authentication code via the Google Authenticator app for every
                                            new sign-in attempt.</div>
                                        @if (!isset(Auth::user()->google2fa_secret))
                                            <div class="mt-2">
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#g2fa-enable">Setup Google
                                                    Authenticator</button>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="form-check form-switch">
                                            <input data-id="google_auth2fa" type="checkbox"
                                                class="form-check-input googleAuth2FA" id="google2fa"
                                                @if (Auth::user()->auth_2fa == 'GoogleAuth') checked @endif type="checkbox">
                                            <label class="form-check-label" for="google2fa"></label>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="g2fa-enable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-md " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Enable Google Authenticator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                <form action="{{ route('admin.enableGA') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="pdb-1-5x">
                        <p><strong>Step 1:</strong> Install this app from <a target="_blank"
                                href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Google
                                Play </a> store or <a target="_blank"
                                href="https://itunes.apple.com/us/app/google-authenticator/id388497605">App
                                Store</a>.</p>
                        <p><strong>Step 2:</strong> Scan the below QR code by your Google Authenticator app, or
                            you
                            can add account manually.</p>
                        <p><strong>Manually add Account:</strong><br>Account Name: <strong
                                class="text-head">{{ env('APP_NAME') }}</strong> <br> Secret Key: <strong
                                class="text-head">{{ $google2faSecret }}</strong></p>

                        <div class="row" style="padding: 0px; margin:0px">
                            <!-- form group -->
                            <div class="col-md-4 col-12" style="padding: 0px; margin:0px">
                                {!! $QRImage !!}
                            </div>
                            <div class="mb-3 col-md-8 col-12">
                                <div class="input-item mb-2">
                                    <label for="google2fa_code">Enter Google Authenticator Code</label>
                                    <input id="google2fa_code" type="text" class="form-control"
                                        name="google2fa_code" required maxlength="6" data-msg-required="Required."
                                        data-msg-maxlength="Maximum 6 chars."
                                        placeholder="Enter the Google Authenticator Code">
                                </div>
                                <input type="hidden" name="google2fa_secret" value="{{ $google2faSecret }}">
                                <button type="submit" class="btn btn-primary btn-sm enable-2fa">Enable Google
                                    Authenticator</button>
                            </div>
                        </div>
                        <div class="gaps-2x"></div>
                        <p class="text-danger"><strong>Note:</strong> After activating this option, if you loose your
                            phone or uninstall the Google Authenticator app, then you will loose access of your account.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    document.getElementById("navSettings").classList.add('show');
    document.getElementById("security").classList.add('active');
</script>
@endsection

@section('customjs')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        $('.googleAuth2FA').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var param = $(this).data('id');

            const targetSwitchIds = ['email2fa'];
            // Toggle the state of the target switches
            targetSwitchIds.forEach(function(targetId) {
                const targetSwitch = $('#' + targetId);
                targetSwitch.prop('checked', false);
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.select2FA') }}",
                data: {
                    'status': status,
                    'param': param
                },
                success: function(data) {
                    if (data.status === "success") {
                        Swal.fire({
                            text: 'Authentication 2FA Method Updated Successfully.',
                            icon: 'success',
                            showConfirmButton: false,
                            toast: true,
                            width: 450,
                            timer: 4000,
                            position: 'top-right'
                        })
                    } else {
                        Swal.fire({
                            text: 'Please Setup Google Authenticator to be able to enable this option.',
                            icon: 'error',
                            showConfirmButton: false,
                            toast: true,
                            width: 450,
                            timer: 4000,
                            position: 'top-right'
                        })
                    }
                }
            });
        })
    })


    $(function() {
        $('.emailAuth2FA').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var param = $(this).data('id');

            const targetSwitchIds = ['google2fa'];
            // Toggle the state of the target switches
            targetSwitchIds.forEach(function(targetId) {
                const targetSwitch = $('#' + targetId);
                targetSwitch.prop('checked', false);
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.select2FA') }}",
                data: {
                    'status': status,
                    'param': param
                },
                success: function(data) {
                    if (data.status === "success") {
                        Swal.fire({
                            text: 'Authentication 2FA Method Updated Successfully.',
                            icon: 'success',
                            showConfirmButton: false,
                            toast: true,
                            width: 450,
                            timer: 4000,
                            position: 'top-right'
                        })
                    } else {
                        Swal.fire({
                            text: 'Oops! Something Went Wrong',
                            icon: 'error',
                            showConfirmButton: false,
                            toast: true,
                            width: 450,
                            timer: 4000,
                            position: 'top-right'
                        })
                    }
                }
            });
        })
    })

</script>

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
