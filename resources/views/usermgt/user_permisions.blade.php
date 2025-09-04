@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Permissions')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4 mb-4 d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h4 fw-bold">
                        Permissions
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Permissions</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $role->role }}
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
                        <div class="card-header border-bottom-0">
                            <!-- Form -->
                            <h4 class="mb-3">Permissions For User Role:
                                <u>{{ $role->role }}</u>
                            </h4>
                        </div>
                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5">
                            <table class="table mb-0 text-nowrap table-hover table-centered table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Platform Features</th>
                                        <th scope="col">Feature Permission</th>
                                        <th scope="col">Can Create</th>
                                        <th scope="col">Can Edit</th>
                                        <th scope="col">Can Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($platformFeatures as $feature)
                                        <tr>
                                            <td> <strong>{{ $feature->feature }} </strong></td>
                                            <td>
                                                @if ($role->featurePermission($feature->id) == 1)
                                                    <a href="{{ route('revokeFeaturePermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                            class="btn btn-success btn-sm">Revoke
                                                            Permission</button></a>
                                                @else
                                                    <a href="{{ route('grantFeaturePermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                            class="btn btn-primary btn-sm">Grant
                                                            Permission</button></a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($role->featurePermission($feature->id) == 1)
                                                    @if ($role->createPermission($feature->id) == 1)
                                                    <a href="{{ route('revokeCreatePermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                            class="btn btn-success btn-sm">Revoke
                                                            Permission</button></a>
                                                    @else
                                                    <a href="{{ route('grantCreatePermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                            class="btn btn-primary btn-sm">Grant
                                                            Permission</button></a>
                                                    @endif
                                                @else
                                                    <button class="btn btn-secondary btn-sm">Grant Permission</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($role->featurePermission($feature->id) == 1)
                                                    @if ($role->editPermission($feature->id) == 1)
                                                    <a href="{{ route('revokeEditPermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                            class="btn btn-success btn-sm">Revoke
                                                            Permission</button></a>
                                                    @else
                                                    <a href="{{ route('grantEditPermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                            class="btn btn-primary btn-sm">Grant
                                                            Permission</button></a>
                                                    @endif
                                                @else
                                                    <button class="btn btn-secondary btn-sm">Grant Permission</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($role->featurePermission($feature->id) == 1)
                                                    @if ($role->deletePermission($feature->id) == 1)
                                                    <a href="{{ route('revokeDeletePermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                            class="btn btn-success btn-sm">Revoke
                                                            Permission</button></a>
                                                    @else
                                                    <a href="{{ route('grantDeletePermission', [$role->id, $feature->id]) }}"
                                                        onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                            class="btn btn-primary btn-sm">Grant
                                                            Permission</button></a>
                                                    @endif
                                                @else
                                                    <button class="btn btn-secondary btn-sm">Grant Permission</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    document.getElementById("userr").classList.add('active');
</script>

@endsection
