@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Payment History')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Payment History
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Payment History
                            </li>
                        </ol>
                    </nav>
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

                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">S/No</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date Paid</th>
                                        <th scope="col">Expiry Date</th>
                                        <th scope="col">Receipt</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($subscriptions as $sub)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle"> {{ $sub->product->product }} </td>
                                            <td class="align-middle"> {{ $sub->plan->plan }} </td>
                                            <td class="align-middle"> &pound;{{ number_format($sub->pricing, 2) }} </td>
                                            <td class="align-middle">
                                                {{ date_format(new DateTime($sub->effective_date), 'jS F, Y') }} </td>
                                            <td class="align-middle">
                                                {{ date_format(new DateTime($sub->expiry_date), 'jS F, Y') }} </td>
                                            <td>
                                                <a href=""><button class="btn btn-primary btn-xs">Download Receipt</button></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($subscriptions) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no customer subscriptions found.
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
    document.getElementById("subscriptions").classList.add('active');
</script>

@endsection
