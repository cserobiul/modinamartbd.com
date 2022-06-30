@extends('backend.layouts.master')
@section('title', isset($pageTitle) ?  $pageTitle : 'Customer Due Collection')
@section('buyerDueCollection','active')
@section('customPluginCSS')
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
                    <h2> {{ isset($pageTitle) ?  $pageTitle : 'Customer Due Collection' }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item">Accounts</li>
                        <li class="breadcrumb-item active">{{ isset($pageTitle) ?  $pageTitle : 'Customer Due Collection' }}</li>
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
                                <h2><strong>{{ isset($pageTitle) ?  $pageTitle : 'Paid Due' }} </strong>from Customer</h2>
                            </div>
                            @include('backend.layouts._alert')

                            <form id="form_advanced_validation" method="POST" action="{{ route('buyerDueCollectionProcess') }}">
                                @csrf
                                <div class="body" style="border: 2px solid #dddddd;">
                                    <div class="row clearfix">
                                        <div class="col-md-4 pb-2">
                                            <label for="name">Customer Name</label>
                                            <select name="name" id="name" class="form-control show-tick ms select2" data-placeholder="Select" required>
                                                <option value="">--Select Customer--</option>
                                                @foreach(\App\Models\Buyer::orderBy('name')->get() as $customer)
                                                    <option value="{{ $customer->id }}">{{ ucwords($customer->name) }} - {{ ucwords($customer->phone) }}</option>
                                                @endforeach
                                            </select>

                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 pb-2">
                                            <label for="amount">Payment Amount</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                                </div>
                                                <input type="number" id="multipleBillAmount" min="1" name="amount" value=""  class="form-control" placeholder="Type Amount" required>
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
                                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Collect</button>
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
<script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script> <!-- Select2 Js -->
@endsection
@section('customJS')

<script>
$(document).ready(function() {
    $('select[name="name"]').on('change', function(){
        var buyer = $(this).val();
        if(buyer) {
            $.ajax({
                url: 'buyer-due-check/'+buyer,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    $('#multipleBillAmount').attr('placeholder',data);
                    $('#multipleBillAmount').attr('max',data);
                },
            });
        }
    });

});
</script>
@endsection

