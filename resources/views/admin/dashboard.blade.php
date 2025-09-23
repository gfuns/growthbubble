@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Administrative Dashboard')
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
                    <a href="{{ route("admin.customerTasks") }}?status=in progress">
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
                    <a href="{{ route("admin.customerTasks") }}?status=queued">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Queued Tasks</h4>
                                <div>
                                    <span class="bi bi-list-ol fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['queuedTasks'], 0) }}</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route("admin.customerTasks") }}?recurring=yes">
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
                    <a href="{{ route("admin.customerTasks") }}?status=completed">
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
                                        <div class="tab-pane fade active @if ($loop->first) show @endif "
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
                                                            <th>Email</th>
                                                            <th>Phone Number</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $sno = 1;
                                                        @endphp
                                                        @foreach ($prod->customers as $cust)
                                                            <tr class="text-dark">
                                                                <td>{{ $sno++ }}.</td>
                                                                <td><a href="#" class="text-dark"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#viewCustomer"
                                                                        data-myid="{{ $cust->customer->id }}"
                                                                        data-othernames="{{ $cust->customer->other_names }}"
                                                                        data-lastname="{{ $cust->customer->last_name }}"
                                                                        data-email="{{ $cust->customer->email }}"
                                                                        data-phone="{{ $cust->customer->phone_number }}"
                                                                        data-organization="{{ $cust->customer->organization }}"
                                                                        data-photo="{{ $cust->customer->profile_photo }}"
                                                                        data-product="{{ $cust->customer->selectedProduct() }}"
                                                                        data-plan="{{ $cust->customer->selectedPlan() }}"
                                                                        data-effectivedate="{{ $cust->customer->effectiveDate() }}"
                                                                        data-expirydate="{{ $cust->customer->expiryDate() }}"
                                                                        data-status="{{ $cust->customer->subStatus() }}"
                                                                        data-address="{{ $cust->customer->contact_address ?? 'NIL' }}">
                                                                        {{ $cust->customer->last_name . ', ' . $cust->customer->other_names }}
                                                                    </a>
                                                                </td>
                                                                <td>{{ $cust->customer->email }}</td>
                                                                <td>{{ $cust->customer->phone_number }}</td>
                                                                <td>
                                                                    @if ($cust->customer->status == 'active')
                                                                        <span
                                                                            class="badge text-success bg-light-success">Active</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-danger bg-light-danger">Suspended</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
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

                <div class="card mb-4" style="height: 400px">
                    <!-- Card header -->
                    <div class="card-header p-0">
                        <div>
                            <!-- Nav -->
                            <ul class="nav nav-lb-tab border-bottom-0" id="tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link text-dark fw-bold active" role="tab"><i></i>
                                        Customer Tasks</a>
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
                                                <th>Task</th>
                                                <th>Client</th>
                                                <th>Priority</th>
                                                <th class="no-wrap">Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $tsk)
                                                <tr class="text-dark">
                                                    <td>{{ $loop->index + 1 }}.</td>
                                                    <td class="no-wrap">
                                                        <a href="{{ route('admin.taskDetails', [$tsk->id]) }}"
                                                            class="text-dark">
                                                            {{ $tsk->title }}
                                                        </a>
                                                    </td>
                                                    <td class="no-wrap">
                                                        {{ $tsk->user->last_name . ', ' . $tsk->user->other_names }}
                                                    </td>
                                                    <td>{{ ucwords($tsk->priority) }}</td>
                                                    <td>{{ $tsk->due_date ?? 'NIL' }}</td>
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
                        <div id="chart" class="apex-charts d-flex justify-content-center"></div>
                    </div>
                </div>

                <div class="card" style="height: 400px;">
                    <!-- Card header -->
                    <div class="card-header card-header-height d-flex align-items-center">
                        <h4 class="mb-0">Recent Activities</h4>
                    </div>
                    <!-- Card body -->
                    <div class="card-body scrollable-card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list-timeline-activity">
                            @foreach ($activities as $activity)
                                <li class="list-group-item px-0 pt-0 border-0 mb-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                                <img alt="avatar" src="{{ $activity->user->profile_photo }}"
                                                    class="rounded-circle">
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <div class="d-flex flex-column gap-1">
                                                <div>
                                                    <h4 class="mb-0 h5">
                                                        {{ $activity->user->last_name . ' ' . $activity->user->other_names }}
                                                    </h4>
                                                    <p class="mb-0">
                                                        @php
                                                            $plainText = strip_tags($activity->activity);
                                                            $comment = Str::limit(strip_tags($plainText), 80, '...');
                                                        @endphp

                                                        <a href="" data-bs-toggle="modal"
                                                            data-bs-target="#viewActivity"
                                                            data-activity="{{ $activity->user->last_name . ' ' . $activity->user->other_names . ' ' . $activity->activity }}"
                                                            class="text-dark">
                                                            @php
                                                                echo $comment;
                                                            @endphp
                                                        </a>
                                                    </p>
                                                </div>
                                                <div>
                                                    <span
                                                        class="fs-6">{{ $activity->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
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




    <div class="modal fade" id="viewCustomer" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        View Customer Information
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="">Last Name</td>
                                <td class=""><span id="vlastname"></span></td>
                                <td class="" rowspan="11" align="right" style="text-align: center"><img
                                        src="" id="vphoto" class="img-responsive"
                                        style="max-width: 150px" />
                                </td>
                            </tr>

                            <tr>
                                <td class="">First Name</td>
                                <td class=""><span id="vothernames"></span></td>
                            </tr>

                            <tr>
                                <td class="">Email</td>
                                <td class=""><span id="vemail"></span></td>
                            </tr>

                            <tr>
                                <td class="">Phone Number</td>
                                <td class=""><span id="vphone"></span></td>
                            </tr>

                            <tr>
                                <td class="">Organization</td>
                                <td class=""><span id="vorganization"></span></td>
                            </tr>

                            <tr>
                                <td class="">Contact Address</td>
                                <td class=""><span id="vaddress"></span></td>
                            </tr>

                            <tr>
                                <td class="">Selected Product</td>
                                <td class=""><span id="vproduct"></span></td>
                            </tr>

                            <tr>
                                <td class="">Subscribed Plan</td>
                                <td class=""><span id="vplan"></span></td>
                            </tr>

                            <tr>
                                <td class="">Subsciption Date</td>
                                <td class=""><span id="vsubdate"></span></td>
                            </tr>

                            <tr>
                                <td class="">Next Renewal Date</td>
                                <td class=""><span id="vrenewaldate"></span></td>
                            </tr>

                            <tr>
                                <td class="">Status</td>
                                <td class=""><span id="vstatus"></span></td>
                            </tr>
                        </tbody>
                    </table>
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
