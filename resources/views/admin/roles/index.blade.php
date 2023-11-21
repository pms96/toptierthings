@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-4">
                <div class="search-box">
                    <input type="text" class="form-control" id="searchRoleList" placeholder="@lang('translation.search-for-name-or-role')">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
            <!--end col-->
            <div class="col-sm-auto ms-auto">
                <div class="list-grid-nav hstack gap-1">
                    <button type="button" id="grid-view-button" class="btn btn-soft-info nav-link btn-icon fs-14  filter-button" disabled><i class="ri-grid-fill"></i></button>
                    <button type="button" id="list-view-button" class="btn btn-soft-info nav-link  btn-icon fs-14 active filter-button"><i class="ri-list-unordered"></i></button>
                    <button class="btn btn-success addrole-modal" data-bs-toggle="modal" data-bs-target="#addroleModal"><i class="ri-add-fill me-1 align-bottom"></i> @lang('translation.add-role')</button>
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
            <div id="rolelist">
                <div class="team-list list-view-filter row" id="role-list">
                <!-- js encargado de insertar aquí cada uno de los items pasador a los scripts por json -->
                </div>
            </div>
            <div class="py-4 mt-4 text-center" id="noresult" style="display: none;">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px"></lord-icon>
                <h5 class="mt-4">@lang('translation.sorry-no-result-found')</h5>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addroleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">

                        <div class="modal-body">
                            <form autocomplete="off" id="memberlist-form" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="hidden" id="roleId" class="form-control" value="">
                                        <div class="p-1 mb-3">
                                            <h5 class="modal-title text" id="createRoleLabel">@lang('translation.add-new-role')</h5>
                                            <h5 class="modal-title text" hidden id="editRoleLabel">@lang('translation.edit-role')</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="roleName" class="form-label">@lang('translation.name')</label>
                                            <input type="text" class="form-control" id="roleName" placeholder="@lang('translation.enter-name')" required>
                                            <div class="invalid-feedback">@lang('translation.please-enter-name')</div>
                                        </div>

                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" id="modalBtnClose" data-bs-dismiss="modal">@lang('translation.close')</button>
                                            <button type="submit" class="btn btn-success" id="addNewMember">@lang('translation.save')</button>
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
                                    <h4>@lang('translation.are-you-sure')</h4>
                                    <p class="text-muted mx-4 mb-0">@lang('translation.are-you-sure-you-want-to-remove')</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" id="close-roleItem" data-bs-dismiss="modal">@lang('translation.close')</button>
                                <button type="button" class="btn w-sm btn-danger" id="remove-item">@lang('translation.remove')</button>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>
    </div><!-- end col -->
</div>
<!--end row-->

@endsection
@section('script')
<script> var roleList = @json($roles); </script>
<script src="{{ URL::asset('admin/js/pages/roles.init.js') }}"></script>
<script src="{{ URL::asset('admin/js/app.js') }}"></script>
@endsection