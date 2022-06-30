@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Payment Method')
@section('paymentMethodList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Payment Method' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payment_method.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Payment Methods' }}</a></li>
                        <li class="breadcrumb-item active">New and Payment Method List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['payment_method.create'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('payment_method.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="payment_name">Payment Method Name</label>
                        <div class="form-group">
                            <input type="text" name="payment_name" id="payment_name" value="{{ old('payment_name') }}" class="form-control" placeholder="Enter new Payment Method Name" required>
                        </div>
                        @error('payment_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="details">Payment Method Details</label>
                        <div class="form-group">
                            <input type="text" name="details" id="details" value="{{ old('details') }}" class="form-control" placeholder="Enter Details" required>
                        </div>
                        @error('details')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create</button>
                    </form>
                </div>
            </div>
         @endcanany
         @canany(['payment_method.all'])
             @include('backend.payment_method.index')
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
