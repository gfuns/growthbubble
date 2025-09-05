@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Registered Customers')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Registered Customers
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Registered Customers
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 3) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Create New Customer Account</a>
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
                                            placeholder="Search Customers Using Names, Email or Phone Number......"
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
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Organization</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($customers as $cust)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle">
                                                {{ $cust->last_name . ', ' . $cust->other_names }}
                                            </td>
                                            <td class="align-middle"> {{ $cust->email }} </td>
                                            <td class="align-middle"> {{ $cust->phone_number }} </td>
                                            <td class="align-middle"> {{ $cust->organization }} </td>
                                            <td>
                                                @if ($cust->status == 'active')
                                                    <span class="badge text-success bg-light-success">Active</span>
                                                @else
                                                    <span class="badge text-danger bg-light-danger">Suspended</span>
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
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewCustomer"
                                                                data-myid="{{ $cust->id }}"
                                                                data-othernames="{{ $cust->other_names }}"
                                                                data-lastname="{{ $cust->last_name }}"
                                                                data-email="{{ $cust->email }}"
                                                                data-phone="{{ $cust->phone_number }}"
                                                                data-organization="{{ $cust->organization }}"
                                                                data-photo="{{ $cust->profile_photo }}"
                                                                data-address="{{ $cust->contact_address ?? "NIL" }}"><i
                                                                    class="fe fe-eye dropdown-item-icon"></i>View
                                                                Customer Information</a>

                                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 3) == true)
                                                                <a style="cursor:pointer" class="dropdown-item"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#editCustomer"
                                                                    data-myid="{{ $cust->id }}"
                                                                    data-othernames="{{ $cust->other_names }}"
                                                                    data-lastname="{{ $cust->last_name }}"
                                                                    data-email="{{ $cust->email }}"
                                                                    data-phone="{{ $cust->phone_number }}"
                                                                    data-organization="{{ $cust->organization }}"
                                                                    data-address="{{ $cust->contact_address}}"><i
                                                                        class="fe fe-edit dropdown-item-icon"></i>Edit
                                                                    Customer Information</a>
                                                                @if ($cust->status == 'active')
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.suspendCustomer', [$cust->id]) }}"
                                                                        onclick="return confirm('Are you sure you want to suspend this customer?');"><i
                                                                            class="fe fe-x-circle dropdown-item-icon"></i>Suspend
                                                                        Customer</a>
                                                                @else
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.activateCustomer', [$cust->id]) }}"
                                                                        onclick="return confirm('Are you sure you want to activate this customer?');"><i
                                                                            class="fe fe-check-circle dropdown-item-icon"></i>Activate
                                                                        Customer</a>
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

                            @if (count($customers) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no customer records found.
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
                            <td class="" rowspan="9" align="right" style="text-align: center"><img
                                    src="" id="vphoto" class="img-responsive" style="max-width: 150px" />
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
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 3) == true)
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Customer Account</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.storeCustomer') }}"
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

                        <div class="mb-3 col-12">
                            <label class="form-label">Organization Name</label>
                            <input type="text" name="organization_name" class="form-control"
                                placeholder="Enter Organization Name">
                            <div class="invalid-feedback">Please provide a customer organization.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Contact Address</label>
                            <textarea name="contact_address" class="form-control"
                                placeholder="Enter Contact Address" rows="3" style="resize: none"></textarea>
                            <div class="invalid-feedback">Please provide a contact address organization.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Customer Account</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 3) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editCustomer" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit Customer Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('admin.updateCustomer') }}" enctype="multipart/form-data">
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
                            <label class="form-label">Organization Name</label>
                            <input id="organization" type="text" name="organization_name" class="form-control"
                                placeholder="Enter Organization Name">
                            <div class="invalid-feedback">Please provide a customer organization.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Contact Address</label>
                            <textarea id="address" name="contact_address" class="form-control"
                                placeholder="Enter Contact Address" rows="3" style="resize: none"></textarea>
                            <div class="invalid-feedback">Please provide a contact address organization.</div>
                        </div>

                        <input id="myid" type="hidden" name="customer_id" class="form-control" required>

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
    document.getElementById("customers").classList.add('active');
</script>

@endsection
