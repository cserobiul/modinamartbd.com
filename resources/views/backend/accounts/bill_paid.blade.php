@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Bill Paid')
@section('billPaid','active')
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
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Bill Paid' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item">Accounts</li>
                        <li class="breadcrumb-item active">{{ isset($pageTitle) ?  $pageTitle : 'Bill Paid' }}</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @canany(['accounts.create'])
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'PAID Due' }} </strong>to Supplier</h2>
                            </div>
                            @include('backend.layouts._alert')
                            <form id="form_advanced_validation" method="POST" action="{{ route('billPaidProcess') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="body" style="border: 2px solid #dddddd;">
                                    <div class="row clearfix">
                                        <div class="col-md-4 pb-2">
                                            <label for="supplier_name">Supplier Name</label>
                                            <select name="supplier_name" id="supplier_name" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                                <option value="">--Select Supplier--</option>
                                                @foreach(\App\Models\Supplier::orderBy('name')->get() as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ ucwords($supplier->name) }} - {{ ucwords($supplier->phone) }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 pb-2">
                                            <label for="invoice_no">Payment Amount</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                                </div>
                                                <input type="number" min="1" name="amount" id="amount" max="" value="{{ old('amount') }}"  class="form-control" placeholder="Type Amount" required>
                                            </div>
                                            @error('amount')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-4 pb-2">
                                            <label for="payment_date">Payment Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                </div>
                                                <input type="date" name="payment_date" value="{{ old('payment_date',date("Y-m-d", strtotime("now"))) }}"  class="form-control" placeholder="Select Purchase Date" required>
                                            </div>
                                            @error('payment_date')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 pb-2">
                                            <label for="invoice_no">Invoice No</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-code"></i></span>
                                                </div>
                                                <input type="text" name="invoice_no" value="{{ old('invoice_no',$invoice_id) }}"  class="form-control" placeholder="Invoice No" readonly required>
                                            </div>
                                            @error('invoice_no')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 pb-2">
                                            <label for="payment_method">Payment Method</label>
                                            <select name="payment_method" id="payment_method" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                                <option value="">-- Select One --</option>
                                                @foreach(\App\Models\PaymentMethod::where('status','active')->orderBy('payment_name')->get() as $paymentmethod)
                                                    <option value="{{ $paymentmethod->id }}">{{ ucwords($paymentmethod->payment_name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('payment_method')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Pay to Supplier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcanany
            @canany(['accounts.all'])

            @endcanany
        </div>
    </div>
@endsection
@section('customPluginJS')
<script src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js -->
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
@endsection
@section('customJS')
<script>
    // Get Supplier Due
    $('select[name="supplier_name"]').on('change', function(){
        var supplier_name = $(this).val();
        if(supplier_name) {
            $.ajax({
                url: 'supplier-due-check/'+supplier_name,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    console.log(data);
                    $('#amount').attr('max',data);
                    $('#amount').attr('placeholder',data);
                },
            });
        }
    });

</script>
@endsection

