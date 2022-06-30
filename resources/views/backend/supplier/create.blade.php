@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New Supplier')
@section('supplierList','active')
@section('customPluginCSS')
<!-- Multi Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/multi-select/css/multi-select.css') }}">
<!-- Bootstrap Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.css') }}" />
{{--    datatable--}}
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Supplier Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Suppliers</a></li>
                    <li class="breadcrumb-item active">New Supplier</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @canany(['supplier.create'])
            <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>New <strong>{{ isset($pageTitle) ?  $pageTitle : 'New Supplier' }}</strong></h2>
                    </div>
                    @include('backend.layouts._alert')
                    <form id="form_advanced_validation" method="POST" action="{{ route('supplier.store') }}" enctype="multipart/form-data">
                        @csrf
                         <div class="body" style="border: 2px solid #dddddd;">
                                <div class="row clearfix">
                                    <div class="col-md-6 pb-2">
                                        <label for="name">Supplier Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                            </div>
                                            <input type="text" name="name" value="{{ old('name') }}"  class="form-control" placeholder="Type Supplier Full Name" autofocus required>
                                        </div>
                                        @error('name')
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
                                    <div class="col-md-12 pb-2">
                                        <label for="address">Address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-shield-security"></i></span>
                                            </div>
                                            <input type="text" name="address" id="address" value="{{ old('address') }}"  class="form-control" placeholder="Type supplier address">
                                        </div>
                                        @error('address')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Create Supplier</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        @endcanany
        @canany(['supplier.all'])
            @include('backend.supplier.index')
        @endcanany
    </div>
</div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js -->
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
<script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
@endsection
@section('customJS')
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection
