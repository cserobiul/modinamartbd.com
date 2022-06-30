<!--Newsletter modal popup start-->
{{--<div class="modal fade bd-example-modal-lg theme-modal" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-body">--}}
{{--                <div class="news-latter">--}}
{{--                    <div class="modal-bg">--}}
{{--                        <div class="newslatter-main">--}}
{{--                            <div class="offer-content">--}}
{{--                                <div>--}}
{{--                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                    <h2>newsletter</h2>--}}
{{--                                    <p>Subscribe to our website mailling list <br> and get a Offer, Just for you!</p>--}}
{{--                                    <form action="https://pixelstrap.us19.list-manage.com/subscribe/post?u=5a128856334b598b395f1fc9b&amp;id=082f74cbda" class="auth-form needs-validation" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">--}}
{{--                                        <div class="form-group mx-sm-3">--}}
{{--                                            <input type="email" class="form-control" name="EMAIL" id="mce-EMAIL" placeholder="Enter your email" required="required">--}}
{{--                                            <button type="submit" class="btn btn-theme btn-normal btn-sm " id="mc-submit">subscribe</button>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="imd-wrraper">--}}
{{--                                <img src="{{ asset('frontend') }}/assets/images/subscribe/1.jpg" alt="newsletterimg" class="img-fluid bg-img">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<!--Newsletter Modal popup end-->

<!-- add to cart bar -->
<div id="wishlist_side" class="add_to_cart right ">
    <a href="javascript:void(0)" class="overlay"  onclick="closeWishlist()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>My Cart</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeWishlist()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">
            <ul class="cart_product header-cart-details">
                <li>
                    <div class="media">
                        <a href="#">
                            <img alt="megastore1" class="me-3" src="{{ asset('frontend') }}/assets/images/layout-2/product/1.jpg">
                        </a>
                        <div class="media-body">
                            <a href="product-page(left-sidebar).html">
                                <h4>redmi not 3</h4>
                            </a>
                            <h6>
                                $80.00 <span>$120.00</span>
                            </h6>
                            <div class="addit-box">
                                <div class="pro-add">
                                    <a href="javascript:void(0)">
                                        <i  data-feather="trash-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                 <li>
                    <div class="media">
                        <a href="#">
                            <img alt="megastore1" class="me-3" src="{{ asset('frontend') }}/assets/images/layout-2/product/1.jpg">
                        </a>
                        <div class="media-body">
                            <a href="product-page(left-sidebar).html">
                                <h4>redmi not 3</h4>
                            </a>
                            <h6>
                                $80.00 <span>$120.00</span>
                            </h6>
                            <div class="addit-box">
                                <div class="pro-add">
                                    <a href="javascript:void(0)">
                                        <i  data-feather="trash-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
            <ul class="cart_total">
                <li>
                    <div class="total">
                        subtotal<span class="cart-total-price">৳ 0.00</span>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <a href="{{ route('cartPage') }}" class="btn btn-solid btn-block btn-md">view cart</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- add to cart bar end-->

<!-- My account bar start-->
<div id="myAccount" class="add_to_cart right account-bar">
    <a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my account</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeAccount()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <form class="theme-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="e.g.: info@zariq.com.bd"  required autofocus>
            </div>
            <div class="form-group">
                <label for="review">Password</label>
                <input type="password" minlength="6" maxlength="20" class="form-control" id="password" placeholder="********" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-solid btn-md btn-block ">Login</button>
            </div>
            <div class="accout-fwd">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="d-block"><h5>forget password?</h5></a>
                @endif
            </div>
        </form>
    </div>
</div>
<!-- Add to account bar end-->

<!-- add to  setting bar  start-->
{{--<div id="mySetting" class="add_to_cart right">--}}
{{--    <a href="javascript:void(0)" class="overlay" onclick="closeSetting()"></a>--}}
{{--    <div class="cart-inner">--}}
{{--        <div class="cart_top">--}}
{{--            <h3>my setting</h3>--}}
{{--            <div class="close-cart">--}}
{{--                <a href="javascript:void(0)" onclick="closeSetting()">--}}
{{--                    <i class="fa fa-times" aria-hidden="true"></i>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="setting-block">--}}
{{--            <div class="form-group">--}}
{{--                <select>--}}
{{--                    <option value="">language</option>--}}
{{--                    <option value="">english</option>--}}
{{--                    <option value="">french</option>--}}
{{--                    <option value="">hindi</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <select>--}}
{{--                    <option value="">currency</option>--}}
{{--                    <option value="">uro</option>--}}
{{--                    <option value="">ruppees</option>--}}
{{--                    <option value="">piund</option>--}}
{{--                    <option value="">doller</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<!-- add to  setting bar  end-->

<!-- cookie bar start -->
{{--<div class="cookie-bar">--}}
{{--    <p>We use cookies to improve our site and your shopping experience. By continuing to browse our site you accept our cookie policy.</p>--}}
{{--    <a href="javascript:void(0)" class="btn btn-solid btn-xs">accept</a>--}}
{{--    <a href="javascript:void(0)" class="btn btn-solid btn-xs">decline</a>--}}
{{--</div>--}}
<!-- cookie bar end -->

<!-- notification product -->
{{--<div class="product-notification" id="dismiss">--}}
{{--    <span  onclick="dismiss();" class="btn-close" aria-hidden="true"></span>--}}
{{--    <div class="media">--}}
{{--        <img class="me-2" src="{{ asset('frontend') }}/assets/images/layout-1/product/5.jpg" alt="Generic placeholder image">--}}
{{--        <div class="media-body">--}}
{{--            <h5 class="mt-0 mb-1">Latest trending</h5>--}}
{{--            Cras sit amet nibh libero, in gravida nulla.--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<!-- notification product -->
