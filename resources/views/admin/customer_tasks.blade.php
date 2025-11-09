@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Customer Tasks')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Customer Tasks
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Customer Tasks
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 5) == true)
                    <!-- button -->
                    <div>
                        <a href="{{ route('admin.newCustomerTask') }}" class="btn btn-primary btn-sm me-2">Create New
                            Task</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">

            <!-- Tab -->
            <div class="tab-content">
                <!-- Tab pane -->

                <!-- tab pane -->
                <div class="tab-pane fade show active" id="tabPaneList" role="tabpanel" aria-labelledby="tabPaneList">
                    <!-- card -->
                    <div class="card mb-4">
                        <!-- Card header -->
                        <form id="form" name="form" method="GET">
                            <div class="p-4 row gx-3">
                                <!-- Form -->
                                <div class="col-12 col-lg-9 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="search" type="search" class="form-control ps-6"
                                            placeholder="Search Tasks Using Task Title or Customer Names......"
                                            value="{{ $search }}">
                                    </div>

                                </div>

                                <div class="col-6 col-lg-3">
                                    <!-- form select -->
                                    <select id="status" name="status" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="queued" @if ($status == 'queued') selected @endif>Queued
                                        </option>
                                        <option value="in progress" @if ($status == 'in progress') selected @endif>In
                                            Progress
                                        </option>
                                        <option value="completed" @if ($status == 'completed') selected @endif>
                                            Completed
                                        </option>
                                        <option value="on hold" @if ($status == 'on hold') selected @endif>On
                                            Hold
                                        </option>
                                        <option value="cancelled" @if ($status == 'cancelled') selected @endif>
                                            Cancelled
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">S/No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Creator</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($customerTasks as $cTask)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle">{{ $cTask->title }} </td>
                                            <td class="align-middle">
                                                {{ $cTask->user->last_name . ', ' . $cTask->user->other_names }}
                                            </td>
                                            <td class="align-middle">{{ $cTask->creator() }}</td>
                                            <td>
                                                @if ($cTask->status == 'queued' || $cTask->status == 'on hold')
                                                    <span
                                                        class="badge text-primary bg-light-primary">{{ ucwords($cTask->status) }}</span>
                                                @elseif ($cTask->status == 'in progress')
                                                    <span
                                                        class="badge text-warning bg-light-warning">{{ ucwords($cTask->status) }}</span>
                                                @elseif ($cTask->status == 'completed')
                                                    <span
                                                        class="badge text-success bg-light-success">{{ ucwords($cTask->status) }}</span>
                                                @elseif ($cTask->status == 'cancelled')
                                                    <span
                                                        class="badge text-danger bg-light-danger">{{ ucwords($cTask->status) }}</span>
                                                @endif
                                            </td>

                                            <td class="align-middle">
                                                <div class="hstack gap-4">
                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>

                                                        <span class="dropdown-menu"><span
                                                                class="dropdown-header">Action</span>
                                                            <a href="{{ route('admin.taskDetails', [$cTask->id]) }}"
                                                                class="dropdown-item">
                                                                <i class="fe fe-eye dropdown-item-icon"></i>View
                                                                Task Details</a>

                                                        </span>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if (count($customerTasks) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no customer tasks found.
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (count($customerTasks) > 0 && $marker != null)
                                <div class="card-footer">
                                    <div class="row g-2 pt-3 me-4">
                                        <div class="col-md-9">Showing {{ $marker['begin'] }} to {{ $marker['end'] }}
                                            of
                                            {{ number_format($lastRecord) }} Records</div>

                                        <div class="col-md-3">
                                            {{ $customerTasks->appends(request()->input())->links() }}
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
</section>



<script type="text/javascript">
    document.getElementById("navConcierge").classList.add('show');
    document.getElementById("tasks").classList.add('active');
</script>

@endsection
