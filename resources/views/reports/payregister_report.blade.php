@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Pay Register Report')
<style type="text/css">
    .button-container {
        display: flex;
        /* justify-content: space-between; */
        padding-left: 35px;
    }

    .button-container button {
        margin-right: 15px;
        /* Adjust as needed */
    }

    .custom-select {
        --geeks-form-select-bg-img: url(data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E);
        -moz-padding-start: calc(1rem - 3px);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: var(--geeks-input-bg);
        background-image: var(--geeks-form-select-bg-img), var(--geeks-form-select-bg-icon, none);
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 16px 12px;
        border: var(--geeks-border-width) solid var(--geeks-input-border);
        border-radius: .375rem;
        color: #000;
        display: block;
        font-size: 12px;
        /* font-weight: bold; */
        line-height: 1.6;
        padding: .2rem 3rem .2rem 1rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        width: 100%;
    }
</style>

@php
    $navWG = Session::get('workGroup');
@endphp
<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4 mb-4 d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h4 fw-bold">
                        Pay Register Report
                    </h1>
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
                        <!-- table -->
                        <form method="POST" action="{{ route('report.processPayRegisterReport') }}" target="_blank">
                            @csrf
                            <div class="col-12 col-lg-7 table-responsive overflow-y-hidden ps-4 mt-5 pe-4 mb-5">
                                <table class="table mb-0 text-nowrap table-hover table-centered table-bordered"
                                    style="font-size: 12px">
                                    <thead>
                                        <tr>
                                            <th scope="col">Period</th>
                                            <td scope="col">
                                                <select id="period" name="period" class="custom-select" data-width="100%" required>
                                                    <option value="All">---All---</option>
                                                    @foreach ($payrolPeriods as $period)
                                                        <option value="{{ $period->period }}">{{ $period->period }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('branch')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Branch</th>
                                            <td scope="col">
                                                <select id="branch" name="branch" class="custom-select" data-width="100%" required>
                                                    <option value="All">---All---</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->branch }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('branch')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Department</th>
                                            <td scope="col">
                                                <select id="department" name="department" class="custom-select" data-width="100%">
                                                    <option value="All">---All---</option>
                                                </select>
                                                @error('department')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Unit</th>
                                            <td scope="col">
                                                <select id="unit" name="unit" class="custom-select" data-width="100%">
                                                    <option value="All">---All---</option>
                                                </select>
                                                @error('unit')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pay Group</th>
                                            <td scope="col">
                                                <select id="paygroup" name="paygroup" class="custom-select" data-width="100%">
                                                    <option value="All">---All---</option>
                                                    @foreach ($payGroups as $paygroup)
                                                        <option value="{{ $paygroup->id }}">{{ $paygroup->paygroup }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('paygroup')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Level</th>
                                            <td scope="col">
                                                <select id="level" name="level" class="custom-select" data-width="100%">
                                                    <option value="All">---All---</option>
                                                </select>
                                                @error('level')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="col">Format</th>
                                            <td scope="col">
                                                <select id="format" name="format" class="custom-select"
                                                    data-width="100%" required>
                                                    <option value="">---Select---</option>
                                                    <option value="excel">Excel</option>
                                                    <option value="pdf">PDF</option>
                                                </select>
                                                @error('paygroup')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>

                                            <input id type="hidden" value="{{ $navWG->id }}" name="workgroup" />
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="2"><button
                                                    class="btn btn-primary btn-sm">Submit</button></th>
                                        </tr>
                                    </thead>

                                </table>
                                <a href="{{ route('report.home', [$navWG->id]) }}"><button
                                        class="btn btn-default btn-sm mt-4" type="button"
                                        style="border: 1px solid #ccc; font-size: 10px">
                                        << Back to List of Reports</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script type="text/javascript">
    document.getElementById("navReports").classList.add('show');
    document.getElementById("reports").classList.add('active');
</script>

@endsection

@section('customjs')
<script type="text/javascript">
    $('#paygroup').change(function() {
        var workgroup = {{ Js::from($navWG->id) }};
        var paygroup = $(this).val();
        $('#level').html('<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
        $.ajax({
            url: "/ajax/get-levels/" + workgroup + "/" + paygroup,
            type: "GET",
            dataType: "json",
            success: function(data) {
                var options = "<option value='All'>---All---</option>";
                $.each(data, function(key, value) {
                    options += "<option value='" + key + "'>" + value + "</option>";
                });
                $('#level').html(options);
            }
        });
    });

    $('#branch').change(function() {
        var workgroup = {{ Js::from($navWG->id) }};
        var branch = $(this).val();
        $('#department').html(
        '<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
        $('#unit').html(''); // Show "Fetching data" message
        $.ajax({
            url: "/ajax/get-departments/" + workgroup + "/" + branch,
            type: "GET",
            dataType: "json",
            success: function(data) {
                var options = "<option value='All'>---All---</option>";
                $.each(data, function(key, value) {
                    options += "<option value='" + key + "'>" + value + "</option>";
                });
                $('#department').html(options);
            }
        });
    });

    $('#department').change(function() {
        var workgroup = {{ Js::from($navWG->id) }};
        var branch = $(this).val();
        $('#unit').html(
        '<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
        $.ajax({
            url: "/ajax/get-units/" + workgroup + "/" + branch,
            type: "GET",
            dataType: "json",
            success: function(data) {
                var options = "<option value='All'>---All---</option>";
                $.each(data, function(key, value) {
                    options += "<option value='" + key + "'>" + value + "</option>";
                });
                $('#unit').html(options);
            }
        });
    });
</script>
@endsection
