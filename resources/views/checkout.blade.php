<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="Growth Bubble">
    <meta name="author" content="Growth Bubble">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <title>Sign Up | GrowthBubble</title>
    <link rel="stylesheet" href="assets/css/vendor.bundle.css?ver=20241116180">
    <link rel="stylesheet" href="assets/css/register.css?ver=20241116180">

    <style>
        body {
            background-image: url('images/authPattern.png');
            /* Replace with your image path */
            background-size: cover;
            /* Ensures the image covers the entire page */
            background-position: center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents image repetition */
            min-height: 100vh;
        }

        .logo-name {
            /* color:#495463; */
            font-weight: bolder;
            margin-left: 10px;
            font-size: 20px;
            line-height: 1em
                /* #0040ff */
        }

        .customPageContent {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            margin-top: 80px;
            margin-left: 50px;
            margin-right: 100px;
            padding: 20px
        }

        .page-ath-form,
        .page-ath-header,
        .page-ath-footer,
        .page-ath-text {
            margin-left: 5px;
            margin-right: 5px;
            padding: 0 10px
        }

        .mobileDoLater {
            display: none;
        }

        @media (max-width: 575px) {
            .customPageContent {
                background: #fff;
                border: none;
                border-radius: 0px;
                margin: 30px 0px 0px 0px;
                padding: 0px
            }

            .page-ath-form,
            .page-ath-header,
            .page-ath-footer,
            .page-ath-text {
                margin-left: auto;
                margin-right: auto;
                padding: 0 30px
            }

            .mobileDoLater {
                display: block;
            }
        }
    </style>

</head>

<body class="page-ath theme-modern page-ath-modern">

    <div class="page-ath-wrap flex-row-reverse">
        <div class="page-ath-contentss customPageContent">
            <div class="mb-5 mobileDoLater text-center">
                <a href="#" class="page-ath-logo center-div">
                    <img class="page-ath-logo-img" src="{{ asset('images/gblogo.png') }}" alt="Growth Bubble Logo"
                        style="filter: brightness(0) saturate(100%); height: 40px">
                </a>
            </div>

            <div class="page-ath-header mb-3">
                <div class="logo-name text-center mb-3">Your Online Marketing Team Starts Here...</div>

                <div class="text-center mb-3" style="font-size: 19px; line-height:1em"><small><strong>Now you can
                            finally
                            make that dream happen by offloading your marketing tasks to our team of
                            heroes.</strong></small></div>
            </div>

            @if ($errors->has('regError'))
                <div class="alert alert-dismissible fade show alert-danger"><a href="javascript:void(0)" class="close"
                        data-dismiss="alert" aria-label="close" style="color:white">&nbsp;</a>
                    {{ $errors->first('regError') }}
                </div>
            @endif

            <div class="page-ath-form">
                <form class="register-form validate validate-modern" method="POST"
                    action="{{ route('customerOnboarding') }}" id="register">
                    @csrf
                    <div style="display: flex; gap: 20px; ">
                        <div class="input-item" style="width:100%">
                            {{-- <label style="font-size:12px; font-weight:bold">First Name <span style="color:red">*</span></label> --}}
                            <input type="text" placeholder="Your First Name" class="input-bordered" name="first_name"
                                value="" data-msg-required="Required." required>
                        </div>
                        <div class="input-item" style="width:100%">
                            {{-- <label style="font-size:12px; font-weight:bold">Last Name <span style="color:red">*</span></label> --}}
                            <input type="text" placeholder="Your Last Name" class="input-bordered" name="last_name"
                                value="" data-msg-required="Required." required>
                        </div>
                    </div>
                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">Email Address <span style="color:red">*</span></label> --}}
                        <input type="email" placeholder="Your Email Address" class="input-bordered" name="email"
                            value=""data-msg-required="Required." data-msg-email="Enter valid email." required>
                    </div>

                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">Phone Number <span style="color:red">*</span></label> --}}
                        <input type="text" placeholder="Your Phone Number" class="input-bordered" name="phone_number"
                            value=""data-msg-required="Required." data-msg-email="Enter valid phone number."
                            required>
                    </div>

                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">Business Name <span style="color:red">*</span></label> --}}
                        <input type="text" placeholder="Your Company / Business Name" class="input-bordered"
                            name="organization_name" value=""data-msg-required="Required."
                            data-msg-email="Enter company / business name." required>
                    </div>
                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">Password <span style="color:red">*</span></label> --}}
                        <input type="password" placeholder="Password" class="input-bordered" name="password"
                            id="password" minlength="6" data-msg-required="Required."
                            data-msg-minlength="At least 6 chars." required>
                    </div>

                    <div class="input-item">
                        {{-- <label style="font-size:12px; font-weight:bold">How did you hear about us?</label> --}}
                        <select name="referral_channel" class="select select-block select-bordered" required>
                            <option value="">How did you hear about us?</option>
                            <option value="Twitter">Twitter</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Newspaper">Newspaper</option>
                            <option value="TV">TV</option>
                            <option value="Bill Board">Bill Board</option>
                            <option value="Referral">Referral</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <input type="hidden" name="product" value="{{ $product->id }}">
                    <input type="hidden" name="plan" value="{{ $plan->id }}">
                    <div class="input-item text-left">
                        <input name="terms" class="input-checkbox input-checkbox-md" id="agree"
                            type="checkbox" required="required"
                            data-msg-required="You should accept our terms and policy.">
                        <label for="agree">I agree to the <a target="_blank" href="#">Terms</a>
                            and <a target="_blank" href="#">Privacy
                                Policy</a>.</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Create Account</button>
                </form>

                <div class="mb-2">&nbsp;</div>
            </div>

        </div>

        <div class="page-ath-gfx">
            <div class="w-100 d-flex justify-content-center">
                <div class="col-9">
                    <div class="mb-5">
                        <img class="page-ath-logo-img" src="images/gblogo.png" alt="Growth Bubble Logo"
                            style="filter: brightness(0) saturate(100%); height: 40px">
                    </div>
                    <div class="mb-3" style="display: flex; gap: 10px; ">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.99998 0C3.59199 0 0 3.5921 0 8.00021C0 12.4083 3.59199 16.0004 7.99998 16.0004C12.408 16.0004 16 12.4083 16 8.00021C16 3.5921 12.408 0 7.99998 0ZM11.824 6.16017L7.28798 10.6963C7.17598 10.8083 7.02398 10.8723 6.86398 10.8723C6.70398 10.8723 6.55198 10.8083 6.43998 10.6963L4.17599 8.43223C3.94399 8.20022 3.94399 7.81621 4.17599 7.5842C4.40799 7.3522 4.79199 7.3522 5.02399 7.5842L6.86398 9.42425L10.976 5.31214C11.208 5.08014 11.592 5.08014 11.824 5.31214C12.056 5.54415 12.056 5.92016 11.824 6.16017Z"
                                    fill="#0765FF"></path>
                            </svg>
                        </div>
                        <div>
                            <strong><span style="font-size:18px">Get Your Business Online Quickly</span></strong><br />
                            Build a new website or revamp an old one, all within 5 weeks.
                        </div>
                    </div>

                    <div class="mb-3" style="display: flex; gap: 10px; ">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.99998 0C3.59199 0 0 3.5921 0 8.00021C0 12.4083 3.59199 16.0004 7.99998 16.0004C12.408 16.0004 16 12.4083 16 8.00021C16 3.5921 12.408 0 7.99998 0ZM11.824 6.16017L7.28798 10.6963C7.17598 10.8083 7.02398 10.8723 6.86398 10.8723C6.70398 10.8723 6.55198 10.8083 6.43998 10.6963L4.17599 8.43223C3.94399 8.20022 3.94399 7.81621 4.17599 7.5842C4.40799 7.3522 4.79199 7.3522 5.02399 7.5842L6.86398 9.42425L10.976 5.31214C11.208 5.08014 11.592 5.08014 11.824 5.31214C12.056 5.54415 12.056 5.92016 11.824 6.16017Z"
                                    fill="#0765FF"></path>
                            </svg>
                        </div>
                        <div>
                            <strong><span style="font-size:18px">Escape Marketing Overwhelm</span></strong><br />
                            Get unlimited maketing tasks completed for you monthly.
                        </div>
                    </div>

                    <div class="mb-3" style="display: flex; gap: 10px; ">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.99998 0C3.59199 0 0 3.5921 0 8.00021C0 12.4083 3.59199 16.0004 7.99998 16.0004C12.408 16.0004 16 12.4083 16 8.00021C16 3.5921 12.408 0 7.99998 0ZM11.824 6.16017L7.28798 10.6963C7.17598 10.8083 7.02398 10.8723 6.86398 10.8723C6.70398 10.8723 6.55198 10.8083 6.43998 10.6963L4.17599 8.43223C3.94399 8.20022 3.94399 7.81621 4.17599 7.5842C4.40799 7.3522 4.79199 7.3522 5.02399 7.5842L6.86398 9.42425L10.976 5.31214C11.208 5.08014 11.592 5.08014 11.824 5.31214C12.056 5.54415 12.056 5.92016 11.824 6.16017Z"
                                    fill="#0765FF"></path>
                            </svg>
                        </div>
                        <div>
                            <strong><span style="font-size:18px">Grow Your Business</span></strong><br />
                            Focus on growth while we manage all of your wordpress websites.
                        </div>
                    </div>

                    <div class="mb-3" style="display: flex; gap: 10px; ">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.99998 0C3.59199 0 0 3.5921 0 8.00021C0 12.4083 3.59199 16.0004 7.99998 16.0004C12.408 16.0004 16 12.4083 16 8.00021C16 3.5921 12.408 0 7.99998 0ZM11.824 6.16017L7.28798 10.6963C7.17598 10.8083 7.02398 10.8723 6.86398 10.8723C6.70398 10.8723 6.55198 10.8083 6.43998 10.6963L4.17599 8.43223C3.94399 8.20022 3.94399 7.81621 4.17599 7.5842C4.40799 7.3522 4.79199 7.3522 5.02399 7.5842L6.86398 9.42425L10.976 5.31214C11.208 5.08014 11.592 5.08014 11.824 5.31214C12.056 5.54415 12.056 5.92016 11.824 6.16017Z"
                                    fill="#0765FF"></path>
                            </svg>
                        </div>
                        <div>
                            <strong><span style="font-size:18px">Grow Your Business</span></strong><br />
                            Shop Templates and guides to grow your business.
                        </div>
                    </div>

                    <div class="mb-5">&nbsp;</div>
                    <div class="mb-5">&nbsp;</div>
                    <div class="mb-5">&nbsp;</div>
                    <div class="mb-5">&nbsp;</div>

                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.bundle.js?ver=20241116180"></script>
    <script src="assets/js/script.js?ver=20241116180"></script>
    <script type="text/javascript">
        jQuery(function() {
            var $frv = jQuery('.validate');
            if ($frv.length > 0) {
                $frv.validate({
                    errorClass: "input-bordered-error error"
                });
            }
        });
    </script>

</body>

</html>
