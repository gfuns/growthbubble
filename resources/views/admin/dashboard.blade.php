@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Business Dashboard')
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex justify-content-between align-items-center">
                <div class="mb-3 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold">Administrative Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="col-lg-12 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Filed Returns</h4>
                            <div>
                                <span class="bi bi-pencil-square fs-3 text-success"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-0">
                            <span class="fs-5">&#8358;{{ number_format($params['regs'], 2) }}</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Personal Income Taxes</h4>
                            <div>
                                <span class="bi bi-arrow-clockwise fs-3 text-success"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-0">&#8358;{{ number_format($params['renewals'], 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Development Levies</h4>
                            <div>
                                <span class="fa fa-gavel fs-3 text-success"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-0">&#8358;{{ number_format($params['poas'], 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">Other Taxes/Revenue</h4>
                            <div>
                                <span class="bi bi-award-fill fs-3 text-success"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-0">&#8358;{{ number_format($params['awards'], 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <!-- Card -->
                <div class="card mb-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <h4 class="fs-6 text-uppercase fw-bold ls-md">MDA Taxes/Revenue</h4>
                            <div>
                                <span class="bi bi-cash-coin fs-3 text-success"></span>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-0">&#8358;{{ number_format($params['prFees'], 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <!-- Card -->
            <div class="card mb-4">
                <!-- Card header -->
                <div
                    class="card-header align-items-center card-header-height d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Revenue Generation Graph/Statistics</h4>
                    </div>
                </div>
                <!-- Card body -->
                <div id="" class="card-body">
                    <!-- Earning chart -->
                    <canvas id="myLineChart" height="445"></canvas>
                    {{-- <div id="myLineChart"></div> --}}
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    document.getElementById("dashboard").classList.add('active');
</script>

@include('admin.layouts.chart')

@endsection
