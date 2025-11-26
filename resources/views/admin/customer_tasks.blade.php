@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Tasks')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Tasks
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ $product->product }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tasks
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 5) == true)
                    <!-- button -->
                    <div>
                        <a href="{{ route('admin.newCustomerTask', [$product->id]) }}"
                            class="btn btn-primary btn-sm me-2">Create New
                            Task</a>
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
                                            placeholder="Search Tasks Using Task Title or Customer Names......"
                                            value="{{ $search }}">
                                    </div>

                                </div>

                                <div class="col-6 col-lg-3">
                                    <!-- form select -->
                                    <select id="status" name="status" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="queued" @if ($status == 'queued') selected @endif>Queued
                                        </option>
                                        <option value="in progress" @if ($status == 'in progress') selected @endif>In
                                            Progress
                                        </option>
                                        <option value="completed" @if ($status == 'completed') selected @endif>
                                            Completed
                                        </option>
                                        <option value="on hold" @if ($status == 'on hold') selected @endif>On
                                            Hold
                                        </option>
                                        <option value="cancelled" @if ($status == 'cancelled') selected @endif>
                                            Cancelled
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Creator</th>
                                        <th scope="col">Status</th>
                                        {{-- <th scope="col">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($customerTasks as $cTask)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle">
                                                <a href="{{ route('admin.taskDetails', [$cTask->id]) }}">
                                                    {{ $cTask->title }}
                                                </a>
                                            </td>
                                            <td class="align-middle" data-bs-toggle="modal"
                                                data-bs-target="#viewCustomer" data-myid="{{ $cTask->user->id }}"
                                                data-representative="{{ $cTask->user->other_names.' '.$cTask->user->last_name }}"
                                                data-email="{{ $cTask->user->email }}"
                                                data-lastname="{{ $cTask->user->last_name }}"
                                                data-othernames="{{ $cTask->user->other_names }}"
                                                data-phone="{{ $cTask->user->phone_number }}"
                                                data-client="{{ $cTask->user->organization }}"
                                                data-photo="{{ $cTask->user->profile_photo ?? asset('assets/images/avatar/avatar.webp') }}"
                                                data-product="{{ $cTask->user->selectedProduct() }}"
                                                data-plan="{{ $cTask->user->selectedPlan() }}"
                                                data-effectivedate="{{ $cTask->user->effectiveDate() }}"
                                                data-expirydate="{{ $cTask->user->expiryDate() }}"
                                                data-status="{{ $cTask->user->subStatus() }}"
                                                data-address="{{ $cTask->user->contact_address ?? 'NIL' }}"
                                                style="cursor: pointer">
                                                {{ $cTask->user->organization }}
                                            </td>
                                            <td class="align-middle">{{ $cTask->creator() }}</td>
                                            <td>
                                                @if ($cTask->status == 'queued' || $cTask->status == 'on hold')
                                                    <span
                                                        class="badge text-primary bg-light-primary">{{ ucwords($cTask->status) }}</span>
                                                @elseif ($cTask->status == 'in progress')
                                                    <span
                                                        class="badge text-warning bg-light-warning">{{ ucwords($cTask->status) }}</span>
                                                @elseif ($cTask->status == 'completed')
                                                    <span
                                                        class="badge text-success bg-light-success">{{ ucwords($cTask->status) }}</span>
                                                @elseif ($cTask->status == 'cancelled')
                                                    <span
                                                        class="badge text-danger bg-light-danger">{{ ucwords($cTask->status) }}</span>
                                                @endif
                                            </td>

                                            {{-- <td class="align-middle">
                                                <div class="hstack gap-4">
                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>

                                                        <span class="dropdown-menu"><span
                                                                class="dropdown-header">Action</span>
                                                            <a href="{{ route('admin.taskDetails', [$cTask->id]) }}"
                                                                class="dropdown-item">
                                                                <i class="fe fe-eye dropdown-item-icon"></i>View
                                                                Task Details</a>

                                                        </span>
                                                    </span>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if (count($customerTasks) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no customer tasks found.
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (count($customerTasks) > 0 && $marker != null)
                                <div class="card-footer">
                                    <div class="row g-2 pt-3 me-4">
                                        <div class="col-md-9">Showing {{ $marker['begin'] }} to {{ $marker['end'] }}
                                            of
                                            {{ number_format($lastRecord) }} Records</div>

                                        <div class="col-md-3">
                                            {{ $customerTasks->appends(request()->input())->links() }}
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
                            <td class="">Client</td>
                            <td class=""><span id="vclient"></span></td>
                            <td class="" rowspan="10" align="right" style="text-align: center"><img
                                    src="" id="vphoto" class="img-responsive" style="max-width: 100px" />
                            </td>
                        </tr>

                        <tr>
                            <td class="">Representative</td>
                            <td class=""><span id="vrepresentative"></span></td>
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
                            <td class="">Contact Address</td>
                            <td class=""><span id="vaddress"></span></td>
                        </tr>

                        <tr>
                            <td class="">Selected Product</td>
                            <td class=""><span id="vproduct"></span></td>
                        </tr>

                        <tr>
                            <td class="">Subscribed Plan</td>
                            <td class=""><span id="vplan"></span></td>
                        </tr>

                        <tr>
                            <td class="">Subsciption Date</td>
                            <td class=""><span id="vsubdate"></span></td>
                        </tr>

                        <tr>
                            <td class="">Next Renewal Date</td>
                            <td class=""><span id="vrenewaldate"></span></td>
                        </tr>

                        <tr>
                            <td class="">Status</td>
                            <td class=""><span id="vstatus"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    const productId = {{ Js::from($product->id) }};
    document.getElementById("navProduct" + productId).classList.add('show');
    document.getElementById("tasks" + productId).classList.add('active');
</script>

@endsection
