@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New User')
@section('userCreate','active')
@section('customPluginCSS')
<!-- Multi Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/multi-select/css/multi-select.css') }}">
<!-- Bootstrap Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.css') }}" />
@endsection
@section('mainContent')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'User Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">New User</li>
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
                        <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'New User' }}</strong></h2>
                        @canany(['user.all'])
                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('user.index') }}">User List</a>
                        @endcanany
                    </div>
                    @include('backend.layouts._alert')
                    <div class="body" style="border: 2px solid #dddddd;">
                        <form id="form_advanced_validation" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                            @csrf
                             <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="email_address">Full Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                                </div>
                                                <input type="text" name="name" value="{{ old('name') }}"  class="form-control" placeholder="Type Full Name" autofocus required>
                                            </div>
                                            @error('name')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="roles">Roles</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                                </div>
                                                <select name="roles[]" data-placeholder="Select Role" class="form-control show-tick ms select2" multiple data-placeholder="Select">
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name }}">{{ ucwords($role->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('roles')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="phone">Phone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                </div>
                                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Type Phone No">
                                            </div>
                                            @error('phone')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="email">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                                                </div>
                                                <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email Address">
                                            </div>
                                            @error('email')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="showPassword">Password</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-shield-security"></i></span>
                                                </div>
                                                <input type="password" name="password" id="showPassword"  class="form-control" placeholder="******">
                                            </div>
                                            @error('password')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="showPasswordC">REPEAT PASSWORD</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-shield-security"></i></span>
                                                </div>
                                                <input type="password" name="password_confirmation" id="showPasswordC"  class="form-control" placeholder="******">
                                            </div>
                                            @error('password_confirmation')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <div class="checkbox">
                                                <input id="sp" onclick="showFunction()" type="checkbox">
                                                <label for="sp">
                                                    Show Password
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js -->
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
@endsection
@section('customJS')
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
<script>
function showFunction() {
    var x = document.getElementById("showPassword");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    var y = document.getElementById("showPasswordC");
    if (y.type === "password") {
        y.type = "text";
    } else {
        y.type = "password";
    }

}
</script>
@endsection
