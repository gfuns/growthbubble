<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <h3 class="fw-bold"><img src="{{ asset('images/logo.png') }}?version={{ date("his") }}" alt=""
                    style="filter: brightness(0) invert(1); width: 150px; height: 35px">
            </h3>
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">

            <li class="nav-item">
                <a class="nav-link " id="dashboard" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fe fe-home me-2"></i>
                    Dashboard
                </a>
            </li>


            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 3) == true)

                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navCRM"
                        aria-expanded="false" aria-controls="navCRM">
                        <i class="nav-icon fe fe-users me-2"></i> CRM
                    </a>
                    <div id="navCRM" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">

                            <li class="nav-item">
                                <a class="nav-link " id="customers" href="{{ route('admin.customers') }}">
                                    Clients
                                </a>
                            </li>


                            @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 3) == true)
                                <li class="nav-item">
                                    <a class="nav-link " id="newClient" href="{{ route('admin.newCustomer') }}">
                                        New Client
                                    </a>
                                </li>
                            @endif


                        </ul>
                    </div>
                </li>
            @endif

            @foreach (app('product')->products() as $prod)
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

                            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 4) == true)
                                <li class="nav-item">
                                    <a class="nav-link " id="projects{{ $prod->id }}"
                                        href="{{ route('admin.customerProjects', [$prod->id]) }}">
                                        Projects
                                    </a>
                                </li>
                            @endif

                            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 5) == true)
                                <li class="nav-item">
                                    <a class="nav-link " id="tasks{{ $prod->id }}"
                                        href="{{ route('admin.customerTasks', [$prod->id]) }}">
                                        Tasks
                                    </a>
                                </li>
                            @endif

                            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 1) == true)
                                <li class="nav-item">
                                    <a class="nav-link " id="categories{{ $prod->id }}"
                                        href="{{ route('admin.taskCategories', [$prod->id]) }}">
                                        Task Categories
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endforeach

            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 8) == true)
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
                                <a class="nav-link " id="myFiles" href="{{ route('admin.myFiles') }}">
                                    My Files
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="sharedFiles" href="{{ route('admin.sharedFiles') }}">
                                    Shared With Me
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif


            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 7) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " id="tickets" href="{{ route('admin.customerTickets') }}">
                        <i class="nav-icon fe fe-file-text me-2"></i>
                        Support Tickets
                    </a>
                </li>
            @endif


            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 6) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#navAdmin" aria-expanded="false" aria-controls="navAdmin">
                        <i class="nav-icon fe fe-dollar-sign me-2"></i> Admin
                    </a>
                    <div id="navAdmin" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">


                            <li class="nav-item">
                                <a class="nav-link " id="payments" href="{{ route('admin.payments') }}">
                                    Payments
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="subscriptions" href="{{ route('admin.subscriptions') }}">
                                    Subscriptions
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 1) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#navTeam" aria-expanded="false" aria-controls="navTeam">
                        <i class="nav-icon fe fe-user-check me-2"></i> Team
                    </a>
                    <div id="navTeam" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">


                            <li class="nav-item">
                                <a class="nav-link " id="staff" href="{{ route('admin.staffManagement') }}">
                                    Staff
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="roles" href="{{ route('admin.userRoles') }}">
                                    Roles
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif


            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 1) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#platSettings" aria-expanded="false" aria-controls="platSettings">
                        <i class="nav-icon bi bi-tools me-2"></i> Settings
                    </a>
                    <div id="platSettings" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">


                            <li class="nav-item">
                                <a class="nav-link " id="features" href="{{ route('admin.platformFeatures') }}">
                                    Platform Features
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="product" href="{{ route('admin.productManagement') }}">
                                    Products
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="plans" href="{{ route('admin.productPlans') }}">
                                    Plans
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif


        </ul>
        <!-- Card -->

    </div>
</nav>
