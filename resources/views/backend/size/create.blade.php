@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Size')
@section('sizeList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Size' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('size.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Sizes' }}</a></li>
                        <li class="breadcrumb-item active">New and Size List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['size.create'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('size.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="sizeName">Size Name</label>
                        <div class="form-group">
                            <input type="text" name="size_name" id="sizeName" class="form-control" placeholder="Enter new Size Name" required>
                        </div>
                        @error('size_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create</button>
                    </form>
                </div>
            </div>
         @endcanany
         @canany(['size.all'])
             @include('backend.size.index')
         @endcanany
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
