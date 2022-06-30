@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Warranty')
@section('warrantyList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Warranty' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('warranty.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Warrantys' }}</a></li>
                        <li class="breadcrumb-item active">New and Warranty List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['warranty.create'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('warranty.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="warrantyName">Warranty Name</label>
                        <div class="form-group">
                            <input type="text" name="warranty_name" id="warrantyName" class="form-control" placeholder="Enter new Warranty Name" required>
                        </div>
                        @error('warranty_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create</button>
                    </form>
                </div>
            </div>
         @endcanany
         @canany(['warranty.all'])
             @include('backend.warranty.index')
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
