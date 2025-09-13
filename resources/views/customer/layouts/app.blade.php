<!DOCTYPE html>
<html lang="en">
@include('customer.layouts.header')

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->

            @include('customer.layouts.nav')

        <!-- Page Content -->
        <main id="page-content">
            <div class="header">
                @include('customer.layouts.topbar')
            </div>
            <!-- Container fluid -->

            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    @include('customer.layouts.footer')

    @yield('customjs')



</body>

</html>
