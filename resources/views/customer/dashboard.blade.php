@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Client Dashboard')
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
        @if (Auth::user()->onboarding_status != 'onboarded')
            <div class="alert alert-primary d-flex justify-content-between align-items-center">
                <div>Please take some time to complete your onboarding.</div>
                <div><a href="{{ route('onboarding.instructions') }}"><button class="btn btn-primary btn-xs">Complete
                            Onboarding</button></a></div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route('customer.tasks', [Auth::user()->product_id]) }}?status=in progress">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Active Tasks</h4>
                                <div>
                                    <span class="bi bi-lightbulb fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['activeTasks'], 0) }} /
                                {{ Auth::user()->allowedActiveTasks() }}</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route('customer.tasks', [Auth::user()->product_id]) }}?status=queued">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Queued Tasks</h4>
                                <div>
                                    <span class="bi bi-list-ol fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['queuedTasks'], 0) }} / Unlimited</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route('customer.tasks', [Auth::user()->product_id]) }}?recurring=yes">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Recurring Tasks</h4>
                                <div>
                                    <span class="bi bi-arrow-clockwise fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['recurringTasks'], 0) }} / Unlimited</h4>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="{{ route('customer.tasks', [Auth::user()->product_id]) }}?status=completed">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md">Completed Tasks</h4>
                                <div>
                                    <span class="bi bi-check2-circle fs-3 text-primary"></span>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1">{{ number_format($params['completedTasks'], 0) }} / Unlimited</h4>
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
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-dark fw-bold active" id="tasks-tab"
                                            data-bs-toggle="pill" href="#myTasks" role="tab" aria-controls="myTasks"
                                            aria-selected="true">My Tasks</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-dark fw-bold" id="projects-tab" data-bs-toggle="pill"
                                            href="#myProjects" role="tab" aria-controls="myProjects"
                                            aria-selected="true">My Projects</a>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <!-- Table -->
                                <div class="tab-content" id="tabContent">

                                    <div class="tab-pane fade active show " id="myTasks" role="tabpanel"
                                        aria-labelledby="tab-tasks">
                                        <!-- Table -->
                                        <div class="table-responsive">
                                            <table @if (count($tasks) > 0) id="prodTable1" @endif
                                                class="table mb-0 table-hover" style="font-size: 13px">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Priority</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tasks as $tsk)
                                                        <tr class="text-dark">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td class="no-wrap">
                                                                <a href="{{ route('customer.taskDetails', [$tsk->id]) }}"
                                                                    class="text-dark">
                                                                    {{ Str::limit($tsk->title, 50) }}
                                                                </a>
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

                                            @if (count($tasks) < 1)
                                                <div class="col-xl-12 col-12 job-items job-empty">
                                                    <div class="text-center mt-4"><i class="bi bi-dropbox"
                                                            style="font-size: 48px"></i>
                                                        <h3 class="mt-2">No Active Tasks Available</h3>
                                                        <div class="mt-2 text-muted"> Click "Create New Task" to add a
                                                            task.
                                                        </div>
                                                        <div class="mt-4">
                                                            <a
                                                                href="{{ route('customer.newCustomerTask', [Auth::user()->product_id]) }}">
                                                                <button class="btn btn-primary btn-xs"><i
                                                                        class="bi bi-plus-circle"></i> Create New
                                                                    Task</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="tab-pane fade active" id="myProjects" role="tabpanel"
                                        aria-labelledby="tab-project">
                                        <!-- Table -->
                                        <div class="table-responsive">
                                            <table @if (count($projects) > 0) id="prodTable2" @endif
                                                class="table mb-0 table-hover" style="font-size: 13px">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Project Title</th>
                                                        <th>Date Created</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($projects as $cProj)
                                                        <tr>
                                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                                            <td class="align-middle"> {{ $cProj->project_title }}
                                                            </td>
                                                            <td class="align-middle">
                                                                {{ date_format($cProj->created_at, 'jS M, Y g:ia') }}
                                                            </td>
                                                            <td>
                                                                @if ($cProj->status == 'open')
                                                                    <span
                                                                        class="badge text-success bg-light-success">Open</span>
                                                                @else
                                                                    <span
                                                                        class="badge text-danger bg-light-danger">Closed</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                            @if (count($projects) < 1)
                                                <div class="col-xl-12 col-12 job-items job-empty">
                                                    <div class="text-center mt-4"><i class="bi bi-dropbox"
                                                            style="font-size: 48px"></i>
                                                        <h3 class="mt-2">No Projects Available</h3>
                                                        <div class="mt-2 text-muted"> Click "Create New Project" to add
                                                            a
                                                            project.
                                                        </div>
                                                        <div class="mt-4">
                                                            <button class="btn btn-primary btn-xs"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#offcanvasRight"><i
                                                                    class="bi bi-plus-circle"></i> Create New
                                                                Project</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">

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
                                                        @if ($activity->user->id == Auth::user()->id)
                                                            (You)
                                                        @endif
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

    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Project</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('customer.storeProject') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Project Title <span class="text-danger">*</span></label>
                            <input type="text" name="project_title" class="form-control"
                                placeholder="Enter Project Title" required>
                            <div class="invalid-feedback">Please provide project title.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Project Description <span class="text-danger">*</span></label>
                            <textarea name="project_description" class="form-control" placeholder="Enter Project Description" required
                                style="resize: none" rows="5"></textarea>
                            <div class="invalid-feedback">Please provide project description.</div>
                        </div>

                        <input id="myid" type="hidden" name="product_id"
                            value="{{ Auth::user()->product_id }}" class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Project</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<script>
    document.getElementById("dashboard").classList.add('active');
</script>

@endsection
