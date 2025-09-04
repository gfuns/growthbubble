@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Select Work Group')
<style type="text/css">
    .candidate-education-content .circle {
        border-radius: 40px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        width: 35px;
    }

    .bg-soft-primary {
        background-color: rgba(118, 109, 244, .15) !important;
        color: #766df4 !important;
    }

    .bg-soft-success {
        background-color: #d1f5ea !important;
        color: #20c997 !important;
    }

    .bg-soft-danger {
        background-color: #fad9d8 !important;
        color: #dc3545 !important;
    }
</style>

<!-- Page Header -->
<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h2 fw-bold">Select Work Group </h1>
                    <!-- Breadcrumb -->

                </div>
            </div>

        </div>
    </div>
    <div class="py-3">
        <div class="row">

            @foreach ($workGroups as $wg)
                <div class="col-lg-3 col-12">
                    <!-- Card -->
                    <a href="{{ route("selectWorkGroup", [$wg->id]) }}">
                        <div class="card mb-4">
                            <!-- Card body -->
                            <div class="card-body bg-light-primary">
                                <div class="d-flex align-items-center mb-1 lh-1">
                                    <div class="pe-3">
                                        <i class="fe fe-users" style="font-size: 28px"></i>
                                    </div>
                                    <div>
                                        <h4 class="fs-4 text-uppercase fw-bold text-left">{{ $wg->work_group }}</h4>
                                        <h6 class="fw-bold">
                                            {{ ucwords($wg->status) }}
                                        </h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>

</section>

<script>
    //document.getElementById("navDashboard").classList.add('show');
    document.getElementById("dashboard").classList.add('active');
</script>

@endsection
