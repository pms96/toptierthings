@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Roles asing permissions</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('website') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Permissions</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-info">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden ms-3">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-2">Role Detail</p>
                                <div class="d-flex align-items-center mb-4">
                                    <h4 class="fs-4 flex-grow-1 m-3">{{$roles->name}}</h4>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
        </div>

        <!-- principal card -->


        <!-- cards -->

        <div class="d-flex flex-column h-100">
            <div class="row justify-content-center">
                @foreach ($modules as $module)
                <div class="col-xl-4 col-md-4 col mx-auto">
                    @php
                        $permissionsModule = array_filter($permissions->toArray(), function ($var) use ($module) {
                            return ($var['module'] == $module);
                        });

                        $getPermissionsModule = array_filter($roles->permissions->toArray(), function ($var) use ($module) {
                            return ($var['module'] == $module);
                        });

                        $getPermissionsModule = array_reduce($getPermissionsModule, function ($result, $item) {
                            $result[$item['id']] = $item;
                            return $result;
                        }, []);
                        
                    @endphp
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 d-inline-block position-relative" aria-labelledby="page-header-notifications-dropdown" style="z-index: 1;">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> {{$module}} </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge bg-light-subtle text-body fs-13" id="coutnModule_{{$module}}"> {{count($getPermissionsModule)}} </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                            @foreach ( $permissionsModule as $permission)
                            <a href="#!" class="text-reset notification-item d-block dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-2 lh-base">{{$permission['description']}}</h6>
                                        <input hidden id="permission_{{$permission['id']}}" value="{{$permission['name']}}">
                                    </div>
                                    <div class="px-2 fs-16 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="{{$permission['id']}}" @if( isset($getPermissionsModule[$permission['id']]) )  checked @endif  onchange="permissionRole(this.checked, this.id, '{{$roles->id}}', '{{$module}}')">    
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>


                    </div>

                </div><!--end col-->
                @endforeach
            </div><!--end row-->
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ URL::asset('admin/js/pages/assignPermissions.init.js') }}"></script>
@endsection