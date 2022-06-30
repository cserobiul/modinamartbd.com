@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Order Details')
@section('newOrder','active')
@section('customPluginCSS')
<!-- Bootstrap Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
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
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Order Details' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
                        <li class="breadcrumb-item active">{{ isset($pageTitle) ?  $pageTitle : 'Order Details' }}</li>
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
{{--                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('order.create') }}">New Order</a>--}}
            @endcanany
            @canany(['order.all'])
               @include('backend.layouts._alert')
                <div class="row clearfix">
                    {{-- order list start --}}
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Order Details' }}</strong></h2> <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered printAble">
                                        <thead>
                                        <tr>
                                            <th colspan="3">Customer Name: <a href="{{ route('customer.due.details',$order->customer->id) }}">{{ ucwords($order->customer->customer_name) }}</a> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>Order Date: {{ date('d M Y',strtotime($order->created_at)) }}</th>
                                            <th>Phone: {{ $order->customer->phone }}</th>
                                            <th>Email: {{ $order->customer->email }}</th>
                                        </tr>
                                        <tr>
                                            <th>Invoice No: {{ $order->invoice_id }}</th>
                                            <th>Total Discount: {{ $order->total_discount }}Tk</th>
                                            <th>Total Amount: {{ $order->total_price }}Tk</th>
                                        </tr>
                                        <tr>
                                            <th>Order Note: {{ $order->order_note }}</th>
                                            <th>Order Current Status: <span style="color: red">{{ ucwords($order->status) }}</span></th>
                                            <th>
                                                @if($order->status == \App\Models\Settings::STATUS_PENDING)
                                                    <form id="form_advanced_validation" method="POST" action="{{ route('statusCancelOrConfirmed') }}">
                                                    @csrf
                                                    <div class="col-lg-12 col-md-12">
                                                        <label>Change Status</label>
                                                        <br />
                                                        <label class="fancy-radio">
                                                            <input type="radio" name="status" value="{{ \App\Models\Settings::STATUS_CANCEL }}" required data-parsley-errors-container="#error-radio">
                                                            <span><i></i>{{ ucwords(\App\Models\Settings::STATUS_CANCEL) }}</span>
                                                        </label>
                                                        <label class="fancy-radio">
                                                            <input type="radio" name="status" value="{{ \App\Models\Settings::STATUS_CONFIRMED }}">
                                                            <span><i></i>{{ ucwords(\App\Models\Settings::STATUS_CONFIRMED) }}</span>
                                                        </label>
                                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                                        <button type="submit" class="btn btn-primary">Change</button>
                                                    </div>
                                                </form>
                                                @elseif($order->status == \App\Models\Settings::STATUS_CONFIRMED)
                                                    <form id="form_advanced_validation" method="POST" action="{{ route('statusConfirmedToShipping') }}">
                                                        @csrf
                                                        <div class="col-lg-12 col-md-12">
                                                            <label>Order Process</label>
                                                            <br />
                                                            <input type="hidden" name="id" value="{{ $order->id }}">
                                                            <button type="submit" class="btn btn-primary">Go to Shipping</button>
                                                        </div>
                                                    </form>
                                                @elseif($order->status == \App\Models\Settings::STATUS_SHIPPING)
                                                    <form id="form_advanced_validation" method="GET" action="{{ route('billCollectionFromShipping') }}">
                                                        @csrf
                                                        <div class="col-lg-12 col-md-12">
                                                            <label>Order Status</label>
                                                            <br />
                                                            <input type="hidden" name="bill_for" value="{{$order->customer->id }}">
                                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                            <button type="submit" class="btn btn-primary">Successfully Delivered</button>
                                                        </div>
                                                    </form>
                                                @elseif($order->status == \App\Models\Settings::STATUS_DELIVERED)
                                                 <a href="{{ route('invoice.print',$order->id) }}" target="_new">Print Invoice <i class="zmdi zmdi-print"></i></a>
                                                @endif
                                            </th>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h5>Order Details</h5>
                            <div class="body" style="border: 2px solid #dddddd;">
                                @if(!empty($orderDetails))
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center printAble" id="list-member3">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Photo</th>
                                                <th>Quantity</th>
                                                @if($order->status != \App\Models\Settings::STATUS_SHIPPING)
                                                <th class="bg-blue-grey">Current Stock</th>
                                                @endif
                                                <th>Discount</th>
                                                <th>Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($orderDetails as $key => $orderItem)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $orderItem->product->name  }}</td>
                                                    <td><img src="{{ asset($orderItem->product->photo) }}" alt="product photo" class="rounded" style="width: 80px; margin-bottom: 15px !important;"></td>
                                                    <td>{{ $orderItem->quantity }}</td>
                                                    @if($order->status != \App\Models\Settings::STATUS_SHIPPING)
                                                        <td>
                                                        <span @if(\App\Models\Stock::where('product_id',$orderItem->product_id)->sum('stock') < $orderItem->quantity)
                                                              class="badge badge-danger  mb-1 font-weight-bold"
                                                              @else
                                                              class="badge badge-success  mb-1 font-weight-bold"
                                                        @endif
                                                        >
                                                            {{ \App\Models\Stock::where('product_id',$orderItem->product_id)->sum('stock') }}
                                                        </span>
                                                        </td>
                                                    @endif
                                                    <td>{{ $orderItem->discount }} Tk</td>
                                                    <td>{{ $orderItem->price }} Tk</td>
                                                    <td>{{ $orderItem->price*$orderItem->quantity }} Tk</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <h6 class="pt-3 text-danger"> No Order Details Found...
                                            @canany(['order.create'])
{{--                                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('order.create') }}">Create New Order</a>--}}
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
{{--<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>--}}
<script>
    $(document).ready(function () {
        $('#list-member3').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        stripHtml : false,
                        columns: [0,1, 2, 3,5, 6, 7]
                        //specify which column you want to print
                    }
                }

            ]
        });

    });
</script>
@endsection
