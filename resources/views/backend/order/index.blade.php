@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Order List')
@section('deliveredOrder','active')
@section('customPluginCSS')
{{--    datatable--}}
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<style>
    td{ vertical-align: middle !important;}
</style>
@endsection
@section('mainContent')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Order List' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">All Order List</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @canany(['order.create'])
            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('newOrder') }}">New Order</a>
        @endcanany
        @canany(['order.all'])
            <div class="row clearfix">
                {{-- order list start --}}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Order List</strong></h2>
                        </div>
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(!empty($orders))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Date</th>
                                            <th>Order Id</th>
                                            <th>Invoice No</th>
                                            <th>Amount</th>
                                            <th>Discount</th>
                                            <th>Order by</th>
                                            <th>Order Note</th>
                                            <th>Status</th>
                                            @canany(['print.all'])
                                            <th>Print</th>
                                            @endcanany

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($orders as $key => $order)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><a href="{{ route('order.show',$order->id) }}">{{ date('d M Y',strtotime($order->created_at)) }}</a></td>
                                                <td><a href="{{ route('order.show',$order->id) }}">{{ $order->oid }}</a></td>
                                                <td><a href="{{ route('order.show',$order->id) }}">{{ $order->invoice_id  }}</a></td>
                                                <td>{{ $order->total_price }}</td>
                                                <td>{{ $order->total_discount }}</td>
                                                <td>{{ ucwords($order->customer->customer_name) }}</td>
                                                <td>{{ $order->order_note }}</td>
                                                <td>{{ ucwords($order->status) }}</td>
                                                @canany(['print.all'])
                                                    <td>
                                                        @if($order->status == \App\Models\Settings::STATUS_DELIVERED)
                                                            <a href="{{ route('invoice.print',$order->id) }}" target="_new"><i class="zmdi zmdi-print"></i></a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                @endcanany
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger"> No Order Found...
                                        @canany(['order.create'])
                                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('orderNew') }}">New Order</a>
                                        @endcanany
                                    </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- order list end --}}
            </div>
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
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection
