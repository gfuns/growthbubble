@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Ticket Details')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold">Ticket Details </h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Ticket Details</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <div class="py-3">
        <!-- row -->
        <div class="row">
            <div class="col-md-12 col-12 mb-5">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- form -->
                        <div class="row">
                            <div class="mb-3 row">
                                <label class="form-label col-md-2">Subject:</label>
                                <span class="text-dark col-md-10">{{ $ticket->subject }}</span>
                            </div>

                            <div class="mb-3 ">
                                <label class="form-label col-md-2">Date Created:</label>
                                <span class="text-dark col-md-10">{{ $ticket->created_at->diffforhumans() }}</span>
                            </div>

                            <div class="mb-3 ">
                                <label class="form-label col-md-2">Status:</label>
                                <span class="text-dark col-md-10">
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
                                </span>
                            </div>

                            <hr />

                            <h4 class="mb-3">Post Reply:</h4>

                            <form class="needs-validation" novalidate method="post"
                                action="{{ route('customer.replyTicket') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- form group -->

                                    <div class="mb-3 col-12">
                                        <label class="form-label">Comment </label>
                                        <div id="editor" style="height: 150px">
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

                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                                    <!-- button -->
                                    <div class="col-12 ">
                                        <button id="submitbutton2" class="btn btn-success w-25" type="submit">Post Reply</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>


                <div class="card mt-3">
                    <div class="card-header card-header-height d-flex align-items-center">
                        <h4 class="mb-0">Ticket Replies:</h4>
                    </div>

                    <!-- card body -->
                    <div class="card-body">
                        <!-- form -->
                        <div class="row">
                            <div class="mb-3 ">
                                <label class="form-label d-block">Subject:</label>
                                <span class="text-dark">{{ $ticket->subject }}</span>
                            </div>

                            <div class="mb-3 ">
                                <label class="form-label d-block">Date Created:</label>
                                <span class="text-dark">{{ $ticket->created_at->diffforhumans() }}</span>
                            </div>

                            <div class="mb-3 ">
                                <label class="form-label d-block">Status:</label>
                                <span class="text-dark">
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
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
    </div>
</section>

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
