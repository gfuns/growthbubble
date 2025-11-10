@extends('customer.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Tasks')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold">
                        Files
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Files</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                               Shared Files
                            </li>
                        </ol>
                    </nav>
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
                                <div class="col-12 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="search" type="search" class="form-control ps-6"
                                            placeholder="Search Files......" value="{{ $search }}">
                                    </div>

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
                                        <th scope="col">File</th>
                                        <th scope="col">Shared By</th>
                                        <th scope="col">Comment</th>
                                        <th scope="col">Date</th>
                                        {{-- <th scope="col">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($files as $file)
                                        <tr>
                                            <td class="align-middle"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle" data-bs-toggle="modal"
                                                data-bs-target="#uploadedFileModal" data-myid="{{ $file->id }}"
                                                data-uploadedfile="{{ $file->uploaded_file }}"
                                                data-filetype="{{ $file->file_type }}" style="cursor: pointer">
                                                {{ $file->file_name }}</td>
                                            <td class="align-middle">
                                                {{ $file->user->last_name . ' ' . $file->user->other_names }}</td>
                                            <td class="align-middle">
                                                <span class="badge text-primary bg-light-primary"
                                                    style="cursor: pointer" data-bs-toggle="modal"
                                                    data-bs-target="#fileComment" data-comment="{{ $file->comment }}">
                                                    View Comment</span>
                                            </td>
                                            <td class="align-middle">
                                                {{ date_format($file->created_at, 'jS M, Y g:ia') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if (count($files) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2">No Record Found</h3>
                                        <div class="mt-2 text-muted"> There are no uploaded files found.
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (count($files) > 0 && $marker != null)
                                <div class="card-footer">
                                    <div class="row g-2 pt-3 me-4">
                                        <div class="col-md-9">Showing {{ $marker['begin'] }} to {{ $marker['end'] }}
                                            of
                                            {{ number_format($lastRecord) }} Records</div>

                                        <div class="col-md-3">
                                            {{ $files->appends(request()->input())->links() }}
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



<div class="modal fade" id="uploadedFileModal" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    Uploaded File
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <div class="modal-body">
                <div id="uploadedFileContent"></div>

                <div class="row mt-4">
                    <div class="col-12">
                        <a id="downloadDocBtn" href="#" target="_blank">
                            <button class="btn btn-primary btn-sm w-100"><i class="fe fe-download dropdown-item-icon"
                                    style="color:white; font-weight: bold"></i>
                                Download File</button>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="fileComment" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    View Comment
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <div class="modal-body">
                <div id="comment"></div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    document.getElementById("navFolder").classList.add('show');
    document.getElementById("sharedFiles").classList.add('active');
</script>

@endsection
