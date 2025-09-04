@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Audit Trail Report')

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
                        Audit Trail Report
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
                                        action="{{ route('report.searchAuditTrails') }}">
                                        @csrf
                                        <div class=" row gx-3">
                                            <!-- Form -->
                                            <div class="col-md-3 mb-3 mb-lg-0">
                                                <!-- search -->
                                                <label for="currentPassword"><strong>Activity Performed</strong></label>
                                                <select id="gender" name="event_type" class="form-select"
                                                    data-width="100%" required>
                                                    <option value="null">Select Activity Type</option>
                                                    <option value="null">All Activities</option>
                                                    <option value="created">New Record Creation</option>
                                                    {{-- <option value="retrieved">Record Retrieval</option> --}}
                                                    <option value="updated">Record Update</option>
                                                    <option value="deleted">Record Deletion</option>
                                                    <option value="restored">Record Restoration</option>
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

                                                <button type="submit" class="btn btn-primary btn-md">Filter
                                                    Records</button>

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
                                        Audit Trail For
                                        <u>{{ ucwords(isset($eventType) ? 'User Activity: ' . $eventType : 'All User Activities') }}</u>
                                        @if (isset($startDate) && isset($endDate))
                                            - Between
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
                                                            <td class="th">Activity</td>
                                                            <td class="th">Activity Date</td>
                                                            <td class="th">Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($activities as $act)
                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ isset($act->user) ? $act->user->last_name : "Coral" }}</td>
                                                                <td>{{ isset($act->user) ? $act->user->first_name : "Pay" }}</td>
                                                                <td>{{ isset($act->user) ? ($act->user->other_names ?? "Nil") : 'Technologies'  }}</td>
                                                                <td>{{ isset($act->user) ? $act->user->role->role : "Notifaction" }}</td>
                                                                <td>{{ $act->event() }}</td>
                                                                <td>{{ date_format($act->created_at, 'jS M, Y g:ia') }}
                                                                </td>
                                                                <td class="align-middle">
                                                                    <button class="btn btn-primary btn-xs"
                                                                        type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#viewAuditDetails"
                                                                        data-backdrop="static"
                                                                        data-myid="{{ $act->id }}"
                                                                        data-surname="{{ isset($act->user) ? $act->user->last_name : "Coral" }}"
                                                                        data-firstname="{{ isset($act->user) ? $act->user->first_name : "Pay" }}"
                                                                        data-othernames="{{ isset($act->user) ? ($act->user->other_names ?? "Nil") : 'Technologies' }}"
                                                                        data-role="{{ isset($act->user) ? $act->user->role->role : "Notifaction" }}"
                                                                        data-event="{{ $act->event() }}"
                                                                        data-table="{{ preg_replace('/App\\\\Models\\\\/', '', $act->auditable_type) }}"
                                                                        data-oldrecord="{{ $act->oldValues() }}"
                                                                        data-newrecord="{{ $act->newValues() }}"
                                                                        data-ip="{{ $act->ip_address }}"
                                                                        data-agent="{{ $act->user_agent ?? "API Handshake" }}"
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

<div class="modal fade" id="viewAuditDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    View Audit Trail Details
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
                            <td class="" style="white-space: nowrap">Affected Table</td>
                            <td class=""><span id="vmodel"></span> Table</td>
                        </tr>

                        <tr>
                            <td class="" style="white-space: nowrap">Old Values</td>
                            <td class=""><span id="voldvalues"></span></td>
                        </tr>

                        <tr>
                            <td class="" style="white-space: nowrap">New Values</td>
                            <td class=""><span id="vnewvalues"></span></td>
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
