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

    .task-tags {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        font-family: Arial, sans-serif;
    }

    .tag-item {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 14px;
        cursor: pointer;
        background: #f8f8f8;
        border: 1px solid #eee;
        transition: 0.2s ease-in-out;
        position: relative;
    }

    .tag-item input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: #333;
    }

    .tag-item:hover {
        background: #f0f0f0;
    }

    /* COLORS */
    .design {
        background: #e9f5ff;
        border-color: #cde9ff;
    }

    .design .tag-text {
        color: #007bff;
    }

    .web {
        background: #fff2e8;
        border-color: #ffd9c4;
    }

    .web .tag-text {
        color: #e66a00;
    }

    .automation {
        background: #e8f7ed;
        border-color: #c9e8d2;
    }

    .automation .tag-text {
        color: #199647;
    }

    .video {
        background: #e8eeff;
        border-color: #cbd7ff;
    }

    .video .tag-text {
        color: #3054ff;
    }

    .copywriting {
        background: #f3f0ff;
        border-color: #d8d3fa;
    }

    .copywriting .tag-text {
        color: #2d2179;
    }

    .copywriting .beta {
        background: #ffb57a;
        padding: 1px 5px;
        font-size: 10px;
        border-radius: 8px;
        color: white;
        margin-left: 4px;
    }

    .security {
        background: #ffe8e8;
        border-color: #ffcdcd;
    }

    .security .tag-text {
        color: #ff2f2f;
    }

    .unsure {
        background: #f1f1f1;
        border-color: #dcdcdc;
    }

    .unsure .tag-text {
        color: #555;
    }

    /* SPECIAL Styling for "Not a Task?" */
    .not-task {
        padding: 6px 12px;
        background: #e2f3ff;
        color: #00a6ff;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid #bde7ff;
        transition: 0.2s;
    }

    .not-task:hover {
        background: #d7eeff;
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
                                <a href="#">{{ $product->product }}</a>
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
    <form id="taskForm" method="POST" action="{{ route('customer.storeTask') }}" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card border-0 mb-4">
                    <!-- Card body -->
                    <div class="card-body">

                        <div class="mb-5 col-md-12">
                            <div class="task-tags">

                                <label class="tag-item design">
                                    <input type="radio"  name="fake_category" class="form-check-input">
                                    <span class="tag-icon">🎨</span>
                                    <span class="tag-text">Design</span>
                                </label>

                                <label class="tag-item web">
                                    <input type="radio"  name="fake_category" class="form-check-input">
                                    <span class="tag-icon">🌐</span>
                                    <span class="tag-text">Web</span>
                                </label>

                                <label class="tag-item automation">
                                    <input type="radio"  name="fake_category" class="form-check-input">
                                    <span class="tag-icon">⚙️</span>
                                    <span class="tag-text">Automation</span>
                                </label>

                                <label class="tag-item video">
                                    <input type="radio"  name="fake_category" class="form-check-input">
                                    <span class="tag-icon">📹</span>
                                    <span class="tag-text">Video</span>
                                </label>

                                <label class="tag-item copywriting">
                                    <input type="radio"  name="fake_category" class="form-check-input">
                                    <span class="tag-icon">✍️</span>
                                    <span class="tag-text">Copywriting</span>
                                    <span class="beta">Beta</span>
                                </label>

                                <label class="tag-item security">
                                    <input type="radio"  name="fake_category" class="form-check-input">
                                    <span class="tag-icon">🛑</span>
                                    <span class="tag-text">Security</span>
                                </label>

                                <label class="tag-item unsure">
                                    <input type="radio"  name="fake_category" class="form-check-input">
                                    <span class="tag-icon">❓</span>
                                    <span class="tag-text">Unsure</span>
                                </label>

                            </div>
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
                            </div>
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Summary <span class="text-danger">*</span></label>
                            <input type="text" name="task_summary" id="summary" class="form-control text-dark"
                                placeholder="Enter 1 sentence of task..." required>
                            <div class="invalid-feedback">Please enter 1 sentence of task...</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Select Website</label>
                            <select id="project" name="website" class="form-control" data-width="100%">
                                <option value="">Select Website</option>
                                @foreach ($websites as $website)
                                    <option value="{{ $website->website_url }}">{{ $website->website_url }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select website.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Explanation <span class="text-danger">*</span></label>
                            <div id="editor" style="min-height: 250px">
                                <p>&nbsp;</p>
                            </div>
                            <input type="hidden" name="explanation" id="hiddenContent">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label d-block">Have you given us the required access to complete this
                                Task? <span class="text-danger">*</span></label>
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
                            <label class="form-label">Upload Attachments/Files</label>
                            <input type="file" name="attached_files" id=""
                                class="form-control text-dark" placeholder="Attached Files">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-4 mt-4 col-md-12">
                            <!-- Title -->
                            <div class="d-inline-flex">
                                <div class="form-check me-3" style="color: black">
                                    <input type="checkbox" id="regularTimeline" name="priority"
                                        class="form-check-input" value="yes" />
                                    <label class="form-check-label" for="regularTimeline"><span
                                            class="form-label">Upgrade this task to priority for only
                                            &pound;{{ number_format(39, 2) }}</span></label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>


                        <input id="myid" type="hidden" name="product_id" value="{{ $product->id }}"
                            class="form-control" required>

                        <!-- button -->
                        <div class="col-md-8"></div>
                        <!-- button -->
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Submit Task</button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</section>



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
