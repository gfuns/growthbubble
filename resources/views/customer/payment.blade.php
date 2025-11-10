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

    <script src="https://js.stripe.com/v3/"></script>

    <title>Stripe Payment Gateway | {{ env('APP_NAME') }}</title>


    <style type="text/css">
        [data-theme="dark"] ::placeholder {
            color: white;
        }

        #card-errors {
            display: none;
            /* color: #b02a37;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            margin-top: 10px;
            border-color: #f1aeb5;
            background-color: #f8d7da; */
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
                                    <h2 class="mt-2 mb-1 fw-bold">Add Payment Method</h2>
                                    <small class="text-black" style="font-weight: bolder;">LET US KNOW HOW TO BILL
                                        YOU</small>
                                </div>
                            </div>
                            <p class="text-black">Hello
                                <strong>{{ Auth::user()->last_name . ' ' . Auth::user()->other_names }}</strong>,
                                <br>Please enter your card details in the input field provided below.
                            </p>
                            <div class="alert alert-danger" id="card-errors" role="alert"></div>

                            {{-- @if (Session::has('error'))
                                <div class="alert alert-danger">Invalid Google 2FA Code.</div>
                            @endif --}}
                            <!-- Form -->
                            <form id="payment-form">
                                <!-- Username -->
                                <div class="mb-3">
                                    <div class="form-control" id="card-element"></div>
                                </div>

                                <div>
                                    <!-- Button -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary" id="submit-btn">Add Payment
                                            Method</button>
                                    </div>
                                </div>

                                <p class="mt-3 text-dark"><u><b>Note:</b></u> This payment method will be automatically
                                    charged for your billing transactions.</p>

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
                fetch("/portal/customer/savePaymentMethod", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            payment_method: paymentMethod.id
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        window.location.href = "{{ route('customer.pmSuccess') }}";
                        // alert("Payment method saved successfully!");
                        // document.getElementById('submit-btn').disabled = false;
                    });
            }
        });
    </script>

</body>

</html>
