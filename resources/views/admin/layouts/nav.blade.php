
<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <h3 class="fw-bold"><img src="{{ asset('images/logo.png') }}" alt="" style="filter: brightness(0) invert(1);"> <span
                    style="color: white; margin-left: 15px">Growth Bubble</span>
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

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

             <li class="nav-item">
                <a class="nav-link " id="dashboard" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fe fe-users me-2"></i>
                    Registered Customers
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

             <li class="nav-item">
                <a class="nav-link " id="dashboard" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fe fe-briefcase me-2"></i>
                    Project Management
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

             <li class="nav-item">
                <a class="nav-link " id="dashboard" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fe fe-check-circle me-2"></i>
                    Task Management
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

             <li class="nav-item">
                <a class="nav-link " id="staff" href="{{ route('admin.staffManagement') }}">
                    <i class="nav-icon fe fe-user-check me-2"></i>
                    Staff Management
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#platSettings"
                    aria-expanded="false" aria-controls="platSettings">
                    <i class="nav-icon bi bi-tools me-2"></i> Platform Configurations
                </a>
                <div id="platSettings" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">


                        <li class="nav-item">
                            <a class="nav-link " id="features" href="{{ route('admin.platformFeatures') }}">
                                Platform Features
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="roles" href="{{ route('admin.userRoles') }}">
                                Roles and Permissions
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="product" href="{{ route('admin.productManagement') }}">
                                Product Management
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="plans" href="{{ route('admin.productPlans') }}">
                                Product Plans
                            </a>
                        </li>

                    </ul>
                </div>
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
                            <a class="nav-link " id="profile" href="{{ route('admin.viewProfile') }}">
                                Profile Information
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="security" href="{{ route('admin.security') }}">
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
