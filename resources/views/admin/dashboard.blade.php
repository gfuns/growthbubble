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
            <div class="col-lg-4 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-6 text-dark text-uppercase fw-bold">Projects In Progress</div>
                            <div class="fs-6 text-dark fw-bold">0/5</div>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-6 text-dark text-uppercase fw-bold">Queued Tasks</div>
                            <div class="fs-6 text-dark fw-bold">0/5</div>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-6 text-dark text-uppercase fw-bold">Completed Tasks</div>
                            <div class="fs-6 text-dark fw-bold">0/5</div>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
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
                <div class="card mb-4 h-100">
                    <!-- Card header -->
                        <div class="card-header p-0">
                            <div>
                                <!-- Nav -->
                                <ul class="nav nav-lb-tab border-bottom-0" id="tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-dark fw-bold active" href="" role="tab"><i></i> My Tasks</a>
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
                <div class="card mb-4 h-100">
                    <div class="card-header p-2">
                        <div class="ms-2 text-dark fw-bold">Statistics By Project Status</div>
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

@include('admin.layouts.chart')

@endsection
