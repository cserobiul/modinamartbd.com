@extends('frontend.layouts.master')
@section('title', 'Checkout Page')
@section('checkoutPage','active')
@section('mainCss')
    <style>
        input[type=text],input[type=email],textarea {
            border: 1px solid #00baa3 !important;
        }
    </style>
@endsection

@section('mainContent')
    <section class="tab-product tab-exes vertical-tab ">
        <div class="custom-container">
            <div class="row tab-border">
                <div class="col-xl-2 p-0">
                    <ul class="nav nav-tabs nav-material flex-column nav-border" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-account-dashboard-tab" data-bs-toggle="tab" href="#account-dashboard" role="tab" aria-selected="true">Account Info</a></li>
                        <li class="nav-item"><a class="nav-link" id="account-orders-top-tab" data-bs-toggle="tab" href="#account-orders" role="tab" aria-selected="false">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" id="account-points-top-tab" data-bs-toggle="tab" href="#account-points" role="tab" aria-selected="false">Reward Points</a></li>
                        <li class="nav-item"><a class="nav-link" id="account-address-top-tab" data-bs-toggle="tab" href="#account-address" role="tab" aria-selected="false">Address</a></li>
                        <li class="nav-item"><a class="nav-link" id="account-details-top-tab" data-bs-toggle="tab" href="#account-details" role="tab" aria-selected="false">Profile Update</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <span>{{ __('Logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-10">
                    <div class="tab-content nav-material" id="top-tabContent">

                        <div class="tab-pane fade show active" id="account-dashboard" role="tabpanel" aria-labelledby="top-account-dashboard-tab">
                            <div class="dashboard-right">
                                <div class="dashboard">
                                    <div class="page-title">
                                        <h2>My Dashboard</h2></div>
                                    <div class="welcome-msg">
                                        <p>Hello, {{ ucwords(\Illuminate\Support\Facades\Auth::user()->name) }} !</p>
                                        <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.
                                            (not
                                            <span class="text-dark font-weight-bold">{{ ucwords(\Illuminate\Support\Facades\Auth::user()->name) }}</span>?
                                            <a class="mega-menu" title="Log Out" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                <i class="zmdi zmdi-power"></i><span>{{ __('Logout') }}</span>
                                            </a>)
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="account-orders" role="tabpanel" aria-labelledby="account-orders-top-tab">
                            <div class="dashboard-right">
                                <div class="dashboard">
                                    <div class="page-title">
                                        <h2>My Orders</h2></div>
                                    <div class="box-account box-info">
                                        <div class="row">
                                            @if(count($orders) > 0)
                                                <table class="shop-table account-orders-table mb-6">
                                                    <thead>
                                                    <tr style="text-align: center">
                                                        <th>#</th>
                                                        <th>Order Date</th>
                                                        <th>Order Id</th>
                                                        <th>Amount</th>
                                                        <th>Discount</th>
                                                        <th>Status</th>
                                                        <th>Order Note</th>
                                                        <th>Shipping Address</th>
                                                    </tr>
                                                    </thead>
                                                    @foreach($orders as $key => $order)
                                                        <tr style="text-align: center">
                                                            <th scope="row">{{ $key+1 }}</th>
                                                            <td>{{ date('d M Y, h:m a',strtotime($order->created_at)) }}</td>
                                                            <td>{{ $order->oid  }}</td>
                                                            <td>{{ $order->total_price }}Tk</td>
                                                            <td>{{ $order->total_discount }}Tk</td>
                                                            <td>{{ ucwords($order->status) }}</td>
                                                            <td>{{ $order->order_note ? ucwords($order->order_note) : '-' }}</td>
                                                            <td>{{ $order->shipping_address ? ucwords($order->shipping_address) : '-' }}</td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                </table>
                                            @else
                                                <p>No order has been made yet.</p>
                                                <a href="{{ route('home') }}" class="btn btn-dark btn-rounded btn-icon-right">Go
                                                    Shop<i class="w-icon-long-arrow-right"></i></a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="account-points" role="tabpanel" aria-labelledby="account-points-top-tab">
                            <div class="dashboard-right">
                                <div class="dashboard">
                                    <div class="page-title">
                                        <h2>My points</h2></div>

                                        @php
                                            $customerId = \App\Models\Customer::where('user_id',auth()->user()->id)->first()
                                        @endphp
                                        <h5> Total Earn Point:
                                               {{ \App\Models\Reward::customerEarnPoints($customerId->id) }}</h5>
                                        <h5> Total Withdraw Point:
                                              {{ \App\Models\Reward::customerWithdrawPoints($customerId->id) }}</h5>
                                        <h5> Total Remaining Point:
                                              {{ \App\Models\Reward::customerRemainingPoints($customerId->id) }}</h5>

                                    <div class="box-account box-info">
                                        <div class="row">
                                            @if(count($points) > 0)
                                                <table class="shop-table account-orders-table mb-6">
                                                    <thead>
                                                    <tr style="text-align: center">
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Point</th>
                                                        <th>Status</th>
                                                        <th>Purpose</th>
                                                    </tr>
                                                    </thead>
                                                    @foreach($points as $key => $point)
                                                        <tr style="text-align: center">
                                                            <th scope="row">{{ $key+1 }}</th>
                                                            <td>{{ date('d M Y, h:m a',strtotime($point->created_at)) }}</td>
                                                            <td>{{ $point->point  }}</td>
                                                            <td>{{ $point->type == 0 ? 'Earn' : 'Withdraw' }}</td>
                                                            <td>{{ $point->purpose }}</td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                </table>

                                            @else
                                                <p>No order has been made yet.</p>
                                                <a href="{{ route('home') }}" class="btn btn-dark btn-rounded btn-icon-right">Go
                                                    Shop</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="account-address" role="tabpanel" aria-labelledby="account-address-top-tab">
                            <div class="dashboard-right">
                                <div class="dashboard">
                                    <div class="page-title">
                                        <h2>My Address</h2></div>
                                    <div class="welcome-msg">
                                        <p> The following addresses will be used on the checkout page
                                            by default. you can change address from Profile Update tab</p>
                                    </div>
                                    <br>
                                    <div class="box-account box-info">
                                        <div class="row">
                                            <address class="mb-4">
                                                <table class="address-table">
                                                    <tbody>
                                                    <tr>
                                                        <th>Name:</th>
                                                        <td>{{ \App\Models\Settings::unicodeName($customer->customer_name)  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address:</th>
                                                        <td>{{ \App\Models\Settings::unicodeName($customer->address)  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone:</th>
                                                        <td>{{ \App\Models\Settings::unicodeName($customer->phone)  }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </address>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="account-details" role="tabpanel" aria-labelledby="account-details-top-tab">
                            <div class="dashboard-right">
                                <div class="dashboard">
                                    <div class="page-title">
                                        <h2>My Profile Update</h2></div>
                                    <div class="welcome-msg">
                                        <div class="alert alert-danger print-error-msg" style="display:none">
                                            <ul></ul>
                                        </div>
                                        <div class="alert alert-success print-success-msg" style="display:none">
                                            <strong></strong>
                                        </div>
                                    </div>
                                    <div class="box-account box-info">
                                        <div class="row">
                                            <form class="form account-details-form"id="customerAccountDetails" method="POST" action="{{ route('customerProfileUpdate') }}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="firstname">Full Name *</label>
                                                            <input type="text" name="name" id="name" value="{{ $customer->customer_name }}" placeholder="John"
                                                                   class="form-control form-control-md">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lastname">Phone *</label>
                                                            <input type="text" name="phone" id="phone" value="{{ $customer->phone }}" maxlength="15" placeholder="01644394107"
                                                                   class="form-control form-control-md">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="display-name">Shipping Address *</label>
                                                    <input type="text" name="address" id="address" value="{{ $customer->address }}" placeholder="House number, Street name/no, thana, district, division"
                                                           class="form-control form-control-md mb-0">
                                                </div>

                                                <div class="form-group mb-6">
                                                    <label for="email_1">Email address *</label>
                                                    <input type="email" name="email" id="email" value="{{ $customer->email }}" class="form-control form-control-md" readonly>
                                                </div>

                                                <h4 class="title title-password ls-25 font-weight-bold">Password change</h4>
                                                <div class="form-group">
                                                    <label class="text-dark" for="new-password">New Password</label>
                                                    <input type="password" name="password" id="password" minlength="8" class="form-control form-control-md" placeholder="********">
                                                </div>
                                                <div class="form-group mb-10">
                                                    <label class="text-dark" for="conf-password">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" id="password_confirmation"  minlength="8" class="form-control form-control-md" placeholder="********">
                                                </div>
                                                <button type="submit" onclick="return confirm('are you sure to update your account details?')" class="btn btn-dark btn-rounded btn-sm mb-4">Save Changes</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('mainJs')
 <script src="{{ asset('assets/js/custom/cu.js') }}"></script>
@endsection
