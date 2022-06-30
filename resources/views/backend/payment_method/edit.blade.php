@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Payment Method Update')
@section('paymentMethodList','active')
@section('customPluginCSS')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Payment Method Update' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payment_method.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Payment Methods' }}</a></li>
                        <li class="breadcrumb-item active">Update and Payment Method List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
         @canany(['payment_method.update'])
            <div class="row clearfix">
                <div class="col-sm-12">
                    <form id="form_advanced_validation" method="POST" action="{{ route('payment_method.update',$paymentmethod->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <label for="payment_name">Payment Method Name</label>
                        <div class="form-group">
                            <input type="text" name="payment_name" value="{{ old('payment_name',isset($paymentmethod->payment_name)?$paymentmethod->payment_name:null) }}" id="payment_name" class="form-control" placeholder="Enter Payment Method Name" required>
                        </div>
                        @error('payment_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="details">Payment Method Details</label>
                        <div class="form-group">
                            <input type="text" name="details" value="{{ old('details',isset($paymentmethod->details)?$paymentmethod->details:null) }}" id="details" class="form-control" placeholder="Enter Details" required>
                        </div>
                        @error('details')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="status">Status</label>
                        <select name="status" class="form-control show-tick ms select2" data-placeholder="Select">
                            <option value="active" @if(old('status',isset($paymentmethod->status)?$paymentmethod->status:null) == 'active') selected @endif>Active</option>
                            <option value="inactive" @if(old('status',isset($paymentmethod->status)?$paymentmethod->status:null) == 'inactive') selected @endif>Inactive</option>
                        </select>

                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Update</button>
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
