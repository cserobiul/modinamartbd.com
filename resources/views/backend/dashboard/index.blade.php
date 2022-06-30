@extends('backend.layouts.master')
@section('title','Admin Dashboard')
@section('customPluginCSS')
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/animate-css/vivify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/c3/c3.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2 style="color: #0e90d2"> {{ isset($pageTitle) ?  $pageTitle : 'Admin Dashboard' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item">Admin Dashboard</li>
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
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-cart-plus"></i></div>
                                <a href="{{ route('newOrder') }}">
                                <div class="ml-4">
                                    <span>New Orders</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $newOrders }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-cart-plus"></i></div>
                                <a href="{{ route('confirmedOrder') }}">
                                <div class="ml-4">
                                    <span>Confirmed Orders</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $confirmedOrders }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-orange text-white rounded-circle"><i class="fa fa-cart-plus"></i></div>
                                <a href="{{ route('shippingOrder') }}">
                                <div class="ml-4">
                                    <span>Shipping Orders</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $shippingOrders }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-pink text-white rounded-circle"><i class="fa fa-cart-plus"></i></div>
                                <a href="{{ route('deliveredOrder') }}">
                                <div class="ml-4">
                                    <span>Delivered Orders</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $deliveredOrders }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-orange text-white rounded-circle"><i class="fa fa-cart-plus"></i></div>
                                <a href="{{ route('product.index') }}">
                                <div class="ml-4">
                                    <span>All Products</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $productsNo }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-cart-plus"></i></div>
                                <a href="{{ route('purchase.index') }}">
                                <div class="ml-4">
                                    <span>All Purchases</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $purchaseNo }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-orange text-white rounded-circle"><i class="fa fa-cart-plus"></i></div>
                                <a href="{{ route('customer.index') }}">
                                <div class="ml-4">
                                    <span>Customers</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $customerNo }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="body">
                            <div class="d-flex align-items-center">
                                <div class="icon-in-bg bg-pink text-white rounded-circle"><i class="fa fa-life-ring"></i></div>
                                <a href="{{ route('supplier.index') }}">
                                <div class="ml-4">
                                    <span>Suppliers</span>
                                    <h4 class="mb-0 font-weight-medium">{{ $supplierNo }}</h4>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/bundles/c3.bundle.js') }}"></script>
@endsection
@section('customJS')
<script src="{{ asset('assets/js/index.js') }}"></script>
@endsection
