@extends('admin.layouts.app')

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
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Ticket Details</a>
                            </li>
                        </ol>
                    </nav>
                </div>

                @if ($ticket->status != 'closed')
                    <div>
                        <a href="{{ route('admin.closeTicket', [$ticket->id]) }}" class="btn btn-primary btn-sm me-2"
                            onclick="return confirm('Are you sure you want to close this customer ticket?');"><i
                                class="fe fe-x"></i>
                            Close Ticket</a>
                    </div>
                @endif
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
                                <label class="form-label text-dark col-md-2">Subject:</label>
                                <span class="text-dark col-md-10">{{ $ticket->subject }}</span>
                            </div>

                            <div class="mb-3 ">
                                <label class="form-label text-dark col-md-2">Date Created:</label>
                                <span class="text-dark col-md-10">{{ $ticket->created_at->diffforhumans() }}</span>
                            </div>

                            <div class="mb-3 ">
                                <label class="form-label text-dark col-md-2">Status:</label>
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

                            <h4 class="mb-3 text-dark">Post Reply:</h4>

                            <form class="needs-validation" novalidate method="post"
                                action="{{ route('admin.replyTicket') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- form group -->

                                    <div class="mb-3 col-12">
                                        <label class="form-label text-dark">Comment </label>
                                        <div id="editor" style="height: 150px">
                                            <p>&nbsp;</p>
                                        </div>
                                        <input type="hidden" name="description" id="hiddenContent">
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <!-- Title -->
                                        <label class="form-label text-dark">Attach Files</label>
                                        <input type="file" name="attached_files" id=""
                                            class="form-control text-dark" placeholder="Attached Files">
                                        <div class="invalid-feedback">Please provide a response.</div>
                                    </div>

                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                                    <!-- button -->
                                    <div class="col-12 ">
                                        <button id="submitbutton2" class="btn btn-success w-25" type="submit">Post
                                            Reply</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header card-header-height d-flex align-items-center">
                        <h4 class="mb-0 text-dark">Ticket Replies:</h4>
                    </div>

                    <!-- card body -->
                    <div class="card-body" style="padding: 0px 12px">
                        <!-- form -->

                        @foreach ($comments as $coment)
                            <div class="row" style="border-top: 2px solid #001f8e">
                                <div class="col-md-2 username d-flex pt-4 px-3 staff"
                                    style="border-right: 2px solid #ccc;">
                                    <div class="text-center mt-3 mb-4">
                                        <h5 class="mb-2 float-none text-dark" style="line-break: anywhere;">
                                            {{ $coment->user->last_name . ' ' . $coment->user->other_names }}</h5>
                                        <span class="badge w-100"
                                            style="font-weight: bold; letter-spacing: 0.6px; background: @if ($coment->role == 'staff') #3D4DD4 @else #6c757d @endif">
                                            {{ ucwords($coment->role) }} </span>
                                    </div>
                                </div>

                                <div class="col-md-10 p-0">
                                    <div class="card-footer py-2 px-0" style="border-bottom: 1px solid #ccc;">
                                        <span class="username ms-3">
                                            <span class="text-dark pr-2" style="font-size: 12px">Posted on:
                                                {{ date_format($coment->created_at, 'F j, Y g:i: A') }}</span>
                                        </span>
                                    </div>
                                    <div class="ms-3 mt-2">
                                        <div class="w-100 m-0 text-dark">
                                            @php echo $coment->comment; @endphp
                                        </div>
                                    </div>
                                    <div class="ms-3 mt-2 mb-3">
                                        @if (isset($coment->uploaded_document))
                                            <a href="{{ $coment->uploaded_document }}" target="_blank">[ View
                                                Attachement ]</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
