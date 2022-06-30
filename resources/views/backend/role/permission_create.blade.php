@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New Permission')
@section('roleCreate','active')
@section('mainContent')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Permission Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                    <li class="breadcrumb-item active">New Permission</li>
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
                        <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'New Permission' }}</strong></h2>
                    </div>
                    @include('backend.layouts._alert')
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <form id="form_advanced_validation" method="POST" action="{{ route('permission.store') }}">
                                @csrf
                                <label for="permissionName">Permission Name</label>
                                <div class="form-group">
                                    <input type="text" name="permission_name" id="permissionName" class="form-control" placeholder="Enter new Permission Name" required>
                                </div>
                                @error('permission_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create</button>
                            </form>
                        </div>
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
