@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Customer Onboarding')

<style>
    .kycinstruction {
        height: 30%;
    }

    .onboardingSteps {
        list-style: none;
        /* remove bullets */
        padding: 0;
        margin: 0;
    }

    .onboardingSteps li {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        margin-bottom: 8px;
        /* border-radius: 8px; */
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        position: relative;
    }

    .onboardingSteps li a,
    .onboardingSteps li a:hover,
    .onboardingSteps li a:focus {
        text-decoration: none;
        color: inherit;
    }

    /* Circle (radio-style) */
    .onboardingSteps li::before {
        content: "";
        width: 18px;
        height: 18px;
        border: 3px solid #000;
        /* circle border */
        border-radius: 50%;
        margin-right: 12px;
        display: inline-block;
        background: #fff;
    }

    /* Active step */
    .onboardingSteps li.active {
        background: #f8f9fa;
        /* light gray highlight */
        border: 1px solid #ddd;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.05);
        font-weight: bold;
    }

    /* Completed Step */
    .onboardingSteps li.completed::before {
        background: green;
        border-color: green;
    }

    /* White checkmark inside the completed circle */
    .onboardingSteps li.completed::before {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 11px;
        font-weight: bold;
        content: "✓";
        /* checkmark */
    }
</style>
<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Onboarding
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Onboarding
                            </li>
                        </ol>
                    </nav>
                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">



            <!-- Tab -->
            <div class="tab-content">
                <!-- Tab pane -->

                <!-- tab pane -->
                <div class="tab-pane fade show active" id="tabPaneList" role="tabpanel" aria-labelledby="tabPaneList">
                    <!-- card -->
                    <div class="d-flex  justify-content-between gap-2">
                        <div class="card mb-4 col-md-3">
                            <div class="kycinstruction">
                                <ul class="onboardingSteps">
                                    <li class="active @if (Auth::user()->onbInst() == true) completed @endif"><a
                                            href="{{ route('onboarding.instructions') }}">Onboarding Instruction</a>
                                    </li>
                                    <li class="@if (Auth::user()->website(1) == true) completed @endif"><a
                                            href="{{ route('onboarding.websites') }}">Step 1 - Website Submission</a>
                                    </li>
                                    <li class="@if (Auth::user()->lastpass() == true) completed @endif"><a
                                            href="{{ route('onboarding.lastpass') }}">Step 2 - Share Password
                                            Securely</a></li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-md-9 card mb-4 p-6 pt-3 text-dark">
                            <h4 class="text-dark mb-3"><strong>Welcome Onboard
                                {{ Auth::user()->last_name . ' ' . Auth::user()->other_names }}</strong></h4>

                            <div class="mb-3">Now let's get you set up!</div>

                            <div class="mb-3">To effectively manage your marketing channels, tools and websites, we
                                need
                                secure access to
                                your
                                systems. This process is crucial because if we do not have the required access when you
                                submit a
                                task, our team will not be able to proceed.</div>

                            <div class="mb-2">By completing this process promptly, you'll enable us:</div>

                            <ul>
                                <li>Begin work without delays</li>
                                <li>Ensure our team can access all required systems and data</li>
                                <li>Maintain the security of your digital assets through our collaboration</li>
                                <li>Establish clear communication channels for technical implementation</li>
                            </ul>

                            <div class="mb-2"> The onboarding step comprise of two short steps:</div>

                            <ol>
                                <li> You let us know the systems/tools/website etc that we will be managing (you can
                                    always
                                    add
                                    and remove tools)</li>

                                <li> Instructions on how to share your password securely using LastPass</li>
                            </ol>

                            <div>Please note that incomplete access may hamper our ability to manage your marketing
                                systems
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('onboarding.websites') }}">
                                    <button type="button" class="btn btn-primary btn-block btn-md w-100">Proceed <i
                                            class="fas fa-chevron-circle-right"></i></button>
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    document.getElementById("onboarding").classList.add('active');
</script>

@endsection
