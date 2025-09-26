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

                <div class="processHeading">Secure Password Sharing</div>
                <p class="processDescription mt-3">To ensure the highest level of security for your information we
                    use LastPass, a trusted password management system. This keeps your passwords safe and
                    encrypted, while still allowing us to access them quickly to complete our tasks.</p>
                <p class="processSubHeading mt-3">Sharing Your password with LastPass</p>
                <p class="processDescription mt-3">Here's how to easily share your password with us securely through
                    LastPass:</p>
                <div>
                    <ol>
                        <li>Click here to to visit <a href="www.LastPass.com" target="_blank">www.LastPass.com</a>.
                        </li>
                        <li>Follow the on-screen instructions to create a secure LastPass account (if you don't have
                            one already).</li>
                        <li>One logged in, use LastPass to securely share the relevant password with <a
                                href="#">concierge@growthbubbles.com</a>.</li>
                    </ol>
                </div>
                <p class="processSubHeading mt-3">For New LastPass Users</p>
                <p class="processDescription mt-3">We have prepared a helpful guide on sharing passwords through
                    LastPass <a href="www.LastPass.com" target="_blank">here</a>.</p>
                <p class="processSubHeading mt-3">Once Completed</p>
                <p class="processDescription mt-3">After successfully sharing your password through LastPass, please
                    click the "Complete Onboarding" button below so we can get started on your tasks.</p>
                <p class="processSubHeading mt-3">Benefits of using LastPass</p>
                <div>
                    <ul>
                        <li><b>Enhanced Security:</b> Your passwords are encrypted and stored securely with
                            LastPass.
                        </li>
                        <li><b>Convenience:</b> We can access your password quickly and efficiently. Also when you
                            change your password, you can let us know by simply updating the password on LastPass.
                        </li>
                        <li><b>Peace of Mind:</b> You can relax knowing that your password is safe and protected.
                        </li>
                    </ul>
                </div>
                <div class="mt-5">
                    <a href="{{ route('onboarding.websiteOne') }}">
                        <button type="button" class="btn btn-primary btn-block">Complete Onboarding &nbsp;<i
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
                            <li class="@if (Auth::user()->onbInst() == true) completed @endif"><a
                                    href="{{ route('onboarding.instructions') }}">Important Information</a></li>
                            <li class="@if (Auth::user()->website(1) == true) completed @endif"><a
                                    href="{{ route('onboarding.websiteOne') }}">Step 1 - Website Submission</a></li>
                            <li class="@if (Auth::user()->website(2) == true) completed @endif"><a
                                    href="{{ route('onboarding.additionalWebsites', [2]) }}">Step 2 - Submit Website 2</a></li>
                            <li class="@if (Auth::user()->website(3) == true) completed @endif"><a
                                    href="{{ route('onboarding.additionalWebsites', [3]) }}">Step 3 - Submit Website 3</a></li>
                            <li class="active @if (Auth::user()->lastpass() == true) completed @endif"><a
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
