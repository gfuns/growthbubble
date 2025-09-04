@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Roles and Permissions')


<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold">Roles and Permissions</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Roles and Permissions</a>
                            </li>
                        </ol>
                    </nav>
                </div>

                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 1) == true)
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Add New User Role</a>

                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card rounded-3">
                <!-- Card Header -->
                &nbsp;
                <div>
                    <div class="tab-content" id="tabContent">
                        <!-- Tab -->
                        <div class="tab-pane fade show active" id="all-orders" role="tabpanel"
                            aria-labelledby="all-orders-tab">
                            <div class="table-responsive" style="min-height:200px">
                                <!-- Table -->
                                <table class="table mb-0 text-nowrap table-hover table-centered table-with-checkbox"
                                    style="font-size: 14px;">
                                    <!-- Table Head -->
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User Role</th>
                                            <th>Permissions</th>
                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 1) == true)
                                                <th><i class="nav-icon bi bi-three-dots me-2"></i></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        <!-- Table body -->
                                        @foreach ($userRoles as $role)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $role->role }}</td>
                                                <td> {{ $role->totalPermissions() }} Permissions Found</td>
                                                @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 1) == true)
                                                    <td class="align-middle">
                                                        <div class="hstack gap-4">
                                                            <span class="dropdown dropstart">
                                                                <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                                    href="#" role="button"
                                                                    data-bs-toggle="dropdown" data-bs-offset="-20,20"
                                                                    aria-expanded="false">Action</a>
                                                                <span class="dropdown-menu"><span
                                                                        class="dropdown-header">Action</span>

                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="offcanvas"
                                                                        data-bs-target="#editUserRole"
                                                                        data-myid="{{ $role->id }}"
                                                                        data-category="{{ $role->category }}"
                                                                        data-userole="{{ $role->role }}"><i
                                                                            class="fe fe-edit dropdown-item-icon"></i>Update
                                                                        Details</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.managePermissions', [$role->id]) }}"><i
                                                                            class="fe fe-settings dropdown-item-icon"></i>View
                                                                        Permissions</a>

                                                                </span>
                                                            </span>

                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach

                                        @if (count($userRoles) < 1)
                                            <tr>
                                                <td colspan="4">
                                                    <center>No Record Found</center>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>



                        </div>

                    </div>
                </div>
                <!-- Card Footer -->

            </div>
        </div>
    </div>
</section>

@if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 1) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> New User Role</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.storeUserRole') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">User Role <span class="text-danger">*</span></label>
                            <input type="text" name="role" class="form-control" placeholder="Enter User Role"
                                required>
                            <div class="invalid-feedback">Please provide user role.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Save User Role</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 1) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editUserRole" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit User Role</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateUserRole') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">User Role <span class="text-danger">*</span></label>
                            <input id="userole" type="text" name="role" class="form-control"
                                placeholder="Enter User Role" required>
                            <div class="invalid-feedback">Please provide user role.</div>
                        </div>

                        <input id="myid" type="hidden" name="role_id" class="form-control" required>

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
    document.getElementById("platSettings").classList.add('show');
    document.getElementById("roles").classList.add('active');
</script>

@endsection
