@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Update Role')
@section('roleList','active')
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Role Create' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Update Role</li>
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
                            <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Update Role' }}</strong></h2>
                        </div>
                        @include('backend.layouts._alert')
                        <div class="body" style="border: 2px solid #dddddd;">
                            <form id="form_advanced_validation" method="POST" action="{{ route('role.update',$role->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card">
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-md-6 pb-2">
                                                <label for="email_address">Role Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                                    </div>
                                                    <input type="text" name="name" value="{{ old('name',isset($role->name)?$role->name:null) }}"  class="form-control" placeholder="Type Role Name" autofocus required>
                                                </div>
                                                @error('name')
                                                <div class="text-danger pt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update Role</button>
                                            @if(!empty($permissions))
                                                <div class="col-md-12 pt-3">
                                                    <label for="email_address">Permission List</label>
                                                    <div class="checkbox">
                                                        <input id="permissionsAll" value="0" type="checkbox">
                                                        <label for="permissionsAll">
                                                            Select All Permission
                                                        </label>
                                                    </div>
                                                </div>
                                                <hr>
                                                @php  $i = 1; @endphp
                                                @foreach($permission_groups as $groups)
                                                    <div class="col-md-3">
                                                        <div class="checkbox">
                                                            <input id="{{ $i }}-Management" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox',this)" value="{{ $groups->name }}" type="checkbox">
                                                            <label for="{{ $i }}-Management">
                                                                {{ ucwords(str_replace('.',' ',$groups->name)) }}
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 role-{{ $i }}-management-checkbox">
                                                        @php
                                                            $permissions = \App\Models\User::getPermissionGroupName($groups->name);
                                                            $j = 1;
                                                        @endphp

                                                        @foreach($permissions as $permission)
                                                            <div class="checkbox">
                                                                <input name="permissions[]" id="{{ $i.$j }}-Permission" {{ $role->hasPermissionTo($permission->name)?'checked':'' }}  value="{{ $permission->name }}" type="checkbox">
                                                                <label for="{{ $i.$j }}-Permission">
                                                                    {{ ucwords(str_replace('.',' ',$permission->name)) }}
                                                                </label>
                                                            </div>
                                                            @php  $j++; @endphp
                                                        @endforeach
                                                    </div>
                                                    @php  $i++; @endphp
                                                    <hr>
                                                @endforeach
                                            @else
                                                <div class="col-md-6">
                                                    <h6 class="pt-3 text-danger">No Permission Found...</h6>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update Role</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customPluginJS')
@endsection
@section('customJS')
    @include('backend.layouts._roles_pages_js')
@endsection
