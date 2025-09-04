@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Manage Role Permissions')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-4 mb-4 d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h4 fw-bold">
                        Manage Role Permissions
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Manage Role Permissions</a></li>
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
                        @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 1) == true)
                            <div class="table-responsive overflow-y-hidden mb-5">
                                <table class="table mb-0 text-nowrap table-hover table-centered table-bordered">
                                    <thead>
                                        <tr class="text-dark">
                                            <td><strong>Platform Features</strong></td>
                                            <td><strong>Feature Permission</strong></td>
                                            <td><strong>Can Create</strong></td>
                                            <td><strong>Can Edit</strong></td>
                                            <td><strong>Can Delete</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        @foreach ($platformFeatures as $feature)
                                            <tr>
                                                <td> <strong>{{ $feature->feature }} </strong></td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        <a href="{{ route('admin.revokeFeaturePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                class="btn btn-primary btn-sm">Revoke
                                                                Permission</button></a>
                                                    @else
                                                        <a href="{{ route('admin.grantFeaturePermission', [$role->id, $feature->id]) }}"
                                                            onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                class="btn btn-warning btn-sm">Grant
                                                                Permission</button></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->createPermission($feature->id) == 1)
                                                            <a href="{{ route('admin.revokeCreatePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                    class="btn btn-primary btn-sm">Revoke
                                                                    Permission</button></a>
                                                        @else
                                                            <a href="{{ route('admin.grantCreatePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                    class="btn btn-warning btn-sm">Grant
                                                                    Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-secondary btn-sm">Grant
                                                            Permission</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->editPermission($feature->id) == 1)
                                                            <a href="{{ route('admin.revokeEditPermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                    class="btn btn-primary btn-sm">Revoke
                                                                    Permission</button></a>
                                                        @else
                                                            <a href="{{ route('admin.grantEditPermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                    class="btn btn-warning btn-sm">Grant
                                                                    Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-secondary btn-sm">Grant
                                                            Permission</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($role->featurePermission($feature->id) == 1)
                                                        @if ($role->deletePermission($feature->id) == 1)
                                                            <a href="{{ route('admin.revokeDeletePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Revoking Permission...';"><button
                                                                    class="btn btn-primary btn-sm">Revoke
                                                                    Permission</button></a>
                                                        @else
                                                            <a href="{{ route('admin.grantDeletePermission', [$role->id, $feature->id]) }}"
                                                                onClick="this.disabled=true; this.innerHTML='Granting Permission...';"><button
                                                                    class="btn btn-warning btn-sm">Grant
                                                                    Permission</button></a>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-secondary btn-sm">Grant
                                                            Permission</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>


                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    document.getElementById("platSettings").classList.add('show');
    document.getElementById("roles").classList.add('active');
</script>

@endsection
