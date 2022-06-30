@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Roles')
@section('roleList','active')
@section('customPluginCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Roles' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('role.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Roles' }}</a></li>
                        <li class="breadcrumb-item active">All List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Roles' }}</strong> List</h2>
                            @canany(['role.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('role.create') }}">Create New Role</a>
                            @endcanany
                        </div>

                        @include('backend.layouts._alert')
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(!empty($roles))
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Role Name</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($roles as $key => $role)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ ucwords($role->name) }}</td>
                                            <td>
                                                @foreach($role->permissions as $permission)
                                                    <div class="badge badge-primary  mb-1"> {{ ucwords(str_replace('.',' ',$permission->name)) }}</div>
                                                @endforeach
                                            </td>
                                            @canany(['role.update'])
                                                <td><a href="{{ route('role.edit',$role->id) }}">Edit</a></td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger"> No Roles Found...
                                    @canany(['role.create'])
                                        <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('role.create') }}">Create New Role</a>
                                    @endcanany
                                    </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
@endsection
@section('customJS')
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection
