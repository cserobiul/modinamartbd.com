@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Supplier Due Details')
@section('supplierDueList','active')
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
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Supplier Due Details' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Suppliers</a></li>
                    <li class="breadcrumb-item active">All Supplier Due Details</li>
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
                {{-- supplier list start --}}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Supplier Due Details</strong></h2> <br>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="3">Supplier Name: {{ $supplierDetails->name }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Join Date: {{ date('d M Y',strtotime($supplierDetails->created_at)) }}</th>
                                        <th>Phone: {{ $supplierDetails->phone }}</th>
                                        <th>Email: {{ $supplierDetails->email }}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Purchase Amount: {{ $supplierDetails->purchase_amount ? $supplierDetails->purchase_amount : '0' }}Tk</th>
                                        <th>Total Paid Amount: {{ $supplierDetails->get_payment ? $supplierDetails->get_payment : '0' }}Tk</th>
                                        <th>Total Due Amount: {{ $supplierDetails->current_due ? $supplierDetails->current_due : '0' }}Tk</th>
{{--                                        <th>Total Purchase Amount: {{ \App\Models\Settings::supplierTotalPurchaseAmount($supplierDetails->id) }}Tk</th>--}}
{{--                                        <th>Total Paid Amount: {{ \App\Models\Settings::supplierTotalPaidAmount($supplierDetails->id) }}Tk</th>--}}
{{--                                        <th>Total Due Amount: {{ \App\Models\Settings::supplierTotalDueAmount($supplierDetails->id) }}Tk</th>--}}
{{--                                        --}}
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Purchase History--}}
                        <h5><strong>Purchase History</strong></h5>
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(count($purchases) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Purchase No</th>
                                            <th>Invoice No</th>
                                            <th>Purchase Date</th>
                                            <th>Purchase Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Due Amount</th>
                                            <th>Payment Method</th>
                                            <th>Purchase by</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($purchases as $key => $purchase)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $purchase->purchase_no }}</td>
                                                <td>{{ $purchase->invoice_no }}</td>
                                                <td>{{ date('d M Y',strtotime($purchase->purchase_date)) }}</td>
                                                <td>{{ $purchase->purchase_amount }}</td>
                                                <td>{{ $purchase->pay_amount }}</td>
                                                <td>{{ $purchase->due_amount }}</td>
                                                <td>{{ $purchase->payment->payment_name }}</td>
                                                <td>{{ $purchase->user->name }}</td>
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
                {{-- supplier list end --}}
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
