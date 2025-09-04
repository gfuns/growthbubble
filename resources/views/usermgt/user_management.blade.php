@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | User Management')

<!-- Container fluid -->
<section class="container-fluid pt-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4 mb-4 d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h4 fw-bold">
                        User Management
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                User Management
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 2) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Add User</a>

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

                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5 mt-5">
                            <table id="dataTableBasic" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:12px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">S/No</th>
                                        <th scope="col">User's Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Work Group</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Payroll Rights</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $usr)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle"> {{ $usr->last_name . ' ' . $usr->first_name }}
                                            </td>
                                            <td class="align-middle"> {{ $usr->email }} </td>
                                            <td class="align-middle"> {{ $usr->phone_number }} </td>
                                            <td class="align-middle"> {{ $usr->group->work_group }} </td>
                                            <td class="align-middle"> {{ $usr->role->role }} </td>
                                            <td class="align-middle"> {{ ucwords($usr->status) }} </td>
                                            <td class="align-middle">
                                                {{ $usr->payrol_rights == null ? 'None' : ucwords($usr->payrol_rights) }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="hstack gap-4">

                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>
                                                        @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
                                                            <span class="dropdown-menu"><span
                                                                    class="dropdown-header">Action</span>
                                                                <a style="cursor:pointer" class="dropdown-item"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#editAdmin"
                                                                    data-myid="{{ $usr->id }}"
                                                                    data-firstname="{{ $usr->first_name }}"
                                                                    data-lastname="{{ $usr->last_name }}"
                                                                    data-email="{{ $usr->email }}"
                                                                    data-phone="{{ $usr->phone_number }}"
                                                                    data-role="{{ $usr->role_id }}"
                                                                    data-workgroup="{{ $usr->work_group_id }}"><i
                                                                        class="fe fe-edit dropdown-item-icon"></i>Edit
                                                                    User Information</a>
                                                                @if ($usr->status == 'active')
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('suspendUser', [$usr->id]) }}"
                                                                        onclick="return confirm('Are you sure you want to suspend this user?');"><i
                                                                            class="fe fe-x-circle dropdown-item-icon"></i>Suspend
                                                                        User</a>
                                                                @else
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('activateUser', [$usr->id]) }}"
                                                                        onclick="return confirm('Are you sure you want to activate this user?');"><i
                                                                            class="fe fe-check-circle dropdown-item-icon"></i>Activate
                                                                        User</a>
                                                                @endif
                                                                <a style="cursor:pointer" class="dropdown-item"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#payrolRights"
                                                                    data-myid="{{ $usr->id }}"
                                                                    data-accesstype="{{ $usr->payrol_rights }}"><i
                                                                        class="fe fe-check-circle dropdown-item-icon"></i>Assign
                                                                    Payrol Rights</a>
                                                            </span>
                                                        @endif
                                                    </span>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($users) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No User Found</h3>
                                        <div class="mt-2 text-muted"> There are no user records found.
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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New User Account</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('storeUser') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control"
                                placeholder="Enter First Name" required>
                            <div class="invalid-feedback">Please provide first name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control"
                                placeholder="Enter Last Name" required>
                            <div class="invalid-feedback">Please provide last name.</div>
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
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select user role.</div>
                        </div>

                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Work Group <span class="text-danger">*</span></label>
                            <select id="workgroup" name="work_group" class="selectpicker form-control"
                                data-width="100%" required>
                                <option value="">Select Work Group</option>
                                @foreach ($workGroups as $wg)
                                    <option value="{{ $wg->id }}">{{ $wg->work_group }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select work group.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editAdmin" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit Administrator Account</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('updateUser') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input id="firstname" type="text" name="first_name" class="form-control"
                                placeholder="Enter First Name" required>
                            <div class="invalid-feedback">Please provide first name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input id="lastname" type="text" name="last_name" class="form-control"
                                placeholder="Enter Last Name" required>
                            <div class="invalid-feedback">Please provide last name.</div>
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
                            <select id="role" name="role" class="form-select" data-width="100%" required>
                                <option value="">Select User Role</option>
                                @foreach ($userRoles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select admin role.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Work Group <span class="text-danger">*</span></label>
                            <select id="eworkgroup" name="work_group" class="form-select" data-width="100%"
                                required>
                                <option value="">Select Work Group</option>
                                @foreach ($workGroups as $wg)
                                    <option value="{{ $wg->id }}">{{ $wg->work_group }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select assigned work group.</div>
                        </div>


                        <input id="myid" type="hidden" name="user_id" class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


<div class="offcanvas offcanvas-end" tabindex="-1" id="payrolRights" style="width: 600px;">
    <div class="offcanvas-body" data-simplebar>
        <div class="offcanvas-header px-2 pt-0">
            <h3 class="offcanvas-title" id="offcanvasExampleLabel">Payrol Access Rights</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <!-- card body -->
        <div class="container">
            <!-- form -->
            <form class="needs-validation" novalidate method="post" action="{{ route('storeUserPayrolRights') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- form group -->
                    <div class="mb-3 col-12">
                        <label class="form-label">Payroll Access Rights <span class="text-danger">*</span></label>
                        <select id="accesstype" class="form-select" name="access_type" required>
                            <option value="">Select Rights</option>
                            <option value="preparer">Preparer Rights</option>
                            <option value="reviewer">Reviewer Rights</option>
                            <option value="approver">Approver Rights</option>
                            <option value="authorizer">Authorizer Rights</option>
                            <option value="final authorizer">Final Authorizer Rights</option>
                        </select>
                        <div class="invalid-feedback">Please select payrol access rights.</div>
                    </div>

                    <input id="myid" type="hidden" name="user_id" readonly />



                    <div class="col-md-12 border-bottom"></div>
                    <!-- button -->
                    <div class="col-12 mt-4">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                            aria-label="Close">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewAdmin" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    View Account Details
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="">First Name</td>
                            <td class=""><span id="vfirstname"></span></td>
                            <td class="" rowspan="7" align="right" style="text-align: center"><img
                                    src="" id="vphoto" class="img-responsive" style="max-width: 150px" />
                            </td>
                        </tr>

                        <tr>
                            <td class="">Last Name</td>
                            <td class=""><span id="vlastname"></span></td>
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
                            <td class="">Gender</td>
                            <td class=""><span id="vgender"></span></td>
                        </tr>

                        <tr>
                            <td class="">Role</td>
                            <td class=""><span id="vrole"></span></td>
                        </tr>

                        <tr>
                            <td class="">Registration Date</td>
                            <td class="" colspan="2"><span id="vregdate"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("usermgt").classList.add('active');
</script>

@endsection
