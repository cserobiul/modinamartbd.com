<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{ route('dashboard') }}">
            @if(!empty($settings->logo))
                <img src="{{ asset($settings->logo)  }}" width="160" alt="Apol"><br>
                {{--                <span class="m-l-10">{{ $settings->app_name }}</span>--}}
                <span class="m-l-10">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
            @else
                <img src="{{ asset('assets/images/logo.svg') }}" width="25" alt="Logo"><span class="m-l-10">Apol</span>
            @endif
        </a>
    </div>
    <div class="menu">
        <ul class="list">
            <li><a href="{{ route('home') }}" target="_new"><i class="zmdi zmdi-globe-alt"></i><span>Website</span></a>
            </li>
            <li class="{{ \Illuminate\Support\Facades\Route::is(['dashboard']) ? 'active':'' }}"><a
                    href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            {{-- <li><a href="my-profile.html"><i class="zmdi zmdi-account"></i><span>Our Profile</span></a></li>--}}

            {{-- Sale start--}}
            @canany(['sale.all'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['sale*']) ? 'active open':'' }}"><a
                        href="javascript:void(0);" class="menu-toggle"><i
                            class="zmdi zmdi-shopping-cart"></i><span>Sale</span></a>
                    <ul class="ml-menu">
                        @canany(['sale.create'])
                            <li class="@yield('saleCreate')"><a href="{{ route('sale.create') }}">New Sale</a></li>
                        @endcanany
                        @canany(['sale.all'])
                            <li class="@yield('saleList')"><a href="{{ route('sale.index') }}">All Sale</a></li>
                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- Sale end--}}

            {{-- Product start--}}
            @canany(['product.all'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['product*']) ? 'active open':'' }}"><a
                        href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Products</span></a>
                    <ul class="ml-menu">
                        @canany(['product.create'])
                            <li class="@yield('productCreate')"><a href="{{ route('product.create') }}">New Product</a>
                            </li>
                        @endcanany
                        @canany(['product.all'])
                            <li class="@yield('productList')"><a href="{{ route('product.index') }}">All Products</a>
                            </li>
                        @endcanany
                    </ul>
                </li>
            @endcanany
            {{-- Product end--}}



            {{-- Order start--}}
            @canany(['order.all'])
                <li class="open_top {{ (request()->is(['orderList','order-*','order/*'])) ? 'active open':'' }}"><a
                        href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Orders</span></a>
                    <ul class="ml-menu">
                        @canany(['order.create'])
                            {{--                            <li class="@yield('orderCreate')"><a href="{{ route('order.create') }}">New Order</a></li>--}}
                        @endcanany
                        @canany(['order.all'])
                            <li class="@yield('newOrder')"><a href="{{ route('newOrder') }}">New Orders</a></li>
                            <li class="@yield('confirmedOrder')"><a href="{{ route('confirmedOrder') }}">Confirmed
                                    Orders</a></li>
                            <li class="@yield('shippingOrder')"><a href="{{ route('shippingOrder') }}">Shipping
                                    Orders</a></li>
                            <li class="@yield('deliveredOrder')"><a href="{{ route('deliveredOrder') }}">Delivered
                                    Orders</a></li>
                        @endcanany
                    </ul>
                </li>
            @endcanany
            {{-- Order end--}}

            {{-- Purchase start--}}
            @canany(['purchase.all'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['purchase*','stock*']) ? 'active open':'' }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Purchases</span></a>
                    <ul class="ml-menu">
                        @canany(['purchase.create'])
                            <li class="@yield('purchaseCreate')"><a href="{{ route('purchase.create') }}">New
                                    Purchase</a></li>
                        @endcanany
                        @canany(['purchase.all'])
                            <li class="@yield('purchaseList')"><a href="{{ route('purchase.index') }}">All Purchases</a>
                            </li>
                        @endcanany
                        @canany(['purchase.all'])
                            <li class="@yield('stockList')"><a href="{{ route('stock.index') }}">Stock</a></li>
                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- Purchase end--}}

            {{-- customer start--}}
{{--            @canany(['customer.all'])--}}
{{--                <li class="open_top {{ (request()->is('customer*')) ? 'active open':'' }}"><a href="javascript:void(0);"--}}
{{--                                                                                              class="menu-toggle"><i--}}
{{--                            class="zmdi zmdi-account"></i><span>Customers</span></a>--}}
{{--                    <ul class="ml-menu">--}}
{{--                        @canany(['customer.all','customer.create'])--}}
{{--                            <li class="@yield('customerList')"><a href="{{ route('customer.index') }}">Online--}}
{{--                                    Customer</a></li>--}}
{{--                        @endcanany--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endcanany--}}
            {{-- customer end--}}

            {{-- Supplier start--}}
            @canany(['supplier.all'])
                <li class="open_top {{ (request()->is('supplier*')) ? 'active open':'' }}"><a href="javascript:void(0);"
                                                                                              class="menu-toggle"><i
                            class="zmdi zmdi-account"></i><span>Suppliers</span></a>
                    <ul class="ml-menu">
                        @canany(['supplier.all','supplier.create'])
                            <li class="@yield('supplierList')"><a href="{{ route('supplier.index') }}">All Suppliers</a>
                            </li>
                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- Supplier end--}}


            {{-- Accounts start--}}
            @canany(['accounts.all'])
                <li class="open_top {{ (request()->is('accounts/*')) ? 'active open':'' }}"><a
                        href="javascript:void(0);" class="menu-toggle"><i
                            class="zmdi zmdi-money"></i><span>Accounts</span></a>
                    <ul class="ml-menu">
                        @canany(['accounts.all'])
                            <li class="@yield('buyerDueCollection')"><a href="{{ route('buyerDueCollection') }}">Due
                                    Collection</a></li>
                            <li class="@yield('billPaid')"><a href="{{ route('billPaid') }}">Pay to Supplier</a></li>
                            <li class="@yield('buyerProductReturn')"><a href="{{ route('buyerProductReturn') }}">Customer
                                    Return</a></li>
                            <li class="@yield('customerProductReturn')"><a href="{{ route('customerProductReturn') }}">Online
                                    Customer Return</a></li>
                            <li class="@yield('supplierProductReturn')"><a href="{{ route('supplierProductReturn') }}">Supplier
                                    Return</a></li>

                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- Accounts end--}}



            {{-- Report start--}}
            @canany(['report.all'])
                <li class="open_top {{ (request()->is('report/*')) ? 'active open':'' }}"><a href="javascript:void(0);"
                                                                                             class="menu-toggle"><i
                            class="zmdi zmdi-money-box"></i><span>Reports</span></a>
                    <ul class="ml-menu">
                        @canany(['report.all'])
                            <li class="@yield('buyerList')"><a href="{{ route('buyerList') }}">Customer List</a></li>
                            <li class="@yield('customerList')"><a href="{{ route('customerList') }}">Online Customer List</a></li>
                            <li class="@yield('buyerDueList')"><a href="{{ route('buyer.due') }}">Customer Due</a></li>
                            <li class="@yield('supplierDueList')"><a href="{{ route('supplier.due') }}">Supplier Due</a></li>
                            <li class="@yield('customerDueList')"><a href="{{ route('customer.due') }}">Online Customer
                                    Due</a></li>
                            <li class="@yield('buyerReturnList')"><a href="{{ route('buyerReturnList') }}">Customer
                                    Return</a></li>
                            <li class="@yield('customerReturnList')"><a href="{{ route('customerReturnList') }}">Online
                                    Customer Return</a></li>
                            <li class="@yield('supplierReturnList')"><a href="{{ route('supplierReturnList') }}">Supplier
                                    Return</a></li>
                            <li class="@yield('buyerPoint')"><a href="{{ route('buyerPoint') }}">Customer Point</a></li>
                            <li class="@yield('customerPoint')"><a href="{{ route('customerPoint') }}">Online Customer
                                    Point</a></li>
                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- Report end--}}

            {{-- Notebook start--}}
            @canany(['slider.all'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['notebook*']) ? 'active open':'' }}"><a
                        href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-note"></i><span>Notebooks</span></a>
                    <ul class="ml-menu">
                        @canany(['notebook.all','notebook.create'])
                            <li class="@yield('notebookList')"><a href="{{ route('notebook.index') }}">All Notebooks</a></li>
                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- Notebook end--}}
            {{-- Slider start--}}
            @canany(['slider.all'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['slider*']) ? 'active open':'' }}"><a
                        href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-photo-size-select-large"></i><span>Sliders</span></a>
                    <ul class="ml-menu">
                        @canany(['slider.all','slider.create'])
                            <li class="@yield('sliderList')"><a href="{{ route('slider.index') }}">All Sliders</a></li>
                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- Slider end--}}


            {{-- User start--}}
            @canany(['user.all','profile.update'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['user*','profile*']) ? 'active open':'' }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i
                            class="zmdi zmdi-account"></i><span>Users</span></a>
                    <ul class="ml-menu">
                        @canany(['user.create'])
                            <li class="@yield('userCreate')"><a href="{{ route('user.create') }}">New User</a></li>
                        @endcanany
                        @canany(['user.all'])
                            <li class="@yield('userList')"><a href="{{ route('user.index') }}">All Users</a></li>
                        @endcanany
                        @canany(['profile.update'])
                            <li class="@yield('profileUpdate')"><a href="{{ route('profile.edit') }}">Profile Update</a>
                            </li>
                        @endcanany

                    </ul>
                </li>
            @endcanany
            {{-- User end--}}

            {{-- Role start--}}
            @canany(['role.all'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['role*']) ? 'active open':'' }}"><a
                        href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-lock"></i><span>Roles</span></a>
                    <ul class="ml-menu">
                        @canany(['role.create'])
                            <li class="@yield('roleCreate')"><a href="{{ route('role.create') }}">New Role</a></li>
                            <li class="@yield('permissionCreate')"><a href="{{ url('permission') }}">New Permission</a>
                            </li>
                        @endcanany
                        @canany(['role.all'])
                            <li class="@yield('roleList')"><a href="{{ route('role.index') }}">All Roles</a></li>
                        @endcanany
                    </ul>
                </li>
            @endcanany
            {{-- Role end--}}

            {{-- Settings start--}}
            @canany(['settings.all'])
                <li class="open_top {{ \Illuminate\Support\Facades\Route::is(['settings*','brand*','size*','color*','category*','unit*','warranty*','payment_method*']) ? 'active open':'' }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i
                            class="zmdi zmdi-settings"></i><span>Settings</span></a>
                    <ul class="ml-menu">
                        @canany(['settings.update'])
                            <li class="@yield('settingsList')"><a href="{{ route('settings.index') }}">Default
                                    Settings</a></li>
                        @endcanany
                        <li class="@yield('brandList')"><a href="{{ route('brand.index') }}">Brand</a></li>
                        <li class="@yield('categoryList')"><a href="{{ route('category.index') }}">Category</a></li>
                        {{--                    <li class="@yield('colorList')"><a href="{{ route('color.index') }}">Color</a></li>--}}
                        <li class="@yield('paymentMethodList')"><a href="{{ route('payment_method.index') }}">Payment
                                Method</a></li>
                        {{--                    <li class="@yield('sizeList')"><a href="{{ route('size.index') }}">Size</a></li>--}}
                        <li class="@yield('unitList')"><a href="{{ route('unit.index') }}">Unit</a></li>
                        <li class="@yield('warrantyList')"><a href="{{ route('warranty.index') }}">Warranty</a></li>
                    </ul>
                </li>
            @endcanany
            {{-- Settings end--}}


            <li>
                <a class="mega-menu" title="Sign Out" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="zmdi zmdi-power"></i><span>{{ __('Logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

            <li>
                <div class="progress-container progress-primary m-t-10">
                    <span class="progress-badge">Traffic this Month</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="67"
                             aria-valuemin="0" aria-valuemax="100" style="width: 67%;">
                            <span class="progress-value">67%</span>
                        </div>
                    </div>
                </div>
                <div class="progress-container progress-info">
                    <span class="progress-badge">Server Load</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="86"
                             aria-valuemin="0" aria-valuemax="100" style="width: 86%;">
                            <span class="progress-value">86%</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</aside>
