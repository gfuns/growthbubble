<nav class="navbar-default navbar navbar-expand-lg">
    <a id="nav-toggle" href="#">
        <i class="fe fe-menu"></i>
    </a>
    <!--Navbar nav -->
    <div class="ms-auto d-flex">
        <a href="#" class="form-check form-switch theme-switch btn btn-light btn-icon rounded-circle ">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
        </a>
    <ul class="navbar-nav navbar-right-wrap ms-2 d-flex nav-top-wrap">

        <!-- List -->
        <li class="dropdown ms-2">
            <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar avatar-md avatar-indicators avatar-online">
                    <img alt="avatar" src="{{ Auth::user()->photo == null ? asset('assets/images/avatar/avatar.webp') : Auth::user()->photo }}" class="rounded-circle" >
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <div class="dropdown-item">
                    <div class="d-flex">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            <img alt="avatar" src="{{ Auth::user()->photo == null ? asset('assets/images/avatar/avatar.webp') : Auth::user()->photo }}" class="rounded-circle" >
                        </div>
                        <div class="ms-3 lh-1">
                            <h5 class="mb-1">{{ Auth::user()->first_name." ". Auth::user()->last_name }}</h5>
                            <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <ul class="list-unstyled">

                    <li>
                        <a class="dropdown-item" href="{{ route("profile") }}">
                            <i class="fe fe-user me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route("changePassword") }}">
                            <i class="fe fe-lock me-2"></i> Change Password
                        </a>
                    </li>
                </ul>
                <div class="dropdown-divider"></div>
                <ul class="list-unstyled">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="fe fe-power me-2"></i> Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    </div>
</nav>
