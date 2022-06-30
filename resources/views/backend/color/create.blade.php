@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Color')
@section('colorList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Color' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('color.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Colors' }}</a></li>
                        <li class="breadcrumb-item active">New and Color List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['color.create'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('color.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="colorName">Color Name</label>
                        <div class="form-group">
                            <input type="text" name="color_name" id="colorName" class="form-control" placeholder="Enter new Color Name" required>
                        </div>
                        @error('color_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="colorCode">Color Code</label>
                        <div class="input-group colorpicker">
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="input-group-addon"> <i></i> </span></span>
                            </div>
                            <input name="color_code" type="text" class="form-control" value="#00AABB">
                        </div>
                        @error('color_code')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create</button>
                    </form>
                </div>
            </div>
         @endcanany
         @canany(['color.all'])
             @include('backend.color.index')
         @endcanany
        </div>
    </div>
@endsection
@section('customPluginJS')
    <script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
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
    <script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
@endsection
