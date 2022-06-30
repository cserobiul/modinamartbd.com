@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'New Purchase')
@section('purchaseCreate','active')
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
                <form id="form_advanced_validation" method="POST" action="{{ route('purchase.product.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Product Search...</strong></h2>
                        </div>
                             <div class="body" style="border: 2px solid #dddddd;">
                                <div class="row clearfix">
                                    <div class="col-md-12 pb-2">
                                        <label for="product_name">Product Name</label>
                                        <select name="product_name" class="form-control show-tick ms select2" data-placeholder="Select">
                                            <option value="">--Select Product--</option>
                                            @foreach(\App\Models\Product::where('status','active')->orderBy('name')->get() as $product)
                                                <option value="{{ $product->id }}">{{ ucwords($product->name) }} - {{ ucwords($product->code) }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

{{--                                    <div class="col-md-3 pb-2">--}}
{{--                                        <label for="color_name">Product Color</label>--}}
{{--                                        <select name="color_name" class="form-control show-tick ms select2" data-placeholder="Select">--}}
{{--                                            <option value="">--Select Color--</option>--}}
{{--                                            @foreach(\App\Models\Color::where('status','active')->orderBy('color_name')->get() as $color)--}}
{{--                                                <option value="{{ $color->id }}">{{ ucwords($color->color_name) }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('color_name')--}}
{{--                                        <div class="text-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-3 pb-2">--}}
{{--                                        <label for="size_name">Product Size</label>--}}
{{--                                        <select name="size_name" class="form-control show-tick ms select2" data-placeholder="Select">--}}
{{--                                            <option value="">--Select Size--</option>--}}
{{--                                            @foreach(\App\Models\Size::where('status','active')->orderBy('size_name')->get() as $size)--}}
{{--                                                <option value="{{ $size->id }}">{{ ucwords($size->size_name) }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('size_name')--}}
{{--                                        <div class="text-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}

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
                                            <input type="number" name="unit_price" min="1" id="unit_price" value="{{ old('unit_price') }}"  class="form-control" placeholder="e.g. 100" required>
                                        </div>
                                        @error('unit_price')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 pb-2">
                                        <label for="warranty">Warranty</label>
                                        <select name="warranty" class="form-control show-tick ms select2" data-placeholder="Select">
{{--                                            <option value="">--Select Warranty--</option>--}}
                                            @foreach(\App\Models\Warranty::where('status','active')->orderBy('warranty_name')->get() as $warranty)
                                                <option value="{{ $warranty->id }}">{{ ucwords($warranty->warranty_name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('warranty')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 pb-2">
                                        <label for="serial">Serial/Tag</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-tab"></i></span>
                                            </div>
                                            <input type="text" name="serial" value="{{ old('serial') }}"  class="form-control" placeholder="e.g. 123654">
                                        </div>
                                        @error('serial')
                                        <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Add to Purchase</button>
                            </div>

                    </div>
                </div>
                </form>
                {{-- product search section end --}}

                {{-- product list start --}}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Product List</strong></h2>
                        </div>
                        <div class="body">
                            @if(count($tempproducts) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
{{--                                        <th>Color</th>--}}
{{--                                        <th>Size</th>--}}
                                        <th>Warranty</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $totalQuantity = 0;
                                    @endphp
                                    @foreach($tempproducts as $key => $tempproduct)
                                    <tr>
                                        <th scope="row">{{ $key+1 }}</th>
                                        <td>{{ ucwords($tempproduct->product->name) }}</td>
{{--                                        <td>{{ ucwords($tempproduct->color->color_name) }}</td>--}}
{{--                                        <td>{{ $tempproduct->size->size_name }}</td>--}}
                                        <td>{{ $tempproduct->warranty->warranty_name }}</td>
                                        <td>{{ $tempproduct->quantity }}</td>
                                        <td>{{ $tempproduct->unit_price }}</td>
                                        <td>{{ $tempproduct->total_price }}</td>
                                        <td>
                                        <form action="{{ route('purchase.product.dell',$tempproduct->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"><i class="zmdi zmdi-delete"></i></button>
                                        </form>
                                        </td>
                                    </tr>
                                        @php
                                                 $totalPurchaseAmount = $totalPurchaseAmount + $tempproduct->total_price;
                                                 $totalQuantity = $totalQuantity + $tempproduct->quantity;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th>#</th>
{{--                                        <th></th>--}}
{{--                                        <th></th>--}}
                                        <th></th>
                                        <th></th>
                                        <th>{{ $totalQuantity }}</th>
                                        <th></th>
                                        <th>{{ $totalPurchaseAmount }}</th>
                                        <th></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @else
                                Product List Empty...
                            @endif
                        </div>
                    </div>
                </div>
                {{-- product list end --}}

                {{-- product purchase payment section start --}}
                <form id="form_advanced_validation" method="POST" action="{{ route('purchase.store') }}" enctype="multipart/form-data">
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
                                        <input type="date" name="purchase_date" value="{{ old('purchase_date',date("Y-m-d", strtotime("now"))) }}"  class="form-control" placeholder="Select Purchase Date" required>
                                    </div>
                                    @error('purchase_date')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 pb-2">
                                    <label for="supplier_name">Supplier</label>
                                    <select name="supplier_name" class="form-control show-tick ms select2" data-placeholder="Select" required>
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
                                        <input type="text" name="invoice_no" value="{{ old('invoice_no',$invoice_no) }}"  class="form-control" placeholder="Input Invoice No" readonly required>
                                    </div>
                                    @error('invoice_no')
                                    <div class="text-danger pt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 pb-2">
                                    <label for="payment_method">Payment Method</label>
                                    <select name="payment_method" class="form-control show-tick ms select2" data-placeholder="Select" required>
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
                                        <input type="text" name="transaction_id" value="{{ old('transaction_id') }}" class="form-control" placeholder="Type Transaction Id" required>
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
                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Purchase Place</button>
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
