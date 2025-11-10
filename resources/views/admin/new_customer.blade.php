@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | New Client')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h2 fw-bold">New Client </h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">CRM</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                New Client
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

            <div class="offset-xl-1 col-xl-10 col-md-12 col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body p-lg-6">
                        <!-- form -->
                        <form method="post" action="{{ route('admin.storeCustomer') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- form group -->
                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        placeholder="Enter Last Name" required>
                                    @error('last_name')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        placeholder="Enter First Name" required>
                                    @error('first_name')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter Email" required>
                                    @error('email')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Phone Number<span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        placeholder="Enter Phone Number" required>
                                    @error('phone_number')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Organization<span class="text-danger">*</span></label>
                                    <input type="text" name="organization" value="{{ old('organization') }}"
                                        class="form-control @error('organization') is-invalid @enderror"
                                        placeholder="Enter Organization" required>
                                    @error('organization')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Contact Address<span class="text-danger">*</span></label>
                                    <input type="text" name="contact_address" value="{{ old('contact_address') }}"
                                        class="form-control @error('contact_address') is-invalid @enderror"
                                        placeholder="Enter Contact Address" required>
                                    @error('contact_address')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Product<span class="text-danger">*</span></label>
                                    <select id="clientProduct" name="product" class="form-control" data-width="100%"
                                        required>
                                        <option value="">Select Product</option>
                                        @foreach ($products as $prod)
                                            <option value="{{ $prod->id }}"
                                                @if (old('product') == $prod->id) selected @endif>{{ $prod->product }}
                                                Plan</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Plan<span class="text-danger">*</span></label>
                                    <select id="clientPlan" name="plan" class="form-control" data-width="100%"
                                        required>
                                        <option value="">Select Plan</option>
                                    </select>
                                    @error('plan')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Effective Date<span class="text-danger">*</span></label>
                                    <input id="date" type="date" name="effective_date"
                                        value="{{ old('effective_date') }}"
                                        class="form-control @error('effective_date') is-invalid @enderror"
                                        placeholder="Enter Effective Date" required>
                                    @error('effective_date')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="col-md-8"></div>
                                <!-- button -->
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="button"
                                        onClick="this.disabled=true; this.innerHTML='Submiting request, please wait...';this.form.submit();">Create Client Account</button>

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
    document.getElementById("navCRM").classList.add('show');
    document.getElementById("newClient").classList.add('active');
</script>

@endsection

@section('customjs')
<script type="text/javascript">
    $(document).ready(function() {
        $('#clientProduct').select2();
    });

    $(document).ready(function() {
        $('#clientPlan').select2();
    });


    $('#clientProduct').change(function() {
        var productId = $(this).val();
        $('#clientPlan').html(
            '<option value="">Fetching data, please wait...</option>'); // Show "Fetching data" message
        $.ajax({
            url: "/ajax/get-plans/" + productId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                var options = "<option value=''>Select Product Plans</option>";
                $.each(data, function(key, value) {
                    options += "<option value='" + key + "'>" + value + "</option>";
                });
                $('#clientPlan').html(options);
            }
        });
    });

</script>
@endsection
