@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Billing Information')


<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-md-flex align-items-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <h1 class="mb-1 h2 fw-bold">Billing Information</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Billing Information
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
    <div class="row">
        <div class="col-xl-6 col-12 mb-4 mb-xl-0">
            <!-- card  -->
            <div class="card">
                <div class="card-header p-2">
                    <div class="ms-2 text-dark fw-bold">Details Of Selected Plan</div>
                </div>
                <!-- card body -->
                <div class="card-body">
                    <!-- list -->
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-dark">Selected Product</span>
                            <span class="text-dark fw-medium">{{ $plan->product->product }}</span>
                        </li>
                        <li class="d-flex justify-content-between mt-4 mb-2">
                            <span class="text-dark">Selected Plan</span>
                            <span class="text-dark fw-medium">{{ $plan->plan->plan }} Plan</span>
                        </li>
                        <li class="d-flex justify-content-between mt-4 mb-2">
                            <span class="text-dark">Pricing</span>
                            <span class="text-dark fw-medium">&#8358;{{ number_format($plan->pricing, 2) }}</span>
                        </li>
                        <li class="d-flex justify-content-between mt-4 mb-2">
                            <span class="text-dark">Effective Date</span>
                            <span
                                class="text-dark fw-medium">{{ date_format(new DateTime($plan->effective_date), 'jS F, Y') }}</span>
                        </li>
                        <li class="d-flex justify-content-between mt-4 mb-2">
                            <span class="text-dark">Expiration Date</span>
                            <span
                                class="text-dark fw-medium">{{ date_format(new DateTime($plan->expiry_date), 'jS F, Y') }}</span>
                        </li>

                        <hr class="mt-4 my-3">
                        <p class="text-dark"><b>Note:</b> On Expiration of your Subscription, all services and features
                            would
                            be suspended after 2 days of expiration till renewal of plan. We advice enabling the
                            Auto Renewal option to avoid a break in service.</p>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <!-- card  -->
            <div class="card">
                <!-- card body -->
                <div class="card-header p-2 d-flex align-items-center">
                    <div class="ms-2 text-dark fw-bold">Payment Method</div>

                    <div class="ms-auto">
                        <a href="#" class="btn btn-xs btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#paymentModal">Add Payment Method</a>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($customerCards as $card)
                        <div class="row pb-3 mb-3 border-bottom">
                            <div class="col-md-2 col-2">
                                <img src="{{ asset('assets/images/creditcard/' . $card->card_brand . '.svg') }}"
                                    alt="" class="mb-2 mt-2">
                            </div>
                            <div class="col-md-7 col-6">
                                <!-- text -->
                                <p class="mb-0 text-dark">Ending with {{ $card->last_four_digits }}</p>
                                <p class="mb-0">Expires {{ $card->expiry_month }}/{{ $card->expiry_year }}</p>
                            </div>
                            <div class="col-md-3 col-4">
                                <a href="{{ route('business.processSubscription', [$plan->id, $card->id]) }}"
                                    onClick="this.disabled=true; this.innerHTML='Processing...';"><button
                                        class="btn btn-primary btn-xs">Pay Now</button></a>
                            </div>
                        </div>
                    @endforeach

                    @if (count($customerCards) < 1)
                        <div class="col-xl-12 col-12 job-items job-empty">
                            <div class="text-center mt-4"><i class="bi bi-emoji-frown" style="font-size: 48px"></i>
                                <h3 class="mt-2">No Record Found</h3>
                                <div class="mt-2 text-muted"> There are no payment methods found.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header align-items-center d-flex">
                    <h4 class="modal-title" id="paymentModalLabel">Add New Payment Method</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <!-- Form -->
                        <form method="POST" action="{{ route('customer.initiateCardAddition') }}"
                            class="row mb-4 needs-validation" novalidate>
                            @csrf
                            <div class="mb-3 col-12 col-md-12 mb-4">
                                <h4 class="mb-3">Instructions</h4>
                                <!-- Radio button -->
                                <div class="" style="text-align: justify">
                                    <p>As part of our platform security policy, we do not directly store customer cards
                                        on our infrastructure. We partner with <a href="https://stripe.com"
                                            target="_blank"><strong>Stripe</strong></a> our payment solution provider
                                        to handle and manage customer card information.</p>

                                    <p>We will be redirecting you to stripe payment page where you would be providing
                                        and validating your card by performing a small transaction of &pound;1.</p>

                                    <p>Upon the validation transaction is successful and confirmed for your card, your
                                        card will be successfully added as a payment method to your account for future
                                        transactions. </p>
                                </div>
                            </div>

                            <span class="mb-4">
                                <strong>Note:</strong>
                                You can later remove your card from being used for billing and payments.
                            </span>
                            <!-- Button -->
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Add New Card</button>
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
    document.getElementById("billing").classList.add('active');
</script>

@endsection
