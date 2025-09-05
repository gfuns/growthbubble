@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Business Dashboard')
<style type="text/css">
    .candidate-education-content .circle {
        border-radius: 40px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        width: 35px;
    }

    .bg-soft-primary {
        background-color: rgba(118, 109, 244, .15) !important;
        color: #766df4 !important;
    }

    .bg-soft-success {
        background-color: #d1f5ea !important;
        color: #20c997 !important;
    }

    .bg-soft-danger {
        background-color: #fad9d8 !important;
        color: #dc3545 !important;
    }
</style>

<!-- Page Header -->
<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex justify-content-between align-items-center">
                <div class="mb-3 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold">Administrative Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Active Tasks</h4>
                            <div>
                                <span class="bi bi-lightbulb fs-3 text-primary"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Queued Tasks</h4>
                            <div>
                                <span class="bi bi-list-ol fs-3 text-primary"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Recurring Tasks</h4>
                            <div>
                                <span class="bi bi-arrow-clockwise fs-3 text-primary"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Completed Tasks</h4>
                            <div>
                                <span class="bi bi-check2-circle fs-3 text-primary"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1">0</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12">
        <!-- Card -->

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <!-- Card -->
                <div class="card h-75 mb-4">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <!-- Card header -->

                            <div class="card-header border-bottom-0 p-0">
                                <ul class="nav nav-lb-tab" id="tab" role="tablist">
                                    @foreach ($products as $prod)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-dark fw-bold @if ($loop->first) active @endif"
                                                id="{{ $prod->id }}-tab" data-bs-toggle="pill"
                                                href="#product{{ $prod->id }}" role="tab"
                                                aria-controls="product{{ $prod->id }}"
                                                aria-selected="true">{{ $prod->product }} Customers</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                            <div>
                                <!-- Table -->
                                <div class="tab-content" id="tabContent">
                                    @foreach ($products as $prod)
                                        <div class="tab-pane fade @if ($loop->first) active show @endif"
                                            id="product{{ $prod->id }}" role="tabpanel"
                                            aria-labelledby="tab-{{ $prod->id }}">
                                            <!-- Table -->
                                            <div class="table-responsive">
                                                <table id="prodTable{{ $prod->id }}" class="table mb-0 table-hover"
                                                    style="font-size: 13px">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Priority</th>
                                                            <th>Start Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <td>1</td>
                                                        <td>Test Task</td>
                                                        <td>High</td>
                                                        <td>Start Date</td>
                                                        <td>Status</td>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 h-75">
                    <!-- Card header -->
                    <div class="card-header p-0">
                        <div>
                            <!-- Nav -->
                            <ul class="nav nav-lb-tab border-bottom-0" id="tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-dark fw-bold active" href="" role="tab"><i></i>
                                        My Tasks</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-dark fw-bold" href="" role="tab">My Projects</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-dark fw-bold" href="" role="tab">My Reminders</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="">

                        <!-- Table -->
                        <div class="tab-content" id="tabContent">
                            <!--Tab pane -->
                            <div class="tab-pane fade active show" id="courses" role="tabpanel"
                                aria-labelledby="courses-tab">
                                <!-- Card header -->

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table id="myTasks" class="table mb-0 table-hover" style="font-size: 13px">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Priority</th>
                                                <th>Start Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>1</td>
                                            <td>Test Task</td>
                                            <td>High</td>
                                            <td>Start Date</td>
                                            <td>Status</td>

                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="card mb-4 h-75">
                    <div class="card-header p-2">
                        <div class="ms-2 text-dark fw-bold">Statistics By Project Status</div>
                    </div>
                    <div id="" class="card-body">
                        <!-- Earning chart -->
                        <div id="traffic" class="apex-charts d-flex justify-content-center"></div>
                        {{-- <canvas id="myLineChart" height="445"></canvas> --}}
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header p-2">
                        <div class="ms-2 text-dark fw-bold">Latest Activities</div>
                    </div>
                    <div id="" class="card-body">
                        <!-- Earning chart -->
                        <div id="traffic" class="apex-charts d-flex justify-content-center"></div>
                        {{-- <canvas id="myLineChart" height="445"></canvas> --}}
                    </div>
                </div>
            </div>





        </div>
    </div>


</section>

<script>
    document.getElementById("dashboard").classList.add('active');
</script>

{{-- @include('admin.layouts.chart') --}}

@endsection
