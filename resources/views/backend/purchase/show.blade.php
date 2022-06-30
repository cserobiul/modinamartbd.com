@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Purchase Details')
@section('purchaseList','active')
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
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Purchase Details' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}">Purchase</a></li>
                        <li class="breadcrumb-item active">{{ isset($pageTitle) ?  $pageTitle : 'Purchase Details' }}</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @canany(['purchase.create'])
                {{--                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('purchase.create') }}">New Purchase</a>--}}
            @endcanany
            @canany(['purchase.all'])
                @include('backend.layouts._alert')
                <div class="row clearfix">
                    {{-- purchase list start --}}
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Purchase Details' }}</strong></h2> <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered printAble">
                                        <thead>
                                        <tr>
                                            <th colspan="4">Supplier Name: <a href="{{ route('supplier.due.details',$purchase->supplier->id) }}">{{ ucwords($purchase->supplier->name) }}</a> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>Purchase Date: {{ date('d M Y',strtotime($purchase->created_at)) }}</th>
                                            <th>Invoice No: {{ $purchase->invoice_no }}</th>
                                            <th>Phone: {{ $purchase->supplier->phone }}</th>
                                            <th>Email: {{ $purchase->supplier->email }}</th>
                                        </tr>
                                        <tr>
                                            <th>Purchase Amount: {{ $purchase->purchase_amount }}Tk</th>
                                            <th>Purchase Amount: {{ $purchase->purchase_amount }}Tk</th>
                                            <th>Paid Amount: {{ $purchase->pay_amount }}Tk</th>
                                            <th>Due Amount: {{ $purchase->due_amount }}Tk</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="body" style="bpurchase: 2px solid #dddddd;">
                                @if(!empty($purchaseDetails))
                                    <div class="table-responsive">
                                        <table class="table table-bpurchaseed table-striped table-hover dataTable js-exportable text-center printAble" id="list-member3">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Photo</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($purchaseDetails as $key => $purchaseItem)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $purchaseItem->product->name  }}</td>
                                                    <td><img src="{{ asset($purchaseItem->product->photo) }}" alt="product photo" class="rounded" style="width: 80px; margin-bottom: 15px !important;"></td>
                                                    <td>{{ $purchaseItem->quantity }}</td>
                                                    <td>{{ $purchaseItem->unit_price }} Tk</td>
                                                    <td>{{ $purchaseItem->total_price }} Tk</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <h6 class="pt-3 text-danger"> No Purchase Details Found...
                                            @canany(['purchase.create'])
                                                {{--                                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('purchase.create') }}">Create New Purchase</a>--}}
                                            @endcanany
                                        </h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- purchase list end --}}
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
