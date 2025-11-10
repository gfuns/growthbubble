@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Payments or Transactions')
<style type="text/css">
    .initials {
        border-radius: 55%;
        background: #155eef;
        font-size: 11px;
        color: white;
        padding: 5px;
    }

    .receipt {
        font-size: 15px;
        border-radius: 55%;
        background: #c3ccdb;
        padding: 8px;
        margin-right: 10px;
    }
</style>
<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Payments
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Account</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Payments
                            </li>
                        </ol>
                    </nav>
                </div>

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
                            <h4 class="fs-6 fw-bold ls-md">{{ number_format($params['draftCount'], 0) }} Invoice(s) in
                                Draft</h4>
                        </div>
                        <h4 class="fw-bold mb-1">&pound;{{ number_format($params['draftSum'], 2) }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                            <h4 class="fs-6 fw-bold ls-md">{{ number_format($params['dueCount'], 0) }} Invoice(s) in Due
                            </h4>
                        </div>
                        <h4 class="fw-bold mb-1">&pound;{{ number_format($params['dueSum'], 2) }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                            <h4 class="fs-6 fw-bold ls-md">{{ number_format($params['invCount'], 0) }} Invoice(s)
                                Received</h4>
                        </div>
                        <h4 class="fw-bold mb-1">&pound;{{ number_format($params['invSum'], 2) }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 lh-1">
                            <h4 class="fs-6 fw-bold ls-md">{{ number_format($params['overdueCount'], 0) }} Invoice(s) in
                                Overdue</h4>
                        </div>
                        <h4 class="fw-bold mb-1">&pound;{{ number_format($params['overdueSum'], 2) }}</h4>
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
                                            placeholder="Start Date" value="{{ $startDate }}"
                                            onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">

                                        <input type="text" name="end_date" class="form-control" id="endDate"
                                            placeholder="End Date" value="{{ $endDate }}"
                                            onfocus="this.type='date'" onblur="if(!this.value)this.type='text'"
                                            onChange="this.form.submit()">
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
                                            Active Invoices
                                        </option>
                                        <option value="due" @if ($status == 'due') selected @endif>
                                            Due Invoices
                                        </option>
                                        <option value="overdue" @if ($status == 'overdue') selected @endif>
                                            Overdue Invoices
                                        </option>
                                        <option value="paid" @if ($status == 'paid') selected @endif>
                                            Paid Invoices
                                        </option>
                                        <option value="draft" @if ($status == 'draft') selected @endif>
                                            Draft Invoices
                                        </option>
                                    </select>
                                </div>
                                <div class="col-6 col-lg-1">
                                    <!-- form select -->
                                    <a href="{{ route('admin.downloadInvoice') }}"><button type="button"
                                            class="btn btn-primary btn-md"><i
                                                class="bi bi-cloud-download"></i></button></a>
                                </div>
                            </div>
                        </form>
                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">SNo</th>
                                        <th scope="col">Invoice Name</th>
                                        <th scope="col">Invoice Number</th>
                                        <th scope="col">Issue Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($invoices as $inv)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}. </td>
                                            <td class="align-middle">{{ $inv->name() }} Invoice</td>
                                            <td class="align-middle"> {{ $inv->invoice_number }} </td>
                                            <td class="align-middle">
                                                {{ date_format(new DateTime($inv->due_date), 'jS M, Y') }} </td>
                                            <td class="align-middle"> &pound;{{ number_format($inv->amount, 2) }}
                                            </td>
                                            <td>
                                                 <a href=""> <span class="badge text-primary bg-light-primary">Download Receipt</span></a>
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
    document.getElementById("navSettings").classList.add('show');
    document.getElementById("payments").classList.add('active');
</script>

@endsection


@section('customjs')
<script type="text/javascript">
    $('#custSelProd').change(function() {
        var productId = $(this).val();
        $('#custSelPlan').html(
            '<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
        $.ajax({
            url: "/ajax/fetch-plans/" + productId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                var options = "<option value=''>Select Product Plans</option>";
                $.each(data, function(index, plan) {
                    options += "<option value='" + plan.id + "' data-amount='" + plan
                        .pricing + "'>" + plan.plan + " " + toCamelCase(plan.frequency) +
                        "</option>";
                });
                $('#custSelPlan').html(options);
            }
        });
    });

    $('#custSelPlan').change(function() {
        var selectedOption = $(this).find(':selected');
        var amount = selectedOption.data('amount');
        $('#amount').val(amount ? amount : '');
    });

    function toCamelCase(str) {
        return str.toLowerCase().replace(/(^|\s)\S/g, letter => letter.toUpperCase());
    }
</script>
@endsection
