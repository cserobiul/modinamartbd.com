@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Online Customer Due Details')
@section('customerDueList','active')
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
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Online Customer Due Details' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Online Customer Due Details</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @canany(['report.show'])
            <div class="row clearfix">
                {{-- customer list start --}}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Online Customer Due Details</strong></h2> <br>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="3">Customer Name: {{ \App\Models\Settings::unicodeName($customerDetails->customer_name) }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Join Date: {{ date('d M Y',strtotime($customerDetails->created_at)) }}</th>
                                        <th>Phone: {{ $customerDetails->phone }}</th>
                                        <th>Email: {{ $customerDetails->email }}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Buy Amount: {{ $customerDetails->buy_amount ? $customerDetails->buy_amount : '0' }}Tk</th>
                                        <th>Total Paid Amount: {{ $customerDetails->paid_payment ? $customerDetails->paid_payment : '0' }}Tk</th>
                                        <th>Total Due Amount: {{ $customerDetails->current_due ? $customerDetails->current_due : '0' }}Tk</th>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Purchase History--}}
                        <h5><strong>Order History</strong></h5>
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(count($orders) > 0)
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
                                            <th>Status</th>
                                            <th>Order Note</th>
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
                                                <td>{{ ucwords($order->status) }}</td>
                                                <td>{{ $order->order_note }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger"> No Purchase History Found... </h6>
                                </div>
                            @endif
                        </div>


                        {{-- Accounts--}}
                        <br><br>
                        <h5><strong>Payment History</strong></h5>
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(count($accounts) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice No</th>
                                            <th>Payment Date</th>
                                            <th>Paid Amount</th>
                                            <th>Payment Method</th>
                                            <th>Collect By</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($accounts as $key => $account)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $account->invoice_id }}</td>
                                                <td>{{ date('d M Y',strtotime($account->payment_date)) }}</td>
                                                <td>{{ $account->amount }}</td>
                                                <td>{{ $account->payment->payment_name }}</td>
                                                <td>{{ $account->user->name }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger">No Accounts History Found... </h6>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
                {{-- customer list end --}}
            </div>
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
