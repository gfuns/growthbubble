@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Customer Projects')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Customer Projects
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Customer Projects
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 4) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Create New Project</a>

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
                                            placeholder="Search Projects Using Project Title or Customer Names......"
                                            value="{{ $search }}">
                                    </div>

                                </div>

                                <div class="col-6 col-lg-3">
                                    <!-- form select -->
                                    <select id="status" name="status" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="open" @if ($status == 'open') selected @endif>Open
                                        </option>
                                        <option value="closed" @if ($status == 'closed') selected @endif>Closed
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
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Project Title</th>
                                        <th scope="col">Creator</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($customerProjects as $cProj)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle">
                                                {{ $cProj->user->last_name . ', ' . $cProj->user->other_names }}
                                            </td>
                                            <td class="align-middle"> {{ $cProj->project_title }} </td>
                                            <td class="align-middle"> {{ $cProj->creator() }} </td>
                                            <td>
                                                @if ($cProj->status == 'open')
                                                    <span class="badge text-success bg-light-success">Open</span>
                                                @else
                                                    <span class="badge text-primary bg-light-primary">Closed</span>
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
                                                            <a style="cursor:pointer" class="dropdown-item"
                                                                data-bs-toggle="modal" data-bs-target="#viewProject"
                                                                data-myid="{{ $cProj->id }}"
                                                                data-customer="{{ $cProj->user->last_name . ', ' . $cProj->user->other_names }}"
                                                                data-title="{{ $cProj->project_title }}"
                                                                data-description="{{ $cProj->project_description }}"
                                                                data-date="{{ date_format($cProj->created_at, 'jS F, Y g:ia') }}"
                                                                data-status="{{ ucwords($cProj->status) }}"><i
                                                                    class="fe fe-eye dropdown-item-icon"></i>View
                                                                Project Information</a>

                                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 4) == true)
                                                                <a style="cursor:pointer" class="dropdown-item"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#updateProject"
                                                                    data-myid="{{ $cProj->id }}"
                                                                    data-customer="{{ $cProj->user_id }}"
                                                                    data-title="{{ $cProj->project_title }}"
                                                                    data-description="{{ $cProj->project_description }}"><i
                                                                        class="fe fe-edit dropdown-item-icon"></i>Update
                                                                    Project Information</a>
                                                                @if ($cProj->status == 'open')
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.closeProject', [$cProj->id]) }}"
                                                                        onclick="return confirm('Are you sure you want to close this project?');"><i
                                                                            class="fe fe-x-circle dropdown-item-icon"></i>Close
                                                                        Project</a>
                                                                @endif
                                                            @endif
                                                        </span>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if (count($customerProjects) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no customer projects found.
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (count($customerProjects) > 0 && $marker != null)
                                <div class="card-footer">
                                    <div class="row g-2 pt-3 me-4">
                                        <div class="col-md-9">Showing {{ $marker['begin'] }} to {{ $marker['end'] }}
                                            of
                                            {{ number_format($lastRecord) }} Records</div>

                                        <div class="col-md-3">
                                            {{ $customerProjects->appends(request()->input())->links() }}
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


<div class="modal fade" id="viewProject" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    View Project Information
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered text-dark">
                    <tbody>
                        <tr>
                            <td class=""><b>Customer Name</b></td>
                            <td class=""><span id="vcustomer"></span></td>
                        </tr>

                        <tr>
                            <td class=""><b>Project Title</b></td>
                            <td class=""><span id="vtitle"></span></td>
                        </tr>

                        <tr>
                            <td class=""><b>Project Description</b></td>
                            <td class=""><span id="vdescription"></span></td>
                        </tr>

                        <tr>
                            <td class=""><b>Project Status</b></td>
                            <td class=""><span id="vstatus"></span></td>
                        </tr>

                        <tr>
                            <td class=""><b>Date Created</b></td>
                            <td class=""><span id="vdate"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 4) == true)
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Customer Project</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.storeProject') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Customer <span class="text-danger">*</span></label>
                            <select id="userrole" name="customer" class="form-control" data-width="100%" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $cust)
                                    <option value="{{ $cust->id }}">
                                        {{ $cust->last_name . ' ' . $cust->other_names }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select customer.</div>
                        </div>

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

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Customer Project</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 4) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="updateProject" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit Project Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateProject') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Customer <span class="text-danger">*</span></label>
                            <select id="owner" name="customer" class="form-select" data-width="100%" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $cust)
                                    <option value="{{ $cust->id }}">
                                        {{ $cust->last_name . ' ' . $cust->other_names }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select customer.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Project Title <span class="text-danger">*</span></label>
                            <input id="projTit" type="text" name="project_title" class="form-control"
                                placeholder="Enter Project Title" required>
                            <div class="invalid-feedback">Please provide project title.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Project Description <span class="text-danger">*</span></label>
                            <textarea id="projDes" name="project_description" class="form-control" placeholder="Enter Project Description"
                                required style="resize: none" rows="5"></textarea>
                            <div class="invalid-feedback">Please provide project description.</div>
                        </div>

                        <input id="myid" type="hidden" name="project_id" class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


<script type="text/javascript">
    document.getElementById("projects").classList.add('active');
</script>

@endsection
