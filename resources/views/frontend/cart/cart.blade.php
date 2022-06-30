@extends('frontend.layouts.master')
@section('title', 'Shopping Cart')
@section('cartPage','active')
@section('mainCss')
    <style>
        .inputNumberCss{
            margin: 0;  padding: 5px;  width: 80%;  font-size: 25px;  height: 50px;  border: 1px solid #cdcdcd;  border-radius: 5px; text-align: center;
        }
    </style>
@endsection

@section('mainContent')
    <!-- breadcrumb start -->
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>cart</h2>
                            <ul>
                                <li><a href="javascript:void(0)">home</a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="javascript:void(0)">cart</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="cart-section section-big-py-space b-g-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">image</th>
                            <th scope="col">product name</th>
                            <th scope="col">price</th>
                            <th scope="col">quantity</th>
                            <th scope="col">action</th>
                            <th scope="col">total</th>
                        </tr>
                        </thead>
                        <tbody class="cart-page-view">

                        </tbody>
                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                        <tr style="float: left !important;">
                            <td>
                                <button type="submit" class="btn btn-rounded btn-default btn-clear" name="clear_cart" value="Clear Cart">Clear Cart</button>
                            </td>
                        </tr>
                        <tr>
                            <td>subtotal price :</td>
                            <td>
                                <h5 class="cart-subtotal-price">৳ 0.00</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>discount amount :</td>
                            <td>
                                <h5 class="cart-discount-price">৳0.00</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>total price :</td>
                            <td>
                                <h5 class="cart-total-price">৳0.00</h5>
                            </td>
                        </tr>


                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-12"><a href="{{ route('shopPage') }}" class="btn btn-normal">continue shopping</a> <a href="{{ route('checkoutPage') }}" class="btn btn-normal ms-3">check out</a></div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection
@section('mainJs')
@endsection
