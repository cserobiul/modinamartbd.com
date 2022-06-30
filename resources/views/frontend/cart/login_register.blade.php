@extends('frontend.layouts.master')
@section('title', 'Checkout Page')
@section('checkoutPage','active')
@section('mainCss')
    <style>
        input[type=text], input[type=email], input[type=password], textarea {
            border: 1px solid #00baa3 !important;
        }
        .checkout-page .checkout-title {
            margin-bottom: 10px;
            margin-left: 30px;
        }
    </style>
@endsection

@section('mainContent')

    <!-- section start -->
    <section class="section-big-py-space b-g-light">
        <div class="custom-container">
            <div class="checkout-page contact-page">
                @if(\Illuminate\Support\Facades\Auth::check())
                @else
                    <div class="login-toggle">
                        Returning customer? <a href="#" onclick="openAccount()" class="d-lg-show login sign-in">Login</a>
                    </div>
                @endif
                <div class="checkout-form">
                    <form class="checkout-form" action="#" method="post">
                        <div class="row">
                            <div class="checkout-success">

                            </div>

                            <div class="col-lg-6 col-sm-12 col-xs-12 afterCheckout">
                                <div class="checkout-title">
                                    <h3>Billing Details</h3>

                                    {{-- error aria--}}
                                    <div class="alert alert-danger print-error-msg" style="display:none; color: red;">
                                        <ul><li></li></ul>
                                    </div>

                                </div>
                                <div class="theme-form">
                                    @if(!empty($customer))
                                        <div class="row check-out">
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>Full Name</label>
                                                <input type="text" id="name" name="name" value="{{ $customer->customer_name }}" readonly>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label class="field-label">Phone</label>
                                                <input type="text" id="phone" name="phone" value="{{ $customer->phone }}" readonly>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label class="field-label">Shipping Full address</label>
                                                <input type="text" id="address" name="address" value="{{ $customer->address }}" required>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label class="field-label">Email Address</label>
                                                <input type="text" id="email" name="email" value="{{ $customer->email }}" readonly>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                                <label class="field-label">Order Note</label>
                                                <input type="text" id="order-notes" name="order-notes" placeholder="Notes about your order, e.g special notes for delivery">
                                            </div>
                                        </div>
                                    @else
                                        <div class="row check-out">
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>Full Name</label>
                                                <input type="text" id="name" name="name" placeholder="e.g.: Md Rofiqul Islam" required>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label class="field-label">Phone</label>
                                                <input type="text" id="phone" name="phone" placeholder="e.g.: 01644394107" required>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label class="field-label">Shipping Full address</label>
                                                <input type="text" id="address" name="address" placeholder="House number and street name" required>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label class="field-label">Email Address</label>
                                                <input type="text" id="email" name="email" placeholder="e.g.: yourname@gmail.com" required>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label class="field-label">Password</label>
                                                <input type="password" id="password" name="password" placeholder="input 8 digit password" required>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                                <label class="field-label">Order Note</label>
                                                <input type="text" id="order-notes" name="order-notes" placeholder="Notes about your order, e.g special notes for delivery">
                                            </div>

                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12 afterCheckout">
                                <div class="checkout-details theme-form  section-big-mt-space">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>Product <span>Total</span></div>
                                        </div>
                                        <ul class="qty checkout-page-view">
                                            <li>Apol Ecom Application × 1 <span>$555.00</span></li>
                                        </ul>
                                        <ul class="sub-total">
                                            <li>Subtotal <span class="count cart-subtotal-price">৳ 0.00</span></li>
                                        </ul>
                                        <ul class="sub-total">
                                            <li>Discount Amount <span class="count cart-discount-price">৳ 0.00</span></li>
                                        </ul>

                                        <ul class="total">
                                            <li>Net Total <span class="count cart-total-price">৳ 0.00</span></li>
                                        </ul>
                                    </div>
                                    <div class="payment-box">
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <ul>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="payment-group" id="payment-2" checked>
                                                            <label for="payment-2">Cash On Delivery<span class="small-text">Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</span></label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-right"><a href="#" class="btn-normal btn orderPlaceBtn">Place Order</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
@endsection
@section('mainJs')

@endsection
