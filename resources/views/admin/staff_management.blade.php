@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Staff Management')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Staff Management
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Staff Management
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 2) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Create New User Account</a>

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
                                            placeholder="Search Staff Using Names, Email or Phone Number......"
                                            value="{{ $search }}">
                                    </div>

                                </div>

                                <div class="col-6 col-lg-3">
                                    <!-- form select -->
                                    <select id="status" name="status" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="active" @if ($status == 'active') selected @endif>
                                            Active
                                        </option>
                                        <option value="suspended" @if ($status == 'suspended') selected @endif>
                                            Suspended
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
                                        <th scope="col">Staff Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Assigned Role</th>
                                        <th scope="col">Status</th>
                                        @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
                                            <th scope="col">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($staffList as $usr)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle">
                                                {{ $usr->last_name . ', ' . $usr->other_names }}
                                            </td>
                                            <td class="align-middle"> {{ $usr->email }} </td>
                                            <td class="align-middle"> {{ $usr->phone_number }} </td>
                                            <td class="align-middle"> {{ $usr->userRole->role }} </td>
                                            <td>
                                                @if ($usr->status == 'active')
                                                    <span class="badge text-success bg-light-success">Active</span>
                                                @else
                                                    <span class="badge text-danger bg-light-danger">Suspended</span>
                                                @endif
                                            </td>
                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
                                                @if ($usr->role_id > 1)
                                                    <td class="align-middle">
                                                        <div class="hstack gap-4">

                                                            <span class="dropdown dropstart">
                                                                <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                                    href="#" role="button"
                                                                    data-bs-toggle="dropdown" data-bs-offset="-20,20"
                                                                    aria-expanded="false">
                                                                    Action</a>

                                                                <span class="dropdown-menu"><span
                                                                        class="dropdown-header">Action</span>
                                                                    <a style="cursor:pointer" class="dropdown-item"
                                                                        data-bs-toggle="offcanvas"
                                                                        data-bs-target="#editStaff"
                                                                        data-myid="{{ $usr->id }}"
                                                                        data-othernames="{{ $usr->other_names }}"
                                                                        data-lastname="{{ $usr->last_name }}"
                                                                        data-email="{{ $usr->email }}"
                                                                        data-phone="{{ $usr->phone_number }}"
                                                                        data-role="{{ $usr->role_id }}"><i
                                                                            class="fe fe-edit dropdown-item-icon"></i>Edit
                                                                        Staff Information</a>
                                                                    @if ($usr->status == 'active')
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('admin.suspendStaff', [$usr->id]) }}"
                                                                            onclick="return confirm('Are you sure you want to suspend this user?');"><i
                                                                                class="fe fe-x-circle dropdown-item-icon"></i>Suspend
                                                                            Staff</a>
                                                                    @else
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('admin.activateStaff', [$usr->id]) }}"
                                                                            onclick="return confirm('Are you sure you want to activate this user?');"><i
                                                                                class="fe fe-check-circle dropdown-item-icon"></i>Activate
                                                                            Staff</a>
                                                                    @endif
                                                                </span>

                                                            </span>

                                                        </div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($staffList) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no staff records found.
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

@if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 2) == true)
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Staff Account</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.storeStaff') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control"
                                placeholder="Enter Last Name" required>
                            <div class="invalid-feedback">Please provide last name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control"
                                placeholder="Enter First Name" required>
                            <div class="invalid-feedback">Please provide first name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                placeholder="Enter Email Address" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone_number" class="form-control"
                                placeholder="Enter Phone Number" required>
                            <div class="invalid-feedback">Please provide a valid phone number.</div>
                        </div>

                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">User Role <span class="text-danger">*</span></label>
                            <select id="userrole" name="role" class="selectpicker form-control"
                                data-width="100%" required>
                                <option value="">Select User Role</option>
                                @foreach ($userRoles as $role)
                                    <option value="{{ $role->id }}" data-category="{{ $role->category }}">
                                        {{ $role->role }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select user role.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Staff Account</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editStaff" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit Staff Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateStaff') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input id="lastname" type="text" name="last_name" class="form-control"
                                placeholder="Enter Last Name" required>
                            <div class="invalid-feedback">Please provide last name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input id="othernames" type="text" name="first_name" class="form-control"
                                placeholder="Enter First Name" required>
                            <div class="invalid-feedback">Please provide first name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" name="email" class="form-control"
                                placeholder="Enter Email" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input id="phone" type="text" name="phone_number" class="form-control"
                                placeholder="Enter Phone Number" required>
                            <div class="invalid-feedback">Please provide a valid phone number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select id="uuserrole" name="role" class="form-select" data-width="100%" required>
                                <option value="">Select User Role</option>
                                @foreach ($userRoles as $role)
                                    <option value="{{ $role->id }}" data-category="{{ $role->category }}">
                                        {{ $role->role }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select admin role.</div>
                        </div>

                        <input id="myid" type="hidden" name="user_id" class="form-control" required>

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
    document.getElementById("staff").classList.add('active');
</script>

@endsection
