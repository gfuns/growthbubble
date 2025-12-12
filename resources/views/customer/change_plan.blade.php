@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Change Subscription Plan')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Change Subscription Plan
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Account</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Change Subscription Plan
                            </li>
                        </ol>
                    </nav>
                </div>


            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-lg-4 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="mb-4 lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md text-center">
                                {{ $plan->plan . ' ' . $plan->frequency }}</h4>
                            <h4 class="fs-5 text-uppercase fw-bold ls-md text-center">
                                &pound;{{ number_format($plan->pricing, 2) }}</h4>
                        </div>
                        <hr />
                        <ul style="list-style: none">
                            @foreach ($plan->features as $feat)
                                <li class="mb-2">{{ $feat->feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <hr />
                    <button class="btn btn-primary btn-sm m-3" data-bs-toggle="modal" data-bs-target="#changePlan"
                        data-myid="{{ $plan->id }}">Get This Plan</button>
                </div>
            </div>
        @endforeach
    </div>


</section>

<div class="modal fade" id="changePlan" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    Change Subscription Plan
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('customer.switchPlan') }}">
                @csrf
                <div class="modal-body">

                    <h4>Are you sure you want to get this plan?</h4>
                    <h5>Your card details will be charged immediately and the
                        new plan will be applied to your account. </h5>

                    <input type="hidden" id="myid" name="plan" />

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success ms-2">Accept</button>
                    <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal">Decline</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("navSettings").classList.add('show');
    document.getElementById("subscriptions").classList.add('active');
</script>

@endsection
