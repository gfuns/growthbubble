<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="apps" content="Growth Bubble">
    <meta name="author" content="Growth Bubble">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <title>Payment Details | GrowthBubble</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css') }}?ver=20241116180">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}?ver=20241116180">
    <script type="text/javascript" src="{{ asset('assets/js/countries.js') }}"></script>
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            background-image: url('/images/authPattern.png');
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
            /* margin-left: 10px; */
            font-size: 20px;
            line-height: 1em
                /* #0040ff */
        }

        #card-errors {
            display: none;
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

        .display-price {
            padding: 15px 20px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 10px;
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
        <div class="page-ath-content customPageContent">
            <div class="mb-5 mobileDoLater text-center">
                <a href="#" class="page-ath-logo center-div">
                    <img class="page-ath-logo-img" src="{{ asset('images/gblogo.png') }}" alt="Growth Bubble Logo"
                        style="filter: brightness(0) saturate(100%); height: 40px">
                </a>
            </div>

            <div class="page-ath-header mb-3">
                <div class="logo-name mb-3">Add Payment Details</div>

                {{-- <div class="text-center mb-3" style="font-size: 19px; line-height:1em"><small><strong>By providing your
                            card information, you allow Growth Bubbles to charge your card for future payments in
                            accordance with our terms.</strong></small></div> --}}
            </div>

            <div class="alert alert-danger" id="card-errors" role="alert"></div>


            <div class="page-ath-form">
                <form class="validate validate-modern" id="payment-form">
                    <div class="input-item">
                        <label style="font-size:13px; font-weight:bold">Organization Name </label>
                        <input type="text" class="input-bordered" name="organization"
                            value="{{ Auth::user()->organization }}" data-msg-required="Required." readonly>
                    </div>

                    <div class="input-item">
                        <label style="font-size:13px; font-weight:bold">Country or Region</label>
                        <select id="country" name="country" class="select select-block select-bordered" required>
                            <option value="">Select Country or Region</option>
                        </select>
                        <script language="javascript">
                            print_country("country");
                        </script>
                    </div>

                    <div class="input-item">
                        <label style="font-size:13px; font-weight:bold">Contact Address</label>
                        <input id="address" type="text" placeholder="Contact Address" class="input-bordered"
                            name="contact_address" value=""data-msg-required="Required."
                            data-msg-email="Enter contact address." required>
                    </div>

                    <div class="input-item">
                        <div class="input-bordered" id="card-element"></div>
                    </div>

                    <div class="input-item text-left">
                        <input name="terms" class="input-checkbox input-checkbox-md" id="agree" type="checkbox"
                            required="required" data-msg-required="You should accept our terms and policy.">
                        <label for="agree">By proceeding, you authorise Growth Bubbles to charge your card for this
                            transaction and for future recurring payments in accordance with our terms of service. You
                            can cancel your service anytime.</a></label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3" id="submit-btn">Complete Checkout
                        &nbsp;<i class="fas fa-chevron-circle-right"></i></button>
                </form>

                <div class="mb-2">&nbsp;</div>
            </div>

        </div>

        <div class="page-ath-gfx">
            <div class="w-100 d-flex justify-content-center">
                <div class="col-9">
                    <div class="mb-5">
                        <img class="page-ath-logo-img" src="{{ asset('images/gblogo.png') }}" alt="Growth Bubble Logo"
                            style="filter: brightness(0) saturate(100%); height: 40px">
                    </div>
                    <div class="mb-3">
                        <div>
                            <strong><span style="font-size:17px; color:black; font-weight:bold"><u>Plan Summary:
                                        {{ $subscription->product->product }}
                                        {{ $subscription->plan->plan }}</u></span></strong>
                        </div>
                    </div>

                    @foreach ($features as $feat)
                        <div class="mb-2" style="display: flex; gap: 10px; ">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M7.99998 0C3.59199 0 0 3.5921 0 8.00021C0 12.4083 3.59199 16.0004 7.99998 16.0004C12.408 16.0004 16 12.4083 16 8.00021C16 3.5921 12.408 0 7.99998 0ZM11.824 6.16017L7.28798 10.6963C7.17598 10.8083 7.02398 10.8723 6.86398 10.8723C6.70398 10.8723 6.55198 10.8083 6.43998 10.6963L4.17599 8.43223C3.94399 8.20022 3.94399 7.81621 4.17599 7.5842C4.40799 7.3522 4.79199 7.3522 5.02399 7.5842L6.86398 9.42425L10.976 5.31214C11.208 5.08014 11.592 5.08014 11.824 5.31214C12.056 5.54415 12.056 5.92016 11.824 6.16017Z"
                                        fill="#0716AD"></path>
                                </svg>
                            </div>
                            <div>
                                {{ $feat->feature }}
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4 display-price">
                        <span
                            style="color: black; font-weight:bold; font-size:32px">&pound;{{ $subscription->plan->pricing }}</span>
                        <sub><span style="color: black; font-weight:bold; font-size:15px">GBP Billed
                                {{ $subscription->plan->frequency }}</span></sub>
                        <p style="color: black; font-size:13px">No Lock In Contract. Change Plan or Cancel Any Time.</p>
                    </div>

                    <div class="mb-5">&nbsp;</div>
                    {{-- <div class="mb-5">&nbsp;</div> --}}

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.bundle.js') }}?ver=20241116180"></script>
    <script src="{{ asset('assets/js/script.js') }}?ver=20241116180"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

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

        $(document).ready(function() {
            $('#country').select2();
        });
    </script>


    <script>
        // 1. Initialize Stripe
        const stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY') }}"); // publishable key
        const elements = stripe.elements();

        // 2. Style the card element
        const style = {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a'
            }
        };

        // 3. Create card element
        const card = elements.create('card', {
            style,
            hidePostalCode: true
        });
        card.mount('#card-element');

        // 4. Handle errors
        card.on('change', ({
            error
        }) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.style.display = 'block';
                displayError.textContent = error.message;
            } else {
                displayError.style.display = 'none';
                displayError.textContent = '';
            }

            // displayError.style.display = 'block';
            // displayError.textContent = error ? error.message : '';
        });

        // 5. Handle form submission
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();


            let country = document.getElementById("country").value;
            let address = document.getElementById("address").value;
            let terms = document.getElementById("agree").checked;

            // Validate fields before doing anything else
            if (country === "" || address === "" || !terms) {
                return;
            }

            document.getElementById('submit-btn').disabled = true;

            const {
                error,
                paymentMethod
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                document.getElementById('submit-btn').disabled = false;
            } else {
                // console.log("Payment Method:", paymentMethod);

                // Send to backend for storage/charging later
                fetch("/onboarding/validatePayment", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            payment_method: paymentMethod.id,
                            country: country,
                            address: address
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "{{ route('onboarding.paymentValidated') }}";
                        } else {
                            document.getElementById('submit-btn').disabled = false;
                            Swal.fire({
                                icon: "error",
                                title: "Payment Method Failed",
                                text: "We could not process your card. Please try again.",
                                confirmButtonColor: "#001f8e"
                            });
                        }

                    });
            }
        });
    </script>

</body>

</html>
