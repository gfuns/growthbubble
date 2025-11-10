@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Payments or Transactions')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Payments or Transactions
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Admin</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Payments or Transactions
                            </li>
                        </ol>
                    </nav>
                </div>

                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 4) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">New Invoice</a>

                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 fw-bold ls-md">{{ number_format(0, 0) }} Invoice(s) in Draft</h4>
                            </div>
                            <h4 class="fw-bold mb-1">&pound;{{ number_format(0, 2) }}</h4>
                        </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 fw-bold ls-md">{{ number_format(0, 0) }} Invoice(s) in Due</h4>
                            </div>
                            <h4 class="fw-bold mb-1">&pound;{{ number_format(0, 2) }}</h4>
                        </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 fw-bold ls-md">{{ number_format(0, 0) }} Invoice(s) Created</h4>
                            </div>
                            <h4 class="fw-bold mb-1">&pound;{{ number_format(0, 2) }}</h4>
                        </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                                <h4 class="fs-6 fw-bold ls-md">{{ number_format(0, 0) }} Invoice(s) in Overdue</h4>
                            </div>
                            <h4 class="fw-bold mb-1">&pound;{{ number_format(0, 2) }}</h4>
                        </div>
                </div>
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
                                <div class="col-12 col-lg-3 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="search" type="search" class="form-control ps-6"
                                            placeholder="Search......" value="{{ $search }}">
                                    </div>

                                </div>

                                <div class="col-6 col-lg-4">
                                    <!-- form select -->
                                    <div class="input-group mb-3">
                                        <input type="text" name="start_date" class="form-control" id="startDate"
                                            placeholder="Start Date" onfocus="this.type='date'"
                                            onblur="if(!this.value)this.type='text'">

                                        <input type="text" name="end_date" class="form-control" id="endDate"
                                            placeholder="End Date" onfocus="this.type='date'"
                                            onblur="if(!this.value)this.type='text'">
                                    </div>
                                </div>

                                <div class="col-6 col-lg-2">
                                    <!-- form select -->
                                    <select id="prod" name="product" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Products</option>
                                        @foreach ($products as $prod)
                                            <option value="{{ $prod->id }}"
                                                @if ($product == $prod->id) selected @endif>
                                                {{ $prod->product }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 col-lg-2">
                                    <!-- form select -->
                                    <select id="status" name="status" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="active" @if ($status == 'active') selected @endif>
                                            Active
                                        </option>
                                        <option value="terminated" @if ($status == 'terminated') selected @endif>
                                            Terminated
                                        </option>
                                    </select>
                                </div>
                                <div class="col-6 col-lg-1">
                                    <!-- form select -->
                                    <button class="btn btn-primary btn-md"><i class="bi bi-cloud-download"></i></button>
                                </div>
                            </div>
                        </form>
                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Invoice Name</th>
                                        <th scope="col">Invoice Number</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Issue Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($invoices as $sub)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $sub->customer->last_name . ', ' . $sub->customer->other_names }}
                                            </td>
                                            <td class="align-middle"> {{ $sub->product->product }} </td>
                                            <td class="align-middle"> {{ $sub->plan->plan }} </td>
                                            <td class="align-middle"> &pound;{{ number_format($sub->pricing, 2) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ date_format(new DateTime($sub->effective_date), 'jS M, Y') }} </td>
                                            <td class="align-middle">
                                                {{ date_format(new DateTime($sub->expiry_date), 'jS M, Y') }} </td>
                                            <td>
                                                @if ($sub->status == 'active')
                                                    <span class="badge text-success bg-light-success">Active</span>
                                                @else
                                                    <span class="badge text-danger bg-light-danger">Terminated</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($invoices) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no payments found.
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
    document.getElementById("navAdmin").classList.add('show');
    document.getElementById("payments").classList.add('active');
</script>

@endsection
