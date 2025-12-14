@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Staff Dashboard')
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
                    <h1 class="mb-0 h3 fw-bold">Dashboard</h1>
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
                    <a href="{{ route('admin.customerTasks', [1]) }}">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Assigned Tasks</h4>
                                <div>
                                    <span class="bi bi-list-ol fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['assignedTasks'], 0) }}</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route('admin.customerTasks', [1]) }}?status=in progress">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Ongoing Tasks</h4>
                                <div>
                                    <span class="bi bi-lightbulb fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['activeTasks'], 0) }}</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route('admin.customerTasks', [1]) }}?recurring=yes">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Recurring Tasks</h4>
                                <div>
                                    <span class="bi bi-arrow-clockwise fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['recurringTasks'], 0) }}</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route('admin.customerTasks', [1]) }}?status=completed">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Completed Tasks</h4>
                                <div>
                                    <span class="bi bi-check2-circle fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['completedTasks'], 0) }}</h4>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12 mb-5">
        <!-- Card -->

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <!-- Card -->

                <div class="card mb-4" style="height: 400px">
                    <!-- Card header -->
                    <div class="card-header p-0">
                        <div>
                            <!-- Nav -->
                            <ul class="nav nav-lb-tab border-bottom-0" id="tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-dark fw-bold active" role="tab"><i></i>
                                        Assigned Tasks</a>
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
                                                <th>Timestamp</th>
                                                <th>Task</th>
                                                <th>Client</th>
                                                <th>Priority</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $tsk)
                                                <tr class="text-dark">
                                                    <td>{{ date_format($tsk->created_at, "jS M, Y g:ia") }}</td>
                                                    <td class="no-wrap">
                                                        <a href="{{ route('admin.taskDetails', [$tsk->id]) }}"
                                                            class="text-dark">{{ Str::limit($tsk->title, 30) }}
                                                        </a>
                                                    </td>
                                                    <td class="no-wrap">
                                                        {{ Str::limit($tsk->user->organization, 25) }}
                                                    </td>
                                                    <td>{{ ucwords($tsk->priority) }}</td>
                                                    <td>
                                                        @if ($tsk->status == 'queued' || $tsk->status == 'on hold')
                                                            <span
                                                                class="badge text-primary bg-light-primary">{{ ucwords($tsk->status) }}</span>
                                                        @elseif ($tsk->status == 'in progress')
                                                            <span
                                                                class="badge text-warning bg-light-warning">{{ ucwords($tsk->status) }}</span>
                                                        @elseif ($tsk->status == 'completed')
                                                            <span
                                                                class="badge text-success bg-light-success">{{ ucwords($tsk->status) }}</span>
                                                        @elseif ($tsk->status == 'cancelled')
                                                            <span
                                                                class="badge text-danger bg-light-danger">{{ ucwords($tsk->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="card mb-4" style="height: 400px;">
                    <div class="card-header p-2">
                        <div class="ms-2 text-dark fw-bold">Statistics By Project Status</div>
                    </div>
                    <div id="" class="card-body">
                        <!-- Earning chart -->
                        <div id="staffChart" class="apex-charts d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="viewActivity" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <p id="activity"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success ms-2"
                        data-bs-dismiss="modal">Close</button>
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
