@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Profile Information')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h2 fw-bold">Profile Information </h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Account Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Profile Information
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <div class="py-6">
        <!-- row -->
        <div class="row">

            <div class="offset-xl-2 col-xl-8 col-md-12 col-12">

                @if (Auth::user()->profile_updated == 0)
                    <div class="alert alert-danger">Please Update Your Profile Information.</div>
                @endif

                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body p-lg-6">
                        <!-- form -->
                        <form method="post" action="{{ route('admin.updateProfile') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- form group -->
                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        placeholder="Enter Last Name" required>
                                    @error('last_name')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Other Names <span class="text-danger">*</span></label>
                                    <input type="text" name="other_names" value="{{ Auth::user()->other_names }}"
                                        class="form-control @error('other_names') is-invalid @enderror"
                                        placeholder="Enter Other Names" required>
                                    @error('other_names')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter Last Name" required readonly>
                                    @error('email')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Phone Number<span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" value="{{ Auth::user()->phone_number }}"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        placeholder="Enter Phone Number" required>
                                    @error('phone_number')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12 mb-4">
                                    <div>
                                        <!-- logo -->
                                        <h5 class="mb-3">Profile Photo </h5>
                                        <div class="icon-shape icon-xxl border rounded position-relative">
                                            <span class="position-absolute">
                                                <img alt="avatar"
                                                    src="{{ Auth::user()->profile_photo == null ? asset('assets/images/avatar/avatar.webp') : Auth::user()->profile_photo }}"
                                                    style="max-height:140px; max-width: 150px">
                                            </span>


                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mb-4">
                                    <h5 class="mb-3">&nbsp; </h5>
                                    <input type="file" name="profile_photo" class="form-control">
                                </div>
                                <div class="col-md-8"></div>
                                <!-- button -->
                                <div class="col-12">
                                    <button class="btn btn-primary" type="button"
                                        onClick="this.disabled=true; this.innerHTML='Submiting request, please wait...';this.form.submit();">Save
                                        Changes</button>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    document.getElementById("navSettings").classList.add('show');
    document.getElementById("profile").classList.add('active');
</script>

@endsection

@section('customjs')
<script type="text/javascript">
    $(document).ready(function() {
        $('#nationality').select2();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#gender').select2();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#maritalStatus').select2();
    });
</script>

@endsection
