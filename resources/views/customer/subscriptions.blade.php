@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Subscriptions')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Subscriptions
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Account</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Subscriptions
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
                                        <th scope="col">Status</th>
                                        <th scope="col">&nbsp;</th>
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
                                                @if ($sub->status == 'active')
                                                    <span
                                                        class="badge text-success bg-light-success">{{ ucwords($sub->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge text-danger bg-light-danger">{{ ucwords($sub->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="hstack gap-4">
                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>

                                                        <span class="dropdown-menu"><span
                                                                class="dropdown-header">Action</span>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#cancelSubscription"
                                                                data-myid="{{ $sub->id }}" class="dropdown-item">
                                                                <i class="bi bi-x-square dropdown-item-icon"></i>Cancel
                                                                Subscription</a>
                                                            <a href="#" class="dropdown-item">
                                                                <i
                                                                    class="bi bi-arrow-up-right-circle dropdown-item-icon"></i>Upgrade
                                                                Plan</a>

                                                        </span>
                                                    </span>
                                                </div>
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

<div class="modal fade" id="cancelSubscription" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    Subscription Cancellation
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('customer.cancelSubscription') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 col-md-12">
                        <!-- Title -->
                        <label class="form-label">Reason For Cancellation</label>
                        <textarea rows="10" name="reason" style="resize: none" class="form-control"></textarea>
                        <div class="invalid-feedback">Please provide a response.</div>
                    </div>

                    <input type="hidden" id="myid" name="subscription_id" />

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success ms-2">Cancel Subscription</button>
                    <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("navSettings").classList.add('show');
    document.getElementById("subscriptions").classList.add('active');
</script>

@endsection
