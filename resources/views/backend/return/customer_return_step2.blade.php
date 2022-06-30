@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New Return Product')
@section('customerProductReturn','active')
@section('customPluginCSS')
<!-- Bootstrap Select Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.css') }}" />
@endsection
@section('mainContent')
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Return Product Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                    <li class="breadcrumb-item active">{{ isset($pageTitle) ?  $pageTitle : 'Return Product Create' }}</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @include('backend.layouts._alert')
        @canany(['accounts.create'])
            <div class="row clearfix">

                {{-- if success start --}}
                <div class="col-sm-12 beforeReturnProduct" style="display: none">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Successfully Product Return</strong></h2>
                        </div>
                        <div class="body">
                            <form method="POST" action="{{ route('customerProductReturnProcess') }}">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-md-4 pb-2">
                                        <label for="order_id">Order ID</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                            </div>
                                            <input type="text" name="order_id" id="order_id" value="{{ old('order_id') }}" class="form-control" placeholder="e.g.: 21 or OID-1000021" required>
                                        </div>
                                        @error('order_id')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Check Order</button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- if success end --}}

                {{-- product return product payment section start --}}
                <div class="col-sm-12 afterReturnProduct">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Return Product Details</strong></h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-4 pb-2">
                                    <label for="return_date">Return Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                        </div>
                                        <input type="date" name="return_date" id="return_date" value="{{ old('return_date',date("Y-m-d", strtotime("now"))) }}"  class="form-control" placeholder="Select Return Product Date" required>
                                    </div>
                                    @error('return_date')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 pb-2">
                                    <label for="order_id">Order ID</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                        </div>
                                        <input type="text" name="order_id" id="order_id" value="{{ old('order_id',$order->oid) }}" class="form-control" placeholder="e.g.: 21 or OID-1000021" readonly>
                                        <input type="hidden" id="orderId" value="{{ $order->id }}">
                                    </div>
                                    @error('order_id')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 pb-2">
                                    <label for="customer_name">Customer Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                        </div>
                                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name',ucwords($customer->customer_name).' - '.$customer->phone) }}" class="form-control" placeholder="" readonly>
                                    </div>
                                    @error('customer_name')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-md-4 pb-2">
                                    <label for="return_type">Return Type</label>
                                    <select name="return_type" id="return_type" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                        <option value="">--Select Type--</option>
                                        <option>{{ \App\Models\Settings::RETURN_WITH_PRODUCT }}</option>
                                        <option>{{\App\Models\Settings::RETURN_WITH_MONEY }}</option>
                                    </select>
                                    @error('return_type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 pb-2 payment_method_view" style="display: none">
                                    <label for="payment_method">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                        <option value="">--Select One--</option>
                                        @foreach(\App\Models\PaymentMethod::where('status','active')->orderBy('payment_name')->get() as $paymentmethod)
                                            <option value="{{ $paymentmethod->id }}">{{ ucwords($paymentmethod->payment_name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 pb-2 transaction_id_view" style="display: none">
                                    <label for="transaction_id">Transaction Id/Check No</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                        </div>
                                        <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" class="form-control" placeholder="Type Transaction Id">
                                    </div>
                                    @error('transaction_id')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" cus-url="{{ route('customerProductReturnProcessStore') }}" class="btn btn-raised btn-primary btn-round waves-effect customerReturnProductPlace">Return Product Place</button>
                        </div>
                    </div>
                </div>
                {{-- product return product payment section end --}}

                {{-- product search section start --}}
                <div class="col-md-12 afterReturnProduct">
                    <div class="card">
                        <div class="header">
{{--                            <h2><strong>Product Search...</strong></h2>--}}
                        </div>
                         <div class="body" style="border: 2px solid #dddddd;">
                            <div class="row clearfix">
                                <div class="col-md-6 pb-2">
                                    <label for="product_name">Product Name</label>
                                    <select name="product_name" id="product_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                        <option value="">--Select Product--</option>
                                        @foreach($orderDetails as $product)
                                            <option value="{{ $product->product_id }}">{{ ucwords($product->product->name) }} - (ID-{{ ucwords($product->product->id) }})</option>
                                        @endforeach
                                    </select>
                                    @error('product_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 pb-2">
                                    <label for="quantity">Quantity</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                        </div>
                                        <input type="number" name="quantity" min="1" id="quantity" value="{{ old('quantity',1) }}"  class="form-control" placeholder="e.g. 10" required>
                                    </div>
                                    @error('quantity')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 pb-2">
                                    <label for="unit_price">Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                        </div>
                                        <input type="hidden" name="price" id="price">
                                        <input type="hidden" name="product_full_name" id="product_full_name">
                                        <input type="number" name="unit_price" min="1" id="unit_price" class="form-control" placeholder="e.g. 100" required>
                                    </div>
                                    @error('unit_price')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <a class="btn btn-raised btn-primary btn-round waves-effect cus- returnCart">Add to Return Cart</a>
                        </div>
                    </div>
                </div>

                {{-- product search section end --}}

                {{-- product list start --}}
                <div class="col-lg-12 col-md-12 col-sm-12 afterReturnProduct">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Product List</strong></h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="return-cart-details">
                                    </tbody>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th></th>
                                        <th class=""></th>
                                        <th class="return-cart-total-price">0 Tk</th>
                                        <th><a href="#" class="btn-cart-all-remove" title="Remove All Product"><i class="zmdi zmdi-delete"></i></a></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- product list end --}}

            </div>
        @endcanany
    </div>
</div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
@endsection
@section('customJS')
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('assets/js/return_cart.js') }}"></script>
<script>
    $('select[name="return_type"]').on('change', function(){
        var return_type = $(this).val();
        if (return_type == 'RETURN_WITH_PRODUCT'){
            $('.payment_method_view').hide();
            $('.transaction_id_view').hide();
        }else if(return_type == 'RETURN_WITH_MONEY'){
            $('.payment_method_view').show();
            $('.transaction_id_view').show();
        }
    });
</script>

@endsection
