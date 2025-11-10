@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Submitted Websites')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Submitted Websites
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                             <li class="breadcrumb-item">
                                <a href="#">Account</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Websites
                            </li>
                        </ol>
                    </nav>
                </div>


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">

            <div class="alert alert-primary d-flex justify-content-between align-items-center">
                <div>Want to add/remove websites?</div>
                <div><button class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#newTicket">Submit a
                        Support Request</button></div>
            </div>

            <!-- Tab -->
            <div class="tab-content">
                <!-- Tab pane -->

                <!-- tab pane -->
                <div class="tab-pane fade show active" id="tabPaneList" role="tabpanel" aria-labelledby="tabPaneList">
                    <!-- card -->
                    <div class="card mb-4">
                        <!-- Card header -->

                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">S/No</th>
                                        <th scope="col">Website</th>
                                        <th scope="col">Website URL</th>
                                        <th scope="col">Admin URL</th>
                                        <th scope="col">Admin Username</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($websites as $web)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}.</td>
                                            <td class="align-middle"> Website {{ $loop->index + 1 }}</td>
                                            <td class="align-middle"> {{ $web->website_url }} </td>
                                            <td class="align-middle"> {{ $web->admin_url }} </td>
                                            <td class="align-middle"> {{ $web->username }} </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($websites) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no websites found.
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

                <form class="needs-validation" novalidate method="post" action="{{ route('customer.submitTicket') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->

                        <div class="mb-3 col-12">
                            <!-- Title -->
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" id="" class="form-control text-dark"
                                placeholder="Subject">
                            <div class="invalid-feedback">Please provide a response.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <!-- Title -->
                            <label class="form-label d-block">Priority</label>
                            <select id="priority" name="priority" class="form-select" style="width: 100%">
                                <option value="">Priority</option>
                                <option value="High">High </option>
                                <option value="Medium">Medium </option>
                                <option value="Low">Low </option>
                            </select>
                            <div class="invalid-feedback">Please select an option.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Description </label>
                            <div id="editor" style="height: 200px">
                                <p>&nbsp;</p>
                            </div>
                            <input type="hidden" name="description" id="hiddenContent">
                        </div>

                        <div class="mb-3 col-md-12">
                            <!-- Title -->
                            <label class="form-label">Attach Files</label>
                            <input type="file" name="attached_files" id="" class="form-control text-dark"
                                placeholder="Attached Files">
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
    document.getElementById("navSettings").classList.add('show');
    document.getElementById("websites").classList.add('active');
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
