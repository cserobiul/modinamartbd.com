@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New Return Product')
@section('customerProductReturn','active')
@section('customPluginCSS')
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
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Return Product Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                    <li class="breadcrumb-item active">{{ isset($pageTitle) ?  $pageTitle : 'Return Product Create' }}</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @include('backend.layouts._alert')
        @canany(['accounts.create'])
            <div class="row clearfix">
                {{-- product return product payment section start --}}
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Return Product Details</strong></h2>
                        </div>
                        <div class="body">
                            <form method="POST" action="{{ route('customerProductReturnProcess') }}">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-md-4 pb-2">
                                        <label for="order_id">Order ID</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                            </div>
                                            <input type="text" name="order_id" id="order_id" value="{{ old('order_id') }}" class="form-control" placeholder="e.g.: 21 or OID-1000021" required>
                                        </div>
                                        @error('order_id')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Return Product Place</button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- product return product payment section end --}}
            </div>
        @endcanany
    </div>
</div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
@endsection
@section('customJS')
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
@endsection
