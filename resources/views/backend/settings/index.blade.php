@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Settings')
@section('settingsList','active')
@section('customPluginCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}">
@endsection
@section('mainContent')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
              <h2> {{ isset($pageTitle) ?  $pageTitle : 'Settings' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                    <li class="breadcrumb-item active">Update</li>
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
                        <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Settings' }}</strong> Update</h2>
                    </div>
                    @include('backend.layouts._alert')
                    <div class="body" style="border: 2px solid #dddddd;">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#general_tab"> <i class="zmdi zmdi-home"></i> General </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact_tab"><i class="zmdi zmdi-account"></i> Contact </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#footer_tab"><i class="zmdi zmdi-settings"></i> Footer </a></li>
                        </ul>
                        <form id="form_advanced_validation" method="POST" action="{{ route('settings.update',$settings->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="general_tab"> <strong>General Content</strong>
                                    <div class="card">
                                        <div class="body">
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <label for="app_name">Application Name</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-home"></i></span>
                                                        </div>
                                                        <input type="text" name="app_name" value="{{ old('app_name',isset($settings->app_name)?$settings->app_name:null) }}" class="form-control" placeholder="Type Application Name" autofocus>
                                                    </div>
                                                    @error('app_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <label for="logo">Logo</label>
                                                    @if($settings->logo !=null)
                                                        <br>
                                                        <img src="{{ asset($settings->logo) }}" alt="Logo Image" class="rounded" style="width: 160px; margin-bottom: 15px !important;">
                                                    @endif
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-collection-image"></i></span>
                                                        </div>
                                                        <input type="file" name="logo" class="form-control" placeholder="Logo">
                                                    </div>
                                                    <span><strong>Note</strong>: Must be PNG type Photo</span>
                                                    @error('logo')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-md-6 pt-3">
                                                    <label for="favicon">Favicon</label>
                                                    @if($settings->favicon !=null)
                                                        <br>
                                                        <img src="{{ asset($settings->favicon) }}" alt="Logo Image" class="rounded" style="width: 50px; margin-bottom: 15px !important;">
                                                    @endif
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-collection-image"></i></span>
                                                        </div>
                                                        <input type="file" name="favicon" class="form-control" placeholder="Favicon">
                                                    </div>
                                                    <span><strong>Note</strong>: Must be PNG type Photo</span>
                                                    @error('favicon')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="contact_tab"> <b>Contact Content</b>
                                    <div class="card">
                                        <div class="body">
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <label for="phone">Phone</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                        </div>
                                                        <input type="text" name="phone" value="{{ old('phone',isset($settings->phone)?$settings->phone:null) }}" class="form-control" placeholder="Type Phone No">
                                                    </div>
                                                    @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email_address">Email</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                                                        </div>
                                                        <input type="text" name="email" value="{{ old('email',isset($settings->email)?$settings->email:null) }}" class="form-control" placeholder="Email Address">
                                                    </div>
                                                    @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row clearfix pt-2">
                                                <div class="col-md-4">
                                                    <label for="social_facebook">Facebook</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-facebook"></i></span>
                                                        </div>
                                                        <input type="url" name="social_facebook" value="{{ old('social_facebook',isset($settings->social_facebook)?$settings->social_facebook:null) }}" class="form-control" placeholder="Facebook url">
                                                    </div>
                                                    @error('social_facebook')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="social_instagram">Instagram</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-instagram"></i></span>
                                                        </div>
                                                        <input type="url" name="social_instagram" value="{{ old('social_instagram',isset($settings->social_instagram)?$settings->social_instagram:null) }}" class="form-control" placeholder="Instagram url">
                                                    </div>
                                                    @error('social_instagram')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="social_youtube">Youtube</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-youtube"></i></span>
                                                        </div>
                                                        <input type="url" name="social_youtube" value="{{ old('social_youtube',isset($settings->social_youtube)?$settings->social_youtube:null) }}" class="form-control" placeholder="Youtube url">
                                                    </div>
                                                    @error('social_youtube')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row clearfix pt-2">
                                                <div class="col-md-12">
                                                    <label for="address">Address</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-home"></i></span>
                                                        </div>
                                                        <textarea name="address" cols="30" rows="5" placeholder="Type Address" class="form-control no-resize">{{ old('address',isset($settings->address)?$settings->address:null) }}</textarea>
                                                    </div>
                                                    @error('address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="footer_tab"> <b>Footer Content</b>
                                    <div class="card">
                                        <div class="body">
                                            <div class="row clearfix">
                                                <div class="col-md-12">
                                                    <label for="footer">Footer</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="zmdi zmdi-copy"></i></span>
                                                        </div>
                                                        <textarea name="footer" placeholder="Type Footer" class="summernote" style="height: 100px !important;">
                                                            {{ old('footer',isset($settings->footer)?$settings->footer:null) }}
                                                        </textarea>

                                                    </div>
                                                    @error('footer')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customPluginJS')
    <script src="{{ asset('assets/plugins/summernote/dist/summernote.js') }}"></script>
@endsection
@section('customJS')
@endsection
