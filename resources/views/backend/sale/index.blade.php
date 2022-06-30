@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Sale List')
@section('saleList','active')
@section('customPluginCSS')
    <!-- Multi Select Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/multi-select/css/multi-select.css') }}">
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}"/>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.css') }}"/>
    {{--    datatable--}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Sale List' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Sales</a></li>
                        <li class="breadcrumb-item active">All Sale List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i
                            class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i
                            class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @canany(['sale.create'])
                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('sale.create') }}">New
                    Sale</a>
            @endcanany
            @canany(['sale.all'])
                <div class="row clearfix">
                    {{-- sale list start --}}
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Sale List</strong></h2>
                            </div>
                            <div class="body" style="border: 2px solid #dddddd;">
                                @if(!empty($sales))
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sale Date</th>
                                                <th>Invoice No</th>
                                                <th>Sale Amount</th>
                                                <th>Customer</th>
                                                <th>Sale by</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($sales as $key => $sale)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ date('d M Y',strtotime($sale->sale_date)) }}</td>
                                                    <td>
                                                        <a href="{{ route('sale.show',$sale->id) }}">{{ $sale->invoice_no  }}</a>
                                                    </td>
                                                    <td>{{ $sale->total_price }} Tk</td>
                                                    <td>
                                                        <a href="{{ route('buyer.due.details',$sale->buyer->id) }}">
                                                            {{ ucwords($sale->buyer->name) }}
                                                        </a></td>
                                                    <td>{{ ucwords($sale->user->name) }}</td>
                                                    @canany(['sale.update'])
                                                        <td>
                                                            <a href="{{ route('sale.print',$sale->id) }}">Print</a>
                                                            {{--  <a href="{{ route('sale.edit',$sale->id) }}">Edit</a>--}}
                                                        </td>
                                                    @endcanany
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <h6 class="pt-3 text-danger"> No Sales Found...
                                            @canany(['sale.create'])
                                                <a class="btn btn-raised btn-primary btn-round waves-effect"
                                                   href="{{ route('sale.create') }}">Create New Sale</a>
                                            @endcanany
                                        </h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- sale list end --}}
                </div>
            @endcanany


        </div>
    </div>
@endsection
@section('customPluginJS')
    <script
        src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js -->
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
