<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->

            @include('layouts.nav')

        <!-- Page Content -->
        <main id="page-content">
            <div class="header">
                @include('layouts.topbar')
            </div>
            <!-- Container fluid -->

            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    @include('layouts.footer')

    @yield('customjs')



</body>

</html>
