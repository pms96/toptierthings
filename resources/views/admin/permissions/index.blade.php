@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Permissions List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('website') }}">Home</a></li>
                    <li class="breadcrumb-item active">Permissions list</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-sm-4">
                        <div class="search-box">
                            <input type="text" class="form-control" id="searchPermisionList" placeholder="Search Permission">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-sm-auto ms-auto">
                        <div class="list-grid-nav hstack gap-1">
                            <button class="btn btn-success addpermission-modal" data-toggle="modal" data-target="#addPermissionModal"><i class="ri-add-fill me-1 align-bottom"></i> Add Permission </button>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div id="permissionlist">
                        <div class="team-list list-view-filter row" id="role-list">
                        <!-- js encargado de insertar aquí cada uno de los items pasador a los scripts por json -->
                        </div>
                    </div>
                    <div class="py-4 mt-4 text-center" id="noresult" style="display: none;">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px"></lord-icon>
                        <h5 class="mt-4">Sorry, no result found</h5>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">

                                <div class="modal-body">
                                    <form autocomplete="off" id="memberlist-form" class="needs-validation" novalidate>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="hidden" id="permissionId" class="form-control" value="">
                                                <div class="p-1 mb-3">
                                                    <h5 class="modal-title text" id="createPermissionLabel">Add Permission</h5>
                                                    <h5 class="modal-title text" hidden id="editPermissionLabel">Edit Permission</h5>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="permissionDescription" class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="permissionDescription" placeholder="Enter Description" required>
                                                    <div class="invalid-feedback">Please enter description</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="permissionModule" class="form-label">Module</label>
                                                    <input type="text" class="form-control" id="permissionModule" placeholder="Enter module" required onchange="contructName()">
                                                    <div class="invalid-feedback">Please enter module</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="permissionView" class="form-label">Permission</label>
                                                    <input type="text" class="form-control" id="permissionView" placeholder="Enter permission" required onchange="contructName()">
                                                    <div class="invalid-feedback">Please enter permission</div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="permissionName" class="form-label">name</label>
                                                    <input type="text" class="form-control" id="permissionName" placeholder="Enter name" required readonly>
                                                    <div class="invalid-feedback">Please enter name</div>
                                                </div>
                                                
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" id="modalBtnClose" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="addNewMember">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--end modal-content-->
                        </div>
                        <!--end modal-dialog-->
                    </div>
                    <!--end modal-->

                    <!-- Delete modal -->
                    <div id="removeRoleModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                            <h4>Are you sure?</h4>
                                            <p class="text-muted mx-4 mb-0">Are you sure, you want to remove</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <button type="button" class="btn w-sm btn-light" id="close-permissionItem" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn w-sm btn-danger" id="remove-item">Remove</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                </div>
            </div><!-- end col -->
        </div>
        <!--end row-->
    </div>
</div>        

@endsection
@section('script')
    <script> var permissionList = @json($permissions); </script>
    <script src="{{ URL::asset('admin/js/pages/permissions.init.js') }}"></script>
@endsection