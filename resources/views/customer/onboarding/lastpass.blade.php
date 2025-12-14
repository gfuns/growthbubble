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

    /* Mobile only */
    @media (max-width: 767px) {
        .onboarding-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            /* smooth iOS scrolling */
        }

        .onboardingSteps {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            padding: 0;
            margin: 0;
        }

        .onboardingSteps li {
            list-style: none;
            flex: 1;
            text-align: center;
            padding: 8px;
            margin: 10px;
            border-radius: 6px;
            font-size: 12px;
        }

        .onboardingSteps li a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
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
                    <div class="row g-3">
                        <div class="col-12 col-md-3">
                            <div class="card">
                                <div class="kycinstruction">
                                    <ul class="onboardingSteps onboarding-scroll">
                                        <li class="@if (Auth::user()->onbInst()) completed @endif">
                                            <a href="{{ route('onboarding.instructions') }}">Instructions</a>
                                        </li>
                                        <li class="@if (Auth::user()->website(1)) completed @endif">
                                            <a href="{{ route('onboarding.websites') }}">Website(s)</a>
                                        </li>
                                        <li class="active @if (Auth::user()->lastpass()) completed @endif">
                                            <a href="{{ route('onboarding.lastpass') }}">Passwords</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 card mb-4 p-6 pt-3 text-dark">
                            <h4 class="text-dark mb-3"><strong>Secure Password Sharing</strong></h4>

                            <div class="mb-3">We use LastPass to manage client password to ensure enhanced security.
                                LastPass keeps your passwords safe and encrypted, while still allowing us to access them
                                quickly to complete our tasks.</div>

                            <div class="mb-2"><strong>Sharing Your password with LastPass</strong></div>

                            <div class="mb-2">Here's how to easily share your password with us securely through
                                LastPass:</div>

                            <ol>
                                <li>Click here to to visit <a href="https://www.LastPass.com"
                                        target="_blank">www.LastPass.com</a>.
                                </li>
                                <li>Follow the on-screen instructions to create a secure LastPass account (if you don't
                                    have
                                    one already).</li>
                                <li>Once logged in, use LastPass to securely share the relevant password with <a
                                        href="#">concierge@growthbubbles.com</a>.</li>
                            </ol>

                            <div class="mb-2"><strong>For New LastPass Users</strong></div>

                            <div class="mb-2">We have prepared a helpful guide on sharing passwords through
                                LastPass <a href="https://www.LastPass.com" target="_blank">here.</a></div>

                            <div class="mb-2">After successfully sharing your password through LastPass, please
                                click the "Complete Onboarding" button below so we can get started on your tasks.</div>

                            <div class="mb-2"><strong>Benefits of using LastPass</strong></div>
                            <ul>
                                <li><b>Enhanced Security:</b> Your passwords are encrypted and stored securely with
                                    LastPass.
                                </li>
                                <li><b>Convenience:</b> We can access your password quickly and efficiently. Also when
                                    you
                                    change your password, you can let us know by simply updating the password on
                                    LastPass.
                                </li>
                                <li><b>Peace of Mind:</b> You can relax knowing that your password is safe and
                                    protected.
                                </li>
                            </ul>

                            <div>Feeling stuck? Raise a <span data-bs-toggle="modal" data-bs-target="#newTicket"
                                    style="cursor: pointer; color:blue">support
                                    ticket</span> to get help with this step. </div>


                            <div class="mt-5">
                                <form method="POST" action="{{ route('onboarding.completeOnboarding') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-block w-100">Complete Onboarding
                                        &nbsp;<i class="fas fa-chevron-circle-right"></i></button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="newTicket" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    Submit New Ticket.
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="needs-validation" novalidate method="post" action="{{ route('customer.submitTicket') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->

                        <div class="mb-3 col-12">
                            <!-- Title -->
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" id="" class="form-control text-dark"
                                placeholder="Subject">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <!-- Title -->
                            <label class="form-label d-block">Priority</label>
                            <select id="priority" name="priority" class="form-select" style="width: 100%">
                                <option value="">Priority</option>
                                <option value="High">High </option>
                                <option value="Medium">Medium </option>
                                <option value="Low">Low </option>
                            </select>
                            <div class="invalid-feedback">Please select an option.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Description </label>
                            <div id="editor" style="height: 200px">
                                <p>&nbsp;</p>
                            </div>
                            <input type="hidden" name="description" id="hiddenContent">
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Attach Files</label>
                            <input type="file" name="attached_files" id=""
                                class="form-control text-dark" placeholder="Attached Files">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button id="submitbutton2" class="btn btn-success" type="submit">Submit Ticket</button>
                            <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("onboarding").classList.add('active');
</script>

@endsection

@section('customjs')
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    quill.on('text-change', function() {
        document.getElementById('hiddenContent').value = quill.root.innerHTML;
    });
</script>
@endsection
