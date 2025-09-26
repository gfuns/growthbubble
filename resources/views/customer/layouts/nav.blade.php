<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <h3 class="fw-bold"><img src="{{ asset('images/logo.png') }}" alt=""
                    style="filter: brightness(0) invert(1);"> <span style="color: white; margin-left: 15px">Growth
                    Bubble</span>
            </h3>
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">

            <li class="nav-item">
                <a class="nav-link " id="dashboard" href="{{ route('customer.dashboard') }}">
                    <i class="nav-icon fe fe-home me-2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="projects" href="{{ route('customer.projects') }}">
                    <i class="nav-icon fe fe-briefcase me-2"></i>
                    My Projects
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="tasks" href="{{ route('customer.tasks') }}">
                    <i class="nav-icon fe fe-check-circle me-2"></i>
                    My Tasks
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="subscriptions" href="{{ route('customer.subscriptions') }}">
                    <i class="nav-icon fe fe-dollar-sign me-2"></i>
                    Payment History
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="websites" href="{{ route('customer.submittedWebsites') }}">
                    <i class="nav-icon fe fe-globe me-2"></i>
                    Submitted Webistes
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="tickets" href="{{ route('customer.tickets') }}">
                    <i class="nav-icon fe fe-file-text me-2"></i>
                    Tickets
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navSettings"
                    aria-expanded="false" aria-controls="navSettings">
                    <i class="nav-icon bi bi-gear-wide-connected me-2"></i> Account Settings
                </a>
                <div id="navSettings" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link " id="profile" href="{{ route('customer.viewProfile') }}">
                                Profile Information
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="billing" href="{{ route('customer.billing') }}">
                                Billing Information
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="security" href="{{ route('customer.security') }}">
                                Account Security
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="nav-icon fe fe-log-out me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
        <!-- Card -->

    </div>
</nav>
