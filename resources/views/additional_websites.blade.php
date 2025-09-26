<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="Xtratech Global Solution">
    <meta name="author" content="Xtratech Global Solution">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <title>Customer Onboarding | GrowthBubble</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver=20241116180">
    <link rel="stylesheet" href="{{ asset('assets/css/kyc.css') }}?ver=20241116180">
    <link rel="stylesheet" href="{{ asset('assets/css/kyc-new.css') }}?ver=20241116180">

    <style>

    </style>

</head>

<body class="page-ath theme-modern page-ath-modern">

    <div class="page-ath-wrap flex-row-reverse">
        <div class="page-ath-content customPageContent">
            <div class="mobileDoLater">
                <a href="#" class="page-ath-logo center-div">
                    <img class="page-ath-logo-img" src="{{ asset('images/gblogo.png') }}" alt="Growth Bubble Logo"
                        style="filter: brightness(0) saturate(100%); height: 40px">
                </a>
            </div>

            <div class="page-ath-form center-div">
                <div class="website-container">

                    <div class="card mb-4">
                        <div class="card-header p-3">
                            <div class="ms-2 text-dark fw-bold">Add Your @if ($site == 2)
                                    2nd
                                @else
                                    3rd
                                @endif Website</div>
                        </div>
                        <div class="card-body">
                            <div class="page-ath-form">
                                <form class="register-form validate validate-modern" method="POST"
                                    action="{{ route('onboarding.storeAdditionalWebsite') }}">
                                    @csrf

                                    <div class="mb-3" style="font-size: 13px; font-weight:bold">Fields with <span
                                            style="color:red">*</span> are required.</div>

                                    <div class="input-item">
                                        <label style="font-size:13px; font-weight:bold">Please enter the Website URL
                                            beginning with https:// <span style="color:red">*</span></label>
                                        <input type="text" placeholder="Your Website URL" class="input-bordered"
                                            name="website_url" data-msg-required="Required." required value="{{ $data->website_url ?? "" }}">
                                    </div>

                                    <div class="input-item">
                                        <label style="font-size:13px; font-weight:bold">Please enter the Admin Login URL
                                            for WordPress beginning with https:// <span
                                                style="color:red">*</span></label>
                                        <input type="text" placeholder="Your Admin Login URL for WordPress"
                                            class="input-bordered" name="admin_url"
                                            data-msg-required="Required. "required value="{{ $data->admin_url ?? "" }}">
                                    </div>

                                    <div class="input-item">
                                        <label style="font-size:13px; font-weight:bold">Please provide the Admin
                                            Username <span style="color:red">*</span></label>
                                        <input type="text" placeholder="Your Admin Username" class="input-bordered"
                                            name="admin_username" data-msg-required="Required." required value="{{ $data->username ?? "" }}">
                                    </div>

                                    <div class="mb-5 mt-2" style="font-size: 13px; font-weight:bold">Please ensure that
                                        you have shared the necessary access with us and that they are valid. Otherwise,
                                        we
                                        will not be able to work on your website.</div>

                                    <input type="hidden" name="site" value="{{ $site }}" />

                                    <button type="submit" class="btn btn-primary btn-block mt-3">Save and Continue
                                        &nbsp;<i class="fas fa-chevron-circle-right"></i></button>

                                    <div class="center-button">
                                        <a href="{{ route('onboarding.lastpass') }}" class="skip">Skip to sharing your
                                            password using LastPass <i class="fas fa-long-arrow-alt-right"></i></a>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="page-ath-gfx">
            <div class="w-100 d-flex ">
                <div class="col-12">
                    <div class="mt-5">
                        <img class="page-ath-logo-img" src="{{ asset('images/gblogo.png') }}" alt="Growth Bubble Logo"
                            style="filter: brightness(0) saturate(100%); height: 40px">
                    </div>


                    <div class="kycinstruction">
                        <ul class="onboardingSteps">
                            <li class="@if (Auth::user()->onbInst() == true) completed @endif"><a
                                    href="{{ route('onboarding.instructions') }}">Important Information</a></li>
                            <li class="@if (Auth::user()->website(1) == true) completed @endif"><a
                                    href="{{ route('onboarding.websiteOne') }}">Step 1 - Website Submission</a></li>
                            <li
                                class="@if ($site == 2) active @endif @if (Auth::user()->website(2) == true) completed @endif">
                                <a href="{{ route('onboarding.additionalWebsites', [2]) }}">Step 2 - Submit Website
                                    2</a>
                            </li>
                            <li
                                class="@if ($site == 3) active @endif @if (Auth::user()->website(3) == true) completed @endif">
                                <a href="{{ route('onboarding.additionalWebsites', [3]) }}">Step 3 - Submit Website
                                    3</a>
                            </li>
                            <li class="@if (Auth::user()->lastpass() == true) completed @endif"><a
                                    href="{{ route('onboarding.lastpass') }}">Step 4 - Share Password Securely</a></li>
                        </ul>

                    </div>




                    <div class="copyright">
                        <span style="margin-right: 10px">&copy; {{ date('Y') }} Growth Bubbles</span> |
                        <span style="margin-left: 10px"><a href="#" target="_blank">Terms and
                                Conditions</a></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver=20241116180"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver=20241116180"></script>

    @include('sweetalert::alert')

    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

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
