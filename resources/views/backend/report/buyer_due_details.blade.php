@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Customer Due Details')
@section('buyerDueList','active')
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
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Customer Due Details' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Customer Due Details</li>
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
                            <h2><strong>Customer Due Details</strong></h2> <br>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="3">Customer Name: {{ \App\Models\Settings::unicodeName($buyerDetails->name) }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Join Date: {{ date('d M Y',strtotime($buyerDetails->created_at)) }}</th>
                                        <th>Phone: {{ $buyerDetails->phone }}</th>
                                        <th>Email: {{ $buyerDetails->email }}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Buy Amount: {{ $buyerDetails->buy_amount ? $buyerDetails->buy_amount : '0' }}Tk</th>
                                        <th>Total Paid Amount: {{ $buyerDetails->paid_payment ? $buyerDetails->paid_payment : '0' }}Tk</th>
                                        <th>Total Due Amount: {{ $buyerDetails->current_due ? $buyerDetails->current_due : '0' }}Tk</th>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Sale History--}}
                        <h5><strong>Sale History</strong></h5>
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(count($sales) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sale</th>
                                            <th>Invoice No</th>
                                            <th>Amount</th>
                                            <th>Points</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($sales as $key => $sale)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ date('d M Y',strtotime($sale->created_at)) }}</td>
                                                <td><a href="{{ route('sale.show',$sale->id) }}">{{ $sale->invoice_no }}</a></td>
                                                <td>{{ $sale->total_price }} Tk</td>
                                                <td>{{ $sale->total_point }}</td>
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
                                            <th>Payment Date</th>
                                            <th>Paid Amount</th>
                                            <th>Purpose</th>
                                            <th>Payment Method</th>
                                            <th>Collect By</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($accounts as $key => $account)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ date('d M Y',strtotime($account->payment_date)) }}</td>
                                                <td>{{ $account->amount }}Tk</td>
                                                <td>{{ $account->purpose }}</td>
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
