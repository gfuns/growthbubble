@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Submitted Websites')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Submitted Websites
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Submitted Websites
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
                        <div class="card-header card-header-height d-flex align-items-center">
                            <h4 class="mb-0 text-dark">Customer:
                                {{ $customer->last_name . ' ' . $customer->other_names }}
                            </h4>
                        </div>
                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">S/No</th>
                                        <th scope="col">Website</th>
                                        <th scope="col">Website URL</th>
                                        <th scope="col">Admin URL</th>
                                        <th scope="col">Admin Username</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($websites as $web)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}.</td>
                                            <td class="align-middle"> Website {{ $loop->index + 1 }}</td>
                                            <td class="align-middle"> {{ $web->website_url }} </td>
                                            <td class="align-middle"> {{ $web->admin_url }} </td>
                                            <td class="align-middle"> {{ $web->username }} </td>
                                            <td class="align-middle">
                                                <div class="hstack gap-4">

                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>

                                                        <span class="dropdown-menu"><span
                                                                class="dropdown-header">Action</span>
                                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 3) == true)
                                                                <a style="cursor:pointer" class="dropdown-item"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#editWebsiteInfo"
                                                                    data-myid="{{ $web->id }}"
                                                                    data-websiteurl="{{ $web->website_url }}"
                                                                    data-adminurl="{{ $web->admin_url }}"
                                                                    data-username="{{ $web->username }}"><i
                                                                        class="fe fe-edit dropdown-item-icon"></i>Edit
                                                                    Website Information</a>
                                                            @endif
                                                        </span>
                                                    </span>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($websites) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no customer websites found.
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


@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 3) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editWebsiteInfo" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit Website Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateWebsite') }}">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Website URL <span class="text-danger">*</span></label>
                            <input id="websiteurl" type="text" name="website_url" class="form-control"
                                placeholder="Enter Website URL" required>
                            <div class="invalid-feedback">Please provide website url.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Admin URL <span class="text-danger">*</span></label>
                            <input id="adminurl" type="text" name="admin_url" class="form-control"
                                placeholder="Enter Admin URL" required>
                            <div class="invalid-feedback">Please provide admin url.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Admin Username <span class="text-danger">*</span></label>
                            <input id="username" type="text" name="admin_username" class="form-control"
                                placeholder="Enter Admin Username" required>
                            <div class="invalid-feedback">Please provide admin username.</div>
                        </div>

                        <input id="myid" type="hidden" name="website_id" class="form-control" required>

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
