@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Task Details')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold">Task Details </h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                             <li class="breadcrumb-item">
                                <a href="#">{{ $product->product }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Task Details</a>
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
            <div class="col-md-8 col-12 mb-5">
                <div id="scrollContainer">
                    <div id="assessmentInfo">
                        <!-- card -->
                        <div class="card">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- form -->
                                <div class="row mb-2">
                                    <div class="mb-3 col-md-7">
                                        <label class="form-label d-block">Task Title:</label>
                                        <span class="text-dark">{{ $task->title }}</span>
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label class="form-label d-block">Task Category:</label>
                                        <span class="text-dark">{{ $task->category->category }}</span>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="mb-1 col-md-12">
                                        <label class="form-label d-block">Task Description:</label>
                                        <span class="text-dark">@php echo $task->task_description; @endphp</span>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                   <div class="mb-3 col-md-7">
                                        <label class="form-label d-block">Priority:</label>
                                        <span class="text-dark">{{ ucwords($task->priority) }}</span>
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label class="form-label d-block">All Necessary Access Provided?</label>
                                        <span class="text-dark">{{ ucwords($task->provided_access) }}</span>
                                    </div>

                                </div>

                                <div class="row mb-2">
                                    <div class="mb-3 col-md-7">
                                        <label class="form-label d-block">Website</label>
                                        <span class="text-dark">{{$task->website }}</span>
                                    </div>

                                    <div class="mb-3 col-md-5">
                                        <label class="form-label d-block">Date Created:</label>
                                        <span
                                            class="text-dark">{{ date_format(new $task->created_at, 'jS F, Y') }}</span>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="mb-3 col-md-5">
                                        <label class="form-label d-block">Task Status:</label>
                                        @if ($task->status == 'queued' || $task->status == 'on hold')
                                            <span
                                                class="badge text-primary bg-light-primary">{{ ucwords($task->status) }}</span>
                                        @elseif ($task->status == 'in progress')
                                            <span
                                                class="badge text-warning bg-light-warning">{{ ucwords($task->status) }}</span>
                                        @elseif ($task->status == 'completed')
                                            <span
                                                class="badge text-success bg-light-success">{{ ucwords($task->status) }}</span>
                                        @elseif ($task->status == 'cancelled')
                                            <span
                                                class="badge text-danger bg-light-danger">{{ ucwords($task->status) }}</span>
                                        @endif
                                    </div>
                                </div>


                                @if (isset($task->attached_file))
                                    <div class="row">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label d-block">Uploaded Files:</label>
                                            <span class="text-dark">
                                                <ol style="padding-left:17px; margin-bottom:0px">
                                                    <li><a href="{{ $task->attached_file }}"
                                                            target="_blank">{{ $task->attached_file }}</a></li>
                                                </ol>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-8 mt-3 mb-5">&nbsp;</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">

                <!-- card -->
                <div id="assessmentSummary" class="card mb-4">
                    <!-- card body -->
                    <div class="card-header card-header-height d-flex align-items-center">
                        <h4 class="mb-0">Conversations</h4>
                        <span
                            class="badge bg-danger text-white ms-auto">{{ number_format(count($conversations), 0) }}</span>
                    </div>

                    <div class="card-body">

                        @if (count($conversations) > 0)
                            <div class="mb-2">
                                This task has {{ number_format(count($conversations), 0) }} conversations.
                            </div>
                            <div class="col-md-8 mb-2"></div>
                            <div class="col-12 mb-4">
                                <button class="btn btn-outline-success w-100" type="button" data-bs-toggle="modal"
                                    data-bs-target="#viewConversations">View Conversations</button>

                            </div>
                        @else
                            <div class="mb-2">
                                This task is yet to have any conversation.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- card -->
                <div class="card" style="max-height: 425px;">
                    <!-- Card header -->
                    <div class="card-header card-header-height d-flex align-items-center">
                        <h4 class="mb-0">Recent Task Activities</h4>
                    </div>
                    <!-- Card body -->
                    <div class="card-body scrollable-card-body">
                        @if (count($activities) < 1)
                            <div class="mb-2">
                                This task is yet to have any activity.
                            </div>
                        @endif

                        <!-- List group -->
                        <ul class="list-group list-group-flush list-timeline-activity">
                            @foreach ($activities as $activity)
                                <li class="list-group-item px-0 pt-0 border-0 mb-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                                <img alt="avatar" src="{{ $activity->user->profile_photo }}"
                                                    class="rounded-circle">
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <div class="d-flex flex-column gap-1">
                                                <div>
                                                    <h4 class="mb-0 h5">
                                                        {{ $activity->user->last_name . ' ' . $activity->user->other_names }}
                                                        @if ($activity->user->id == Auth::user()->id)
                                                            (You)
                                                        @endif
                                                    </h4>
                                                    <p class="mb-0">
                                                        @php
                                                            $plainText = strip_tags($activity->activity);
                                                            $comment = Str::limit(strip_tags($plainText), 80, '...');
                                                        @endphp

                                                        <a href="" data-bs-toggle="modal"
                                                            data-bs-target="#viewActivity"
                                                            data-activity="{{ $activity->user->last_name . ' ' . $activity->user->other_names . ' ' . $activity->activity }}"
                                                            class="text-dark">
                                                            @php
                                                                echo $comment;
                                                            @endphp
                                                        </a>
                                                    </p>
                                                </div>
                                                <div>
                                                    <span
                                                        class="fs-6">{{ $activity->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>

<div class="modal fade" id="viewActivity" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p id="activity"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateTask" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    Add Comment and Provide Insight On Your Task.
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="needs-validation" novalidate method="post" action="{{ route('customer.updateTask') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->

                        <div class="mb-3 col-12">
                            <label class="form-label">Comment </label>
                            <div id="editor" style="height: 250px">
                                <p>&nbsp;</p>
                            </div>
                            <input type="hidden" name="comment" id="hiddenContent">

                            <div class="invalid-feedback">Please select team member.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Attach Files</label>
                            <input type="file" name="attached_files" id=""
                                class="form-control text-dark" placeholder="Attached Files">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <input type="hidden" name="task_id" value="{{ $task->id }}"
                            class="form-control text-dark" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button id="submitbutton2" class="btn btn-success" type="submit">Submit Task
                                Update</button>
                            <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewConversations" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    Conversations For This Task Are Below:
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 650px;">

                <div class="scrollable-card-body">

                    @foreach ($conversations as $chat)
                        @if (Auth::user()->id == $chat->user_id)
                            <!-- My message -->
                            <div class="d-flex justify-content-end mb-3">
                                <div class="p-2 rounded bg-success text-white" style="max-width: 75%;">
                                    @php echo $chat->comment; @endphp
                                </div>
                            </div>

                            @if (isset($chat->uploaded_file))
                                <div class="d-flex justify-content-end mb-3">
                                    <div class="rounded border" style="max-width: 20%;">
                                        <img src="https://res.cloudinary.com/bdicprod/image/upload/v1757083276/lg2qyfithgnjbqw0pdnp.jpg"
                                            class="img-fluid rounded" alt="Shared Image">
                                    </div>
                                </div>
                            @endif
                        @else
                            <!-- Other person's message -->
                            <div class="d-flex mb-3">
                                <img src="{{ $chat->user->profile_photo ?? 'https://res.cloudinary.com/bdicprod/image/upload/v1757083276/lg2qyfithgnjbqw0pdnp.jpg' }}"
                                    class="rounded-circle me-2" alt="User" style="height: 35px; width:35px">
                                <div>
                                    <h6 class="mb-1 small fw-bold">
                                        {{ $chat->user->last_name . ' ' . $chat->user->other_names }}</h6>
                                    <div class="p-2 rounded bg-light border" style="max-width: 75%;">
                                        @php echo $chat->comment; @endphp
                                    </div>
                                </div>
                            </div>

                            @if (isset($chat->uploaded_file))
                                <div class="d-flex mb-3">
                                    <div class="rounded border" style="margin-left: 45px; max-width: 20%;">
                                        <img src="https://res.cloudinary.com/bdicprod/image/upload/v1757083276/lg2qyfithgnjbqw0pdnp.jpg"
                                            class="img-fluid rounded" alt="Shared Image">
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach

                </div>

                <div class="modal-footer">
                    <div class="col-12 mb-4">
                        <button class="btn btn-outline-success w-100" type="button" data-bs-toggle="modal"
                            data-bs-target="#updateTask" data-priority="{{ $task->priority }}"
                            data-status="{{ $task->status }}">Add Comment</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const productId = {{ Js::from($product->id) }};
    document.getElementById("navProduct" + productId).classList.add('show');
    document.getElementById("tasks" + productId).classList.add('active');
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
