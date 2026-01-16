<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
            <h3 class="fw-bold"><img src="{{ asset('images/logo.png') }}" alt=""
                    style="filter: brightness(0) invert(1); width: 150px; height: 35px"">
            </h3>
        </a>
        <div class="mb-4" style="text-align: center">
            <a href="{{ route('customer.newCustomerTask', [Auth::user()->product_id]) }}">
                <button class="btn btn-info btn-md"><i class="bi bi-plus-circle"></i> Create New Task</button>
            </a>
        </div>
        <hr />
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">

            <li class="nav-item">
                <a class="nav-link " id="dashboard" href="{{ route('customer.dashboard') }}">
                    <i class="nav-icon fe fe-home me-2"></i>
                    Dashboard
                </a>
            </li>

            @if (Auth::user()->onboarding_status != 'onboarded')
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " id="onboarding" href="{{ route('onboarding.instructions') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-walking" viewBox="0 0 16 16">
                            <path
                                d="M9.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M6.44 3.752A.75.75 0 0 1 7 3.5h1.445c.742 0 1.32.643 1.243 1.38l-.43 4.083a1.8 1.8 0 0 1-.088.395l-.318.906.213.242a.8.8 0 0 1 .114.175l2 4.25a.75.75 0 1 1-1.357.638l-1.956-4.154-1.68-1.921A.75.75 0 0 1 6 8.96l.138-2.613-.435.489-.464 2.786a.75.75 0 1 1-1.48-.246l.5-3a.75.75 0 0 1 .18-.375l2-2.25Z" />
                            <path
                                d="M6.25 11.745v-1.418l1.204 1.375.261.524a.8.8 0 0 1-.12.231l-2.5 3.25a.75.75 0 1 1-1.19-.914zm4.22-4.215-.494-.494.205-1.843.006-.067 1.124 1.124h1.44a.75.75 0 0 1 0 1.5H11a.75.75 0 0 1-.531-.22Z" />
                        </svg>
                        {{-- <i class="nav-icon bi bi-person-walking me-2"></i> --}}
                        &nbsp;Onboarding
                    </a>
                </li>
            @endif

            @foreach (app('product')->products() as $prod)
                @if (Auth::user()->product_id == $prod->id)
                    <li class="nav-item">
                        <div class="nav-divider"></div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse"
                            data-bs-target="#navProduct{{ $prod->id }}" aria-expanded="false"
                            aria-controls="navProduct{{ $prod->id }}">
                            <i class="nav-icon bi bi-briefcase me-2"></i> {{ $prod->product }}
                        </a>
                        <div id="navProduct{{ $prod->id }}" class="collapse " data-bs-parent="#sideNavbar">
                            <ul class="nav flex-column">

                                <li class="nav-item">
                                    <a class="nav-link " id="projects{{ $prod->id }}"
                                        href="{{ route('customer.projects', [$prod->id]) }}">
                                        Projects
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " id="tasks{{ $prod->id }}"
                                        href="{{ route('customer.tasks', [$prod->id]) }}">
                                        Tasks
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navSettings"
                    aria-expanded="false" aria-controls="navSettings">
                    <i class="nav-icon bi bi-person-bounding-box me-2"></i> Account
                </a>
                <div id="navSettings" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link " id="billing" href="{{ route('customer.billing') }}">
                                Billing
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="websites" href="{{ route('customer.submittedWebsites') }}">
                                Websites
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="payments" href="{{ route('customer.payments') }}">
                                Payments
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="subscriptions" href="{{ route('customer.subscriptions') }}">
                                Subscriptions
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navFolder"
                    aria-expanded="false" aria-controls="navFolder">
                    <i class="nav-icon bi bi-folder me-2"></i> Files
                </a>
                <div id="navFolder" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link " id="myFiles" href="{{ route('customer.myFiles') }}">
                                My Files
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="sharedFiles" href="{{ route('customer.sharedFiles') }}">
                                Shared With Me
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="tickets" href="{{ route('customer.tickets') }}">
                    <i class="nav-icon bi bi-headset me-2"></i>
                    Support Tickets
                </a>
            </li>


            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="tickets" target="_blank" href="https://help.growthbubbles.com/">
                    <i class="nav-icon fe fe-file-text me-2"></i>
                    Help Docs
                </a>
            </li>
        </ul>
        <!-- Card -->

    </div>
</nav>
