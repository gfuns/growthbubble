@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | User Authentication Report')

<style>
    th,
    td {
        padding: 1rem !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    .summary-border {
        border-bottom: 1px solid #e2e8f0 !important;
    }

</style>
<!-- Container fluid -->
<div class="container-fluid p-3">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4 mb-4 d-flex justify-content-between align-items-center">
                <div class="mb-1 mb-lg-0">
                    <h1 class="mb-1 h4 fw-bold">
                        User Authentication Report
                    </h1>
                </div>

            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row justify-content-center">
        <div class="mt-0 ">

            <div class="col-lg-12 col-md-12 col-12">
                <div class="mb-3">
                    <a href="{{ route('report.home', [$workgroup]) }}" class="back-to-home-label">
                        <i class="nav-icon fe fe-arrow-left me-2"></i> Back to Administrative Reports
                    </a>
                </div>
                <!-- Card -->
                <div class="card mb-4">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-4">
                                <!-- row -->
                                <div class="row justify-content-between">
                                    <form id="form" name="form" method="POST"
                                        action="{{ route('report.searchUserAuths') }}">
                                        @csrf
                                        <div class=" row gx-3">
                                            <!-- Form -->
                                            <div class="col-md-3 mb-3 mb-lg-0">
                                                <!-- search -->
                                                <label for="currentPassword"><strong>Event Type</strong></label>
                                                <select id="gender" name="event_type" class="form-select"
                                                    data-width="100%" required>
                                                    <option value="null">Select Event Type</option>
                                                    <option value="null">All Events</option>
                                                    <option value="Login">User Login</option>
                                                    <option value="Logout">User Logout</option>
                                                </select>

                                                @error('event_type')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-3 mb-lg-0">
                                                <!-- search -->
                                                <label for="currentPassword"><strong>Start Date</strong></label>
                                                <input type="date" name="start_date" class="form-control"
                                                    placeholder="Start Date">

                                                @error('start_date')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror


                                            </div>
                                            <div class="col-md-3 mb-3 mb-lg-0">
                                                <!-- search -->
                                                <label for="currentPassword"><strong>End Date</strong></label>
                                                <input type="date" name="end_date" class="form-control"
                                                    placeholder="End Date">

                                                @error('end_date')
                                                    <span class="" role="alert">
                                                        <strong
                                                            style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                                    </span>
                                                @enderror


                                            </div>
                                            <div class="col-md-3 filterButton">
                                                <input type="hidden" name="workgroup_id" value="{{ $workgroup }}" />

                                                <button type="submit" class="btn btn-primary btn-md">Filter Records</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <!-- Card -->
                            <div class="card rounded-3">
                                <!-- Card header -->
                                <hr />
                                <h5 class="ms-4"><strong>
                                        User {{ ucwords(isset($eventType) ? $eventType : 'Login And Logout') }} Activities
                                        @if (isset($startDate) && isset($endDate))
                                            Between:
                                            {{ date_format($startDate, 'jS M, Y') }} And
                                            {{ date_format($endDate, 'jS M, Y') }}
                                        @endif
                                    </strong></h5>
                                <div>
                                    <!-- Table -->
                                    <div class="tab-content" id="tabContent">
                                        <!--Tab pane -->
                                        <div class="tab-pane fade active show" id="courses" role="tabpanel"
                                            aria-labelledby="courses-tab">
                                            <!-- Card header -->

                                            <!-- Table -->
                                            <div class="table-responsive mt-2">
                                                <table id="dataTableBasic"
                                                    class="table mb-0 text-nowrap table-hover table-centered table-with-checkbox"
                                                    style="font-size:12px;">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <td class="th">S/No.</td>
                                                            <td class="th">Surname</td>
                                                            <td class="th">First Name</td>
                                                            <td class="th">Other Names</td>
                                                            <td class="th">User Role</td>
                                                            <td class="th">Event Type</td>
                                                            <td class="th">Activity Date</td>
                                                            <td class="th">Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($activities as $act)
                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $act->user->last_name }}</td>
                                                                <td>{{ $act->user->first_name }}</td>
                                                                <td>{{ $act->user->other_names ?? 'Nil' }}</td>
                                                                <td>{{ $act->user->role->role }}</td>
                                                                <td>{{ $act->event }}</td>
                                                                <td>{{ date_format($act->created_at, 'jS M, Y g:ia') }}
                                                                </td>
                                                                <td class="align-middle">
                                                                    <button class="btn btn-primary btn-xs"
                                                                        type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#viewAuthDetails"
                                                                        data-backdrop="static"
                                                                        data-myid="{{ $act->id }}"
                                                                        data-surname="{{ $act->user->last_name }}"
                                                                        data-firstname="{{ $act->user->first_name }}"
                                                                        data-othernames="{{ $act->user->other_names ?? 'Nil' }}"
                                                                        data-role="{{ $act->user->role->role }}"
                                                                        data-event="{{ $act->event }}"
                                                                        data-description="{{ $act->description }}"
                                                                        data-ip="{{ $act->ip_address }}"
                                                                        data-agent="{{ $act->user_agent }}"
                                                                        data-datecreated="{{ date_format($act->created_at, 'jS F, Y g:ia') }}">View
                                                                        Details</button>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!-- Card Footer -->

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-lg-11 col-12">

        </div>
    </div>
</div>

<div class="modal fade" id="viewAuthDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mb-0" id="newCatgoryLabel">
                        View Authentication Log Details
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="">Surname</td>
                                <td class=""><span id="vsurname"></span></td>
                            </tr>

                            <tr>
                                <td class="">First Name</td>
                                <td class=""><span id="vfirstname"></span></td>
                            </tr>

                            <tr>
                                <td class="">Other Names</td>
                                <td class=""><span id="vothernames"></span></td>
                            </tr>

                            <tr>
                                <td class="">User Role</td>
                                <td class=""><span id="vrole"></span></td>
                            </tr>

                            <tr>
                                <td class="">Event Type</td>
                                <td class=""><span id="vevent"></span></td>
                            </tr>

                            <tr>
                                <td class="" style="white-space: nowrap">Event Description</td>
                                <td class=""><span id="vdescription"></span></td>
                            </tr>

                            <tr>
                                <td class="">IP Address</td>
                                <td class=""><span id="vip"></span></td>
                            </tr>

                            <tr>
                                <td class="">User Agent</td>
                                <td class=""><span id="vagent"></span></td>
                            </tr>

                            <tr>
                                <td class="">Activity Date</td>
                                <td class="" colspan="2"><span id="vdatecreated"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    document.getElementById("navReports").classList.add('show');
    document.getElementById("reports").classList.add('active');
</script>

@endsection
