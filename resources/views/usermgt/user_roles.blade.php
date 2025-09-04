@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Accredited Vendors')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4 mb-4 d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h4 fw-bold">
                        User Roles
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                User Roles
                            </li>
                        </ol>
                    </nav>
                </div>

                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 1) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Add New User Role</a>

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
                        <div class="table-responsive overflow-y-hidden mt-5">
                            <table id="dataTableBasic" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:12px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">S/No</th>
                                        <th scope="col">User Role</th>
                                        <th scope="col">Permissions</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userRoles as $role)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }} </td>
                                            <td class="align-middle"> {{ $role->role }} </td>
                                            <td class="align-middle"> {{ $role->totalPermissions() }} Permissions Found
                                            </td>
                                            <td class="align-middle">
                                                <div class="hstack gap-4">

                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>
                                                        @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 1) == true)
                                                            <span class="dropdown-menu"><span
                                                                    class="dropdown-header">Action</span>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#editUserRole"
                                                                    data-myid="{{ $role->id }}"
                                                                    data-userole="{{ $role->role }}"><i
                                                                        class="fe fe-edit dropdown-item-icon"></i>Update
                                                                    Details</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('managePermissions', [$role->id]) }}"><i
                                                                        class="fe fe-settings dropdown-item-icon"></i>View
                                                                    Permissions</a>
                                                            </span>
                                                        @endif
                                                    </span>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <div class="mb-5">
                                @if (count($userRoles) < 1)
                                    <div class="col-xl-12 col-12 job-items job-empty">
                                        <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                                style="font-size: 48px"></i>
                                            <h3 class="mt-2">No User Role Found</h3>
                                            <div class="mt-2 text-muted"> There are no user role records found.
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
                <form class="needs-validation" novalidate method="post" action="{{ route('storeUserRole') }}"
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
                <form class="needs-validation" novalidate method="post" action="{{ route('updateUserRole') }}"
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
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<script type="text/javascript">
    document.getElementById("userr").classList.add('active');
</script>

@endsection
