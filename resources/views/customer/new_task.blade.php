@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Create New Task ')
<style>
    .day-picker-container {
        position: relative;
        display: block;
        width: 100%
    }

    /* Input field */
    .day-input {
        width: 120px;
        padding: 6px;
        font-size: 14px;
    }

    /* Dropdown calendar */
    .day-picker {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
        padding: 10px;
        display: none;
        /* hidden by default */
    }

    .day-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }

    .day {
        text-align: center;
        padding: 6px 10px;
        background: #f6f7fb;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .day:hover {
        background: #0d6efd;
        color: #fff;
    }
</style>

<section class="container-fluid p-4">
    <div class="row">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-md-flex align-items-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <h1 class="mb-1 h2 fw-bold">Create New Task</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Create New Task</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <form id="taskForm" method="POST" action="{{ route('admin.storeTask') }}" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="offset-xl-1 col-xl-10 col-lg-10 col-md-12 col-12">
                <!-- Card -->
                <div class="card border-0 mb-4">
                    <!-- Card body -->
                    <div class="card-body">

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Project</label>
                            <select id="project" name="project" class="form-control" data-width="100%">
                                <option value="">Select Project</option>
                                @foreach ($projects as $proj)
                                    <option value="{{ $proj->id }}">{{ $proj->project_title }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a project.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Task Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control text-dark"
                                placeholder="Task Title" required>
                            <div class="invalid-feedback">Please provide a title.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Task Description <span class="text-danger">*</span></label>
                            <div id="editor" style="min-height: 250px">
                                <p>&nbsp;</p>
                            </div>
                            <input type="hidden" name="task_description" id="hiddenContent">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label d-block">What Type of Task is this? <span
                                    class="text-danger">*</span></label>
                            <div class="d-inline-flex">
                                @foreach ($taskCategories as $taskCat)
                                    <div class="form-check me-3">
                                        <input type="radio" id="category{{ $taskCat->id }}" name="task_category"
                                            class="form-check-input" value="{{ $taskCat->id }}" />
                                        <label class="form-check-label"
                                            for="category{{ $taskCat->id }}">{{ $taskCat->category }}</label>
                                    </div>
                                @endforeach
                                <div class="form-check">
                                    <input type="radio" id="categoryUnsure" name="task_category"
                                        class="form-check-input" value="" />
                                    <label class="form-check-label" for="categoryUnsure">Unsure</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label d-block">Is this a Recurring Task? <span
                                    class="text-danger">*</span></label>
                            <div class="d-inline-flex">
                                <div class="form-check me-3">
                                    <input type="radio" id="recurringYes" name="recurring" class="form-check-input"
                                        value="yes" />
                                    <label class="form-check-label" for="recurringYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="recurringNo" name="recurring" class="form-check-input"
                                        value="no" />
                                    <label class="form-check-label" for="recurringNo">No</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div id="autopt1" class="mb-3 col-md-12" style="display: none">
                            <!-- Title -->
                            <label class="form-label">If this is a Recurring Task, please specify the Recurring Task
                                Date <span class="text-danger">*</span></label>
                            <div class="day-picker-container">
                                <input id="dayInput" type="text" name="recurring_date" id="recurringDate"
                                    class="form-control text-dark" placeholder="Select Recurring Task Date">

                                <div class="day-picker" id="dayPicker">
                                    <div class="day-grid" id="dayGrid"></div>
                                </div>
                            </div>

                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label d-block">Would you like us to fix this using standard timelines or
                                schedule this for a later fix? <span class="text-danger">*</span></label>
                            <div class="d-inline-flex">
                                <div class="form-check me-3">
                                    <input type="radio" id="regularTimeline" name="timeline"
                                        class="form-check-input" value="regular timeline" />
                                    <label class="form-check-label" for="regularTimeline">Regular Timeline</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="laterSchedule" name="timeline"
                                        class="form-check-input" value="scheduled for later" />
                                    <label class="form-check-label" for="laterSchedule">Schedule For Later</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div id="autopt2" style="display: none">
                            <div class="mb-3 col-md-12">
                                <!-- Title -->
                                <label class="form-label">If you choose to Schedule this Task for later, please specify
                                    the Schedule Date <span class="text-danger">*</span></label>
                                <input type="date" name="scheduled_date" id="scheduledDate"
                                    class="form-control text-dark" placeholder="">
                                <div class="invalid-feedback">Please provide a response.</div>
                            </div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label d-block">Have you given us the required access (username,
                                password, account share, or shared logins via LastPass) to complete this Task? <span
                                    class="text-danger">*</span></label>
                            <div class="d-inline-flex">
                                <div class="form-check me-3">
                                    <input type="radio" id="sharedAccessYes" name="shared_access"
                                        class="form-check-input" value="yes" />
                                    <label class="form-check-label" for="sharedAccessYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="sharedAccessNo" name="shared_access"
                                        class="form-check-input" value="no" />
                                    <label class="form-check-label" for="sharedAccessNo">No</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Attached Files</label>
                            <input type="file" name="attached_files" id=""
                                class="form-control text-dark" placeholder="Attached Files">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>


                        <!-- button -->
                        <div class="col-md-8"></div>
                        <!-- button -->
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Submit And Proceed</button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</section>



<script type="text/javascript">
    document.getElementById("tasks").classList.add('active');
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

    document.querySelector('form').addEventListener('submit', function() {
        alert(quill.root.innerHTML);
        document.querySelector('#hiddenContent').value = quill.root.innerHTML;
    });

    const dayInput = document.getElementById('dayInput');
    const dayPicker = document.getElementById('dayPicker');
    const dayGrid = document.getElementById('dayGrid');

    // Generate days 1–31
    for (let i = 1; i <= 31; i++) {
        const el = document.createElement('div');
        el.className = 'day';
        el.textContent = `Day ${i}`;
        el.addEventListener('click', () => {
            dayInput.value = `Day ${i}`; // set input value
            dayPicker.style.display = 'none'; // close picker
        });
        dayGrid.appendChild(el);
    }

    // Show/hide picker on input click
    dayInput.addEventListener('click', () => {
        dayPicker.style.display = dayPicker.style.display === 'block' ? 'none' : 'block';
    });

    // Hide when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.day-picker-container')) {
            dayPicker.style.display = 'none';
        }
    });

</script>
@endsection
