<footer>
    <div class="footer1">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-main">
                        <div class="footer-box">
                            <div class="footer-title mobile-title">
                                <h5>about</h5>
                            </div>
                            <div class="footer-contant">
                                <div class="footer-logo">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid logoImg" alt="logo">
                                    </a>
                                </div>
                                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC.</p>
                            </div>
                        </div>
                        <div class="footer-box">
                            <div class="footer-title">
                                <h5>Company</h5>
                            </div>
                            <div class="footer-contant">
                                <ul>
                                    <li><a href="javascript:void(0)">about us</a></li>
                                    <li><a href="javascript:void(0)">contact us</a></li>
                                    <li><a href="javascript:void(0)">terms &amp; conditions</a></li>
                                    <li><a href="javascript:void(0)">returns &amp; exchanges</a></li>
                                    <li><a href="javascript:void(0)">shipping &amp; delivery</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="footer-box">
                            <div class="footer-title">
                                <h5>Customer Service</h5>
                            </div>
                            <div class="footer-contant">
                                <ul>
                                    <li><a href="{{ route('dashboard') }}">My Account</a></li>
                                    <li><a href="{{ route('cartPage') }}">View Cart</a></li>
                                    <li><a href="{{ route('checkoutPage') }}">Checkout</a></li>
                                    <li><a href="{{ route('login') }}">Sign In</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="footer-box">
                            <div class="footer-title">
                                <h5>contact us</h5>
                            </div>
                            <div class="footer-contant">
                                <ul class="contact-list">
                                    <li><i class="fa fa-map-marker"></i>{{ $settings->address }}</li>
                                    <li><i class="fa fa-phone"></i>call us: <span><a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></span></li>
                                    <li><i class="fa fa-envelope-o"></i>email us: {{ $settings->email }}</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subfooter dark-footer ">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-8 col-sm-12">
                    <div class="footer-left">
                        <p>{!! $settings->footer ? $settings->footer : 'Copyright © 2022 Apol Ltd. All Rights Reserved.' !!}</p>
                    </div>
                </div>
                <div class="col-xl-6 col-md-4 col-sm-12">
                    <div class="footer-right">
                        <ul class="sosiyal">
                            <li><a href="{{ $settings->social_facebook }}" target="_new"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ $settings->social_instagram }}" target="_new"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="{{ $settings->social_youtube }}" target="_new"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
