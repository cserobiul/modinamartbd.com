@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Update Profile')
@section('profileUpdate','active')
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
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Profile Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                    <li class="breadcrumb-item active">Update Profile</li>
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
                        <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Edit Profile' }}</strong></h2>
                        @canany(['user.all'])
                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('user.index') }}">Profile List</a>
                        @endcanany
                    </div>
                    @include('backend.layouts._alert')
                    <div class="body" style="border: 2px solid #dddddd;">
                        <form id="form_advanced_validation" method="POST" action="{{ route('profile.update',$profile->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                             <div class="card">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="email_address">Full Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                                </div>
                                                <input type="text" name="name" value="{{ old('name',isset($profile->name)?$profile->name:null) }}"  class="form-control" placeholder="Type Full Name" autofocus required>
                                            </div>
                                            @error('name')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="email_address">Roles</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                                </div>
                                                <select data-placeholder="Select Role" class="form-control show-tick ms select2" multiple data-placeholder="Select" disabled>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $profile->hasRole($role->name)? 'selected':'' }}>{{ ucwords($role->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="email_address">Phone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                </div>
                                                <input type="text"  value="{{ $profile->phone }}" class="form-control" placeholder="Type Phone No" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pb-2">
                                            <label for="email_address">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                                                </div>
                                                <input type="text" value="{{ $profile->email }}" class="form-control" placeholder="Email Address" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 pb-2">
                                            <label for="email_address">Password</label>
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
                                            <label for="email_address">REPEAT PASSWORD</label>
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

                                    <div class="row clearfix">
                                        <div class="col-md-6">
                                            <label for="photo">Profile Photo</label>
                                            @if($profile->profile_photo_path !=null)
                                                <br>
                                                <img src="{{ asset($profile->profile_photo_path) }}" alt="Logo Image" class="rounded" style="width: 140px; margin-bottom: 15px !important;">
                                            @endif
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-collection-image"></i></span>
                                                </div>
                                                <input type="file" name="photo" class="form-control" placeholder="profile photo">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update Profile</button>
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
