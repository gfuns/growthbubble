@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Platform Features')


<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold">Platform Features</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Platform Features</a>
                            </li>
                        </ol>
                    </nav>
                </div>

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
                                            <th>Feature</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table body -->
                                        @foreach ($platformFeatures as $feature)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $feature->feature }}</td>
                                                <td>{{ $feature->description }}</td>
                                            </tr>
                                        @endforeach

                                        @if (count($platformFeatures) < 1)
                                            <tr>
                                                <td colspan="3">
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
&nbsp;
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    document.getElementById("platSettings").classList.add('show');
    document.getElementById("features").classList.add('active');
</script>

@endsection

