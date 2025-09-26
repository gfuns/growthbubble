@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | My Tickets')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        My Tickets
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                My Tickets
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- button -->
                <div>
                    <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#newTicket">Create New
                        Ticket</a>
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
                        <form id="form" name="form" method="GET">
                            <div class="p-4 row gx-3">
                                <!-- Form -->
                                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="search" type="search" class="form-control ps-6"
                                            placeholder="Search Tickets Using Subject......"
                                            value="{{ $search }}">
                                    </div>

                                </div>

                                <div class="col-6 col-lg-3">
                                    <!-- form select -->
                                    <select id="status" name="status" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="open" @if ($status == 'open') selected @endif>Open
                                        </option>
                                        <option value="on hold" @if ($status == 'on hold') selected @endif>On
                                            Hold
                                        </option>
                                        <option value="closed" @if ($status == 'closed') selected @endif>
                                            Closed
                                        </option>
                                    </select>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <!-- form select -->
                                    <select id="period" name="period" class="form-select"
                                        onChange="this.form.submit()">
                                        <option value="">All Time</option>
                                        <option value="30" @if ($period == '30') selected @endif>30 Days
                                        </option>
                                        <option value="90" @if ($period == '90') selected @endif>90 Days
                                        </option>
                                        <option value="365" @if ($period == '365') selected @endif>1 Year
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
                                        <th scope="col">Subject</th>
                                        <th scope="col">Last Replier</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Last Activity</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}.</td>
                                            <td class="align-middle"><a
                                                    href="{{ route('customer.ticketDetails', [$ticket->id]) }}" class="">{{ $ticket->subject }}</a>
                                            </td>
                                            <td class="align-middle">{{ $ticket->lastReplier() }}</td>
                                            <td class="align-middle">
                                                {{ date_format($ticket->created_at, 'jS M, Y g:ia') }}</td>
                                            <td class="align-middle">{{ $ticket->lastActivity() }}</td>
                                            <td>
                                                @if ($ticket->status == 'open')
                                                    <span
                                                        class="badge text-success bg-light-success">{{ ucwords($ticket->status) }}</span>
                                                @elseif ($ticket->status == 'on hold')
                                                    <span
                                                        class="badge text-warning bg-light-warning">{{ ucwords($ticket->status) }}</span>
                                                @elseif ($ticket->status == 'closed')
                                                    <span
                                                        class="badge text-danger bg-light-danger">{{ ucwords($ticket->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if (count($tickets) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no tickets found.
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (count($tickets) > 0 && $marker != null)
                                <div class="card-footer">
                                    <div class="row g-2 pt-3 me-4">
                                        <div class="col-md-9">Showing {{ $marker['begin'] }} to {{ $marker['end'] }}
                                            of
                                            {{ number_format($lastRecord) }} Records</div>

                                        <div class="col-md-3">
                                            {{ $tickets->appends(request()->input())->links() }}
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

<div class="modal fade" id="newTicket" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    Submit New Ticket.
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="needs-validation" novalidate method="post"
                    action="{{ route('customer.submitTicket') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" id="" class="form-control text-dark"
                                placeholder="Subject">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Description </label>
                            <div id="editor" style="height: 250px">
                                <p>&nbsp;</p>
                            </div>
                            <input type="hidden" name="description" id="hiddenContent">
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Attach Files</label>
                            <input type="file" name="attached_files" id=""
                                class="form-control text-dark" placeholder="Attached Files">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button id="submitbutton2" class="btn btn-success" type="submit">Submit Ticket</button>
                            <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    document.getElementById("tickets").classList.add('active');
</script>

@endsection
@section('customjs')
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    quill.on('text-change', function() {
        document.getElementById('hiddenContent').value = quill.root.innerHTML;
    });
</script>
@endsection
