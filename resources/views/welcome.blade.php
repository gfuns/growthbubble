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
            <div class="mb-3 mobileDoLater">
                <a href="#" class="page-ath-logo center-div">
                    <img class="page-ath-logo-img" src="{{ asset('images/gblogo.png') }}" alt="Growth Bubble Logo"
                        style="filter: brightness(0) saturate(100%); height: 40px">
                </a>
            </div>

            <div class="progress-container">

                <div class="processHeading">Let's Get You Set Up!</div>
                <p class="processDescription mt-3">To effectively manage your websites, we need secure access to
                    your WordPress website backend. This process is crucial to enable us perform SiteCare.</p>
                <p class="processDescription mt-3">By completing this process promptly, you'll help us:</p>
                <div class="mt-3">
                    <ul>
                        <li>Begin work without unneccessary delays</li>
                        <li>Ensure our team can access all required systems and data</li>
                        <li>Maintain the security of your digital assets through our collaboration</li>
                        <li>Establish clear communication channels for technical implementation</li>
                    </ul>
                </div>
                <p class="processDescription mt-3">The onboarding step comprise of two short steps:</p>
                <p class="processDescription mt-3">(1) You let us know the website(s) we will be managing</p>
                <p class="processDescription mt-3">(2) Instructions on how to share your password securely using
                    LastPass</p>
                <p class="processDescription mt-3">Please note that incomplete access may hamper our ability to
                    manage your website(s)</p>
                <div class="mt-5">
                    <a href="{{ route('onboarding.websiteOne') }}">
                        <button type="button" class="btn btn-primary btn-block">Save and Continue &nbsp;<i
                                class="fas fa-chevron-circle-right"></i></button>
                    </a>
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
                            <li class="active @if (Auth::user()->onbInst() == true) completed @endif"><a
                                    href="{{ route('onboarding.instructions') }}">Important Information</a></li>
                            <li class="@if (Auth::user()->website(1) == true) completed @endif"><a
                                    href="{{ route('onboarding.websiteOne') }}">Step 1 - Website Submission</a></li>
                            <li class="@if (Auth::user()->website(2) == true) completed @endif"><a
                                    href="{{ route('onboarding.additionalWebsites', [2]) }}">Step 2 - Submit Website 2</a></li>
                            <li class="@if (Auth::user()->website(3) == true) completed @endif"><a
                                    href="{{ route('onboarding.additionalWebsites', [3]) }}">Step 3 - Submit Website 3</a></li>
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
