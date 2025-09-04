<nav class="navbar-default navbar navbar-expand-lg">
    <a id="nav-toggle" href="#">
        <i class="fe fe-menu"></i>
    </a>
    <div class="ms-3 mt-1">
        <!-- Form -->
        <a href="https://growthbubbles.com" data-bs-toggle="tooltip" data-placement="right" title="Visit Main Website" target="_blank">
            <i class="fe fe-globe" style="font-size: 24px; color: var(--geeks-gray-700);"></i>
        </a>
    </div>
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
                            <h5 class="mb-1">{{ Auth::user()->last_name." ". Auth::user()->other_names}}</h5>
                            <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <ul class="list-unstyled">

                    <li>
                        <a class="dropdown-item" href="{{ route("admin.viewProfile") }}">
                            <i class="fe fe-user me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route("admin.security") }}">
                            <i class="fe fe-lock me-2"></i> Security
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
