@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Stocks')
@section('stockList','active')
@section('customPluginCSS')
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
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Stocks' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stock.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Stocks' }}</a></li>
                        <li class="breadcrumb-item active">All List</li>
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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Stocks' }}</strong> List</h2>
                        </div>

                        @include('backend.layouts._alert')
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(!empty($stocks))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Product Name</th>
                                            <th>Brand</th>
                                            <th>Category</th>
{{--                                            <th>Details</th>--}}
                                            <th>Purchase Qty</th>
                                            <th>Purchase Return</th>
                                            <th>Sales Qty</th>
                                            <th>Sales Return</th>
                                            <th>Stock</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($stocks as $key => $stock)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><a href="#" title="{{ $stock->product->name }}">{{ \Illuminate\Support\Str::words($stock->product->name,5)}}</a></td>
                                                <td>{{ ucwords($stock->product->brand->brand_name) }}</td>
                                                <td>{{ ucwords($stock->product->category->name) }}</td>
{{--                                                <td style="width: 25%">--}}
{{--                                                    @foreach(\App\Models\Stock::where('product_id',$stock->product_id)->get() as $key => $combination)--}}
{{--                                                        {{ ucwords($combination->color->color_name) }} - {{ ucwords($combination->size->size_name) }} - {{ $combination->stock }}--}}
{{--                                                        <br>--}}
{{--                                                    @endforeach--}}
{{--                                                </td>--}}
                                                <td>{{ \App\Models\Stock::where('product_id',$stock->product_id)->sum('purchase') }}</td>
                                                <td>{{ \App\Models\Stock::where('product_id',$stock->product_id)->sum('purchase_return') }}</td>
                                                <td>{{ \App\Models\Stock::where('product_id',$stock->product_id)->sum('sales') }}</td>
                                                <td>{{ \App\Models\Stock::where('product_id',$stock->product_id)->sum('sales_return') }}</td>
                                                <td>{{ \App\Models\Stock::where('product_id',$stock->product_id)->sum('stock') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger"> No Stocks Found...</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection
