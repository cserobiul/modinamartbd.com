@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New Purchase')
@section('purchaseCreate','active')
@section('customPluginCSS')
    <style>
        .print-error-msg ul{
            margin-bottom: 0 !important;
        }
    </style>
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
                <h2> {{ isset($pageTitle) ?  $pageTitle : 'Purchase Create' }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}">Purchases</a></li>
                    <li class="breadcrumb-item active">New Purchase</li>
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
        @canany(['purchase.create'])
            <div class="row clearfix">
                {{-- product search section start --}}
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Product Search...</strong></h2>
                        </div>
                             <div class="body" style="border: 2px solid #dddddd;">
                                <div class="row clearfix">
                                    <div class="col-md-12 pb-2">
                                        <label for="product_name">Product Name</label>
                                        <select name="product_name" id="product_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                            <option value="">--Select Product--</option>
                                            @foreach(\App\Models\Product::where('status','active')->orderBy('name')->get() as $product)
                                                <option value="{{ $product->id }}">{{ ucwords($product->name) }} - (ID-{{ $product->id }})</option>
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
                                            <input type="number" name="unit_price" min="1" id="unit_price" value="{{ old('unit_price') }}"  class="form-control" placeholder="e.g. 100" required>
                                        </div>
                                        @error('unit_price')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

{{--                                    <div class="col-md-3 pb-2">--}}
{{--                                        <label for="warranty">Warranty</label>--}}
{{--                                        <select name="warranty" id="warranty" class="form-control show-tick ms select22" data-placeholder="Select">--}}
{{--                                            <option value="">--Select Warranty--</option>--}}
{{--                                            @foreach(\App\Models\Warranty::where('status','active')->orderBy('warranty_name')->get() as $warranty)--}}
{{--                                                <option value="{{ $warranty->id }}">{{ ucwords($warranty->warranty_name) }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('warranty')--}}
{{--                                        <div class="text-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}

                                    <div class="col-md-3 pb-2">
                                        <label for="serial">Serial/Tag</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-tab"></i></span>
                                            </div>
                                            <input type="text" name="serial" id="serial" value="{{ old('serial') }}"  class="form-control" placeholder="e.g. 123654">
                                        </div>
                                        @error('serial')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect purchaseCart">Add to Purchase</button>
                            </div>

                    </div>
                </div>
                {{-- product search section end --}}

                {{-- product list start --}}
                <div class="col-lg-12 col-md-12 col-sm-12">
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
                                    <tbody class="purchase-cart-details">
                                    </tbody>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="purchase-cart-total-price">0 Tk</th>
                                        <th><a href="#" class="btn-cart-all-remove" title="Remove All Product"><i class="zmdi zmdi-delete"></i></a></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- product list end --}}

                {{-- product purchase payment section start --}}
                <div class="col-sm-12">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="alert alert-success print-success-msg" style="display:none">
                        <strong></strong>
                    </div>
                </div>

                <form id="purchasePlaceForm" method="POST" action="{{ route('purchase.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Purchase Details</strong></h2>
                            </div>
                            <div class="body" style="border: 2px solid #dddddd;">
                                <div class="row clearfix">
                                    <div class="col-md-3 pb-2">
                                        <label for="purchase_date">Purchase Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                            </div>
                                            <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date',date("Y-m-d", strtotime("now"))) }}"  class="form-control" placeholder="Select Purchase Date" required>
                                        </div>
                                        @error('purchase_date')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 pb-2">
                                        <label for="supplier_name">Supplier</label>
                                        <select name="supplier_name" id="supplier_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                            <option value="">--Select Supplier--</option>
                                            @foreach(\App\Models\Supplier::where('status','active')->orderBy('name')->get() as $supplier)
                                                <option value="{{ $supplier->id }}">{{ ucwords($supplier->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 pb-2">
                                        <label for="invoice_no">Invoice No</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                            </div>
                                            <input type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no',$invoice_no) }}"  class="form-control" placeholder="Input Invoice No" readonly required>
                                        </div>
                                        @error('invoice_no')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 pb-2">
                                        <label for="payment_method">Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="form-control show-tick ms select2" data-placeholder="Select">
                                            <option value="">--Select One--</option>
                                            @foreach(\App\Models\PaymentMethod::where('status','active')->orderBy('payment_name')->get() as $paymentmethod)
                                                <option value="{{ $paymentmethod->id }}">{{ ucwords($paymentmethod->payment_name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('payment_method')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-md-3 pb-2">
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
                                    <div class="col-md-3 pb-2">
                                        <label for="purchase_amount">Purchase Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                            </div>
                                            <input type="number" min="1" name="purchase_amount" id="purchase_amount" value="{{ old('purchase_amount',$totalPurchaseAmount) }}" class="form-control" readonly placeholder="Purchase Amount">
                                        </div>
                                        @error('purchase_amount')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 pb-2">
                                        <label for="pay_amount">Pay Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                            </div>
                                            <input type="number" min="0" name="pay_amount" id="pay_amount" value="{{ old('pay_amount') }}" class="form-control" placeholder="Input Pay Amount" required>
                                        </div>
                                        @error('pay_amount')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 pb-2">
                                        <label for="due_amount">Due Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                            </div>
                                            <input type="number" min="0" name="due_amount" id="due_amount" value="{{ old('due_amount') }}" class="form-control" readonly placeholder="Due Amount">
                                        </div>
                                        @error('due_amount')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect purchasePlace">Purchase Place</button>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- product purchase payment section end --}}
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
<script src="{{ asset('assets/js/custom/purchase.js') }}"></script>
<script>
    $('#pay_amount').on("keyup change", function(e) {
        var pay_amount = $(this).val();
        if(pay_amount) {
            var pay_amount = parseFloat($('#pay_amount').val());
            var purchase_amount = parseFloat($('#purchase_amount').val());

            $due_amount= purchase_amount-pay_amount;

            if($due_amount < 0){
                alert('Pay amount could not bigger than Purchase amount')
            }else{
                $('#due_amount').attr('value',$due_amount);
            }
        }
    })
</script>

@endsection
