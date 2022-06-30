@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Sale Details')
@section('saleList','active')
@section('customPluginCSS')
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}"/>
    {{--    datatable--}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        td {
            vertical-align: middle !important;
        }
    </style>
@endsection
@section('mainContent')
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Sale Details' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Sale</a></li>
                        <li class="breadcrumb-item active">{{ isset($pageTitle) ?  $pageTitle : 'Sale Details' }}</li>
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
                {{--                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('sale.create') }}">New Sale</a>--}}
            @endcanany
            @canany(['sale.all'])
                @include('backend.layouts._alert')
                <div class="row clearfix">
                    {{-- sale list start --}}
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Sale Details' }}</strong></h2> <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered printAble">
                                        <thead>
                                        <tr>
                                            <th colspan="4">Buyer Name:
                                                <a href="{{ route('buyer.due.details',$sale->buyer->id) }}">{{ ucwords($sale->buyer->name) }}</a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>Sale Date: {{ date('d M Y',strtotime($sale->created_at)) }}</th>
                                            <th>Invoice No: {{ $sale->invoice_no }}</th>
                                            <th>Phone: {{ $sale->buyer->phone }}</th>
                                            <th>Email: {{ $sale->buyer->email }}</th>
                                        </tr>
                                        <tr>
                                            <th>Sale Amount: {{ $sale->total_price }}Tk</th>
                                            <th>
                                                Discount: {{  $sale->total_discount ? $sale->total_discount.' Tk' : 'N/A' }}
                                                @if($sale->special_discount)
                                                    <br>
                                                    Special
                                                    Discount: {{  $sale->special_discount ? $sale->special_discount.' Tk' : 'N/A' }}
                                                @endif

                                            </th>
                                            <th> Paid Amount: {{  $sale->paid ? $sale->paid.' Tk' : 'N/A' }}  </th>
                                            <th> Due Amount: {{  $sale->due ? $sale->due.' Tk' : 'N/A' }}  </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="body" style="border: 2px solid #dddddd;">
                                @if(!empty($saleDetails))
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bsaleed table-striped table-hover dataTable js-exportable text-center printAble"
                                            id="list-member3">
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
                                            @foreach($saleDetails as $key => $saleItem)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $saleItem->product->name  }}</td>
                                                    <td><img src="{{ asset($saleItem->product->photo) }}"
                                                             alt="product photo" class="rounded"
                                                             style="width: 80px; margin-bottom: 15px !important;"></td>
                                                    <td>{{ $saleItem->quantity }}</td>
                                                    <td>{{ $saleItem->price }} Tk</td>
                                                    <td>{{ $saleItem->price* $saleItem->quantity }} Tk</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <h6 class="pt-3 text-danger"> No Sale Details Found...
                                            @canany(['sale.create'])
                                                {{--                                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('sale.create') }}">Create New Sale</a>--}}
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
                            stripHtml: false,
                            columns: [0, 1, 2, 3, 5, 6, 7]
                            //specify which column you want to print
                        }
                    }

                ]
            });

        });
    </script>
@endsection
