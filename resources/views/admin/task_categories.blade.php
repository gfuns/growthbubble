@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Product Plans')


<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold">Product Plans</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Product Plans</a>
                            </li>
                        </ol>
                    </nav>
                </div>

                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 1) == true)
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Add New Product Plan</a>

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
                                            <th>Product</th>
                                            <th>Plan</th>
                                            <th>Payment Frequency</th>
                                            <th>Pricing</th>
                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 1) == true)
                                                <th><i class="nav-icon bi bi-three-dots me-2"></i></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        <!-- Table body -->
                                        @foreach ($taskcategories as $cat)
                                            <tr>
                                                <td style="vertical-align: top !important">{{ $loop->index + 1 }}</td>
                                                <td style="vertical-align: top !important">{{ $plan->product->product }}
                                                </td>
                                                <td style="vertical-align: top !important">{{ $plan->plan }} Plan</td>
                                                <td style="vertical-align: top !important">
                                                    {{ ucwords($plan->frequency) }}</td>
                                                <td class="wrap-text"> &pound;{{ number_format($plan->pricing, 2) }}</td>
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
                                                                        data-bs-target="#editProductPlan"
                                                                        data-myid="{{ $plan->id }}"
                                                                        data-product="{{ $plan->product_id }}"
                                                                        data-plan="{{ $plan->plan }}"
                                                                        data-frequency="{{ $plan->frequency }}"
                                                                        data-pricing="{{ $plan->pricing }}"><i
                                                                            class="fe fe-edit dropdown-item-icon"></i>Update
                                                                        Details</a>

                                                                </span>
                                                            </span>

                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach

                                        @if (count($taskcategories) < 1)
                                            <tr>
                                                <td colspan="5">
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
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> New Product Plan</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.storeProductPlan') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->

                        <div class="mb-3 col-12">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select id="selProduct" name="product" class="form-control" data-width="100%" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->product }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a product.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" name="plan" class="form-control" placeholder="Enter Plan Name"
                                required>
                            <div class="invalid-feedback">Please provide plan name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Payment Frequency <span class="text-danger">*</span></label>
                            <select id="frequency" name="frequency" class="form-control" data-width="100%" required>
                                <option value="">Select Payment Frequency</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                            <div class="invalid-feedback">Please select payment frequency.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Pricing <span class="text-danger">*</span></label>
                            <input type="text" name="pricing" class="form-control" placeholder="Enter Pricing"
                                oninput="validateInput(event)" required>
                            <div class="invalid-feedback">Please provide pricing.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Save Product Plan Information</button>
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editProductPlan" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit Product Plan Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('admin.updateProductPlan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select id="productSel" name="product" class="form-control" data-width="100%" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->product }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a product.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                            <input id="plan" type="text" name="plan" class="form-control"
                                placeholder="Enter Plan Name" required>
                            <div class="invalid-feedback">Please provide plan name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Payment Frequency <span class="text-danger">*</span></label>
                            <select id="freq" name="frequency" class="form-control" data-width="100%" required>
                                <option value="">Select Payment Frequency</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                            <div class="invalid-feedback">Please select payment frequency.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Pricing <span class="text-danger">*</span></label>
                            <input id="pricing" type="text" name="pricing" class="form-control"
                                placeholder="Enter Pricing" oninput="validateInput(event)" required>
                            <div class="invalid-feedback">Please provide pricing.</div>
                        </div>

                        <input id="myid" type="hidden" name="plan_id" class="form-control" required>

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
    document.getElementById("categories").classList.add('active');
</script>

@endsection
