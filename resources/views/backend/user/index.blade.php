@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Users')
@section('userList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Users' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Users' }}</a></li>
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
                            <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Users' }}</strong> List</h2>
                            @canany(['user.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('user.create') }}">Create New User</a>
                            @endcanany
                        </div>

                        @include('backend.layouts._alert')
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(!empty($users))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Photo</th>
                                            <th>Last Seen</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($users as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><a href="{{ route('user.edit',$user->id) }}">{{ ucwords($user->name) }}</a></td>
                                                <td>{{ strtolower($user->email) }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>
                                                    @foreach($user->roles as $role)
                                                        @canany(['role.show'])
                                                            <div class="badge badge-primary mr-1 mb-1">{{ ucwords($role->name) }}</div>
                                                        @endcanany
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if(!empty($user->profile_photo_path))
                                                        <img src="{{ asset($user->profile_photo_path) }}" class="" alt="user profile image" height="50" width="50" />
                                                    @else
                                                        <img src="{{ asset('assets/images/profile_av.jpg') }}" class="" alt="user profile image" height="50" width="50"/>
                                                    @endif
                                                </td>
                                                <td> {{ Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</td>
                                                <td>
                                                    @if(Cache::has('user-is-online-' . $user->id))
                                                        <span class="text-success">Online</span>
                                                    @else
                                                        <span class="text-secondary">Offline</span>
                                                    @endif
                                                </td>
                                                @canany(['user.update'])
                                                    <td><a href="{{ route('user.edit',$user->id) }}">Edit</a></td>
                                                @endcanany
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger"> No Users Found...
                                        @canany(['user.create'])
                                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('user.create') }}">Create New User</a>
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
