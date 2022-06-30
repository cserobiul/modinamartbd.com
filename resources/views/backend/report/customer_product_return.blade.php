@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'All Online Customer Return List')
@section('customerReturnList','active')
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
                <h2>All {{ isset($pageTitle) ?  $pageTitle : 'Online Customer Return List' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customerReturnList') }}">Reports</a></li>
                    <li class="breadcrumb-item active">All Online Customer Return List</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @canany(['report.all'])
            <div class="row clearfix">
                {{-- customer list start --}}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Online Customer Return List</strong></h2>
                        </div>
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(!empty($productsReturn))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Invoice Id</th>
                                            <th>Return Date</th>
                                            <th>Amount</th>
                                            <th>Purpose</th>
                                            <th>Note</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($productsReturn as $key => $return)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><a href="{{ route('customerReturnDetails',$return->customer->id) }}">{{ \App\Models\Settings::unicodeName($return->customer->customer_name) }}</a></td>
                                                <td><a href="{{ route('customerProductReturnDetails',$return->id) }}">{{ $return->invoice_id ? $return->invoice_id : '-' }}</a></td>
                                                <td><a href="{{ route('customerProductReturnDetails',$return->id) }}">{{ date('d M Y',strtotime($return->return_date)) }}</a></td>
                                                <td>{{ $return->amount ? $return->amount : '-' }}</td>
                                                <td>{{ $return->purpose ? $return->purpose : '-' }}</td>
                                                <td>{{ $return->remark ? $return->remark : '-' }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger"> No Online Customer Product Return Data Found... </h6>
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
