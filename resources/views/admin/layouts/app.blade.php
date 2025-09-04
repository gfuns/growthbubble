<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->

            @include('admin.layouts.nav')

        <!-- Page Content -->
        <main id="page-content">
            <div class="header">
                @include('admin.layouts.topbar')
            </div>
            <!-- Container fluid -->

            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    @include('admin.layouts.footer')

    @yield('customjs')



</body>

</html>
