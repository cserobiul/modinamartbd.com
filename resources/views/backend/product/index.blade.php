@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Products')
@section('roductList','active')
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
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Products' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ isset($pageTitle) ?  $pageTitle : 'Products' }}</a></li>
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
                            <h2>All <strong>{{ isset($pageTitle) ?  $pageTitle : 'Products' }}</strong> List</h2>
                            @canany(['product.create'])
                                <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('product.create') }}">Create New Product</a>
                            @endcanany
                        </div>

                        @include('backend.layouts._alert')
                        <div class="body" style="border: 2px solid #dddddd;">
                            @if(!empty($products))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable text-center">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Product Name and Code</th>
                                            <th>Business Category</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Price</th>
                                            <th>Point</th>
                                            <th>Has Stock</th>
                                            <th>Photo</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($products as $key => $product)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td><a href="{{ route('product.edit',$product->id) }}">{{ \App\Models\Settings::unicodeName($product->name) }}</a>
                                                    <br> Code: {{ $product->code }}
                                                </td>
                                                <td>{{ \App\Models\Settings::unicodeName($product->business_category)  }}</td>
                                                <td>{{ \App\Models\Settings::unicodeName($product->category->name)  }}</td>
                                                <td>{{ \App\Models\Settings::unicodeName($product->brand->brand_name) }}</td>
                                                <td>{{ $product->sale_price }}</td>
                                                <td>{{ $product->point }}</td>
                                                <td>{{ ($product->has_stock==1) ? 'Yes': 'No' }}</td>
                                                <td>
                                                    @if($product->photo !=null)
                                                        <br>
                                                        <img src="{{ asset($product->photo) }}" alt="product photo" class="rounded" style="width: 140px; margin-bottom: 15px !important;">
                                                    @else
                                                        No Photo
                                                    @endif
                                                </td>
                                                <td>{{ ucwords($product->status) }}</td>
                                                @canany(['product.update'])
                                                    <td><a href="{{ route('product.edit',$product->id) }}">Edit</a></td>
                                                @endcanany
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <h6 class="pt-3 text-danger"> No Products Found...
                                        @canany(['product.create'])
                                            <a class="btn btn-raised btn-primary btn-round waves-effect" href="{{ route('product.create') }}">Create New Product</a>
                                        @endcanany
                                    </h6>
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
