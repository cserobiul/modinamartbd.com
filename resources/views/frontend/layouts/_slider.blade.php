<section class="theme-slider section-pt-space home-slide">
    <div class="custom-container">
        <div class="row">
            <div class="col-xl-8 col-lg-9 offset-xl-2 px-abjust">
                <div class="slide-1 no-arrow">
                    @if(count($sliders = \App\Models\Slider::orderBy('order','ASC')->get()) > 0)
                        @foreach($sliders as $key => $slider)
                            <div>
                                <div class="slider-banner">
                                    <div class="slider-img">
                                        <img src="{{ asset($slider->photo) }}" alt="">
                                    </div>
                                    <div class="slider-banner-contain"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>
                            <div class="slider-banner">
                                <div class="slider-img">
                                    <ul class="layout2-slide-1">
                                        <li id="img-1"><img src="{{ asset('frontend') }}/assets/images/layout-1/slider/1.1.png" class="img-fluid" alt="slider"></li>
                                    </ul>
                                </div>
                                <div class="slider-banner-contain">
                                    <div>
                                        <h4>the best</h4>
                                        <h1>loffer shoes</h1>
                                        <h2>minimum 30% off</h2>
                                        <a href="{{ route('shopPage') }}" class="btn btn-normal">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="slider-banner">
                                <div class="slider-img">
                                    <ul class="layout2-slide-2">
                                        <li id="img-2"><img src="{{ asset('frontend') }}/assets/images/layout-1/slider/1.2.png" class="img-fluid" alt="slider"></li>
                                    </ul>
                                </div>
                                <div class="slider-banner-contain">
                                    <div>
                                        <h4>cinema festival</h4>
                                        <h1>reflex camera</h1>
                                        <h2>minimum 40% off</h2>
                                        <a href="{{ route('shopPage') }}" class="btn btn-normal">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="slider-banner">
                                <div class="slider-img">
                                    <ul class="layout2-slide-3">
                                        <li id="img-3"><img src="{{ asset('frontend') }}/assets/images/layout-1/slider/1.3.png" class="img-fluid" alt="slider"></li>
                                    </ul>
                                </div>
                                <div class="slider-banner-contain">
                                    <div>
                                        <h4>march special</h4>
                                        <h1>leather bag</h1>
                                        <h2>minimum 60% off</h2>
                                        <a href="{{ route('shopPage') }}" class="btn btn-normal">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-2 col-sm-3 pl-0 offer-banner">
                <div class="offer-banner-img">
                    <img src="{{ asset('frontend') }}/assets/images/layout-1/offer-banner.png" alt="offer-banner" class="img-fluid  ">
                </div>
                <div class="banner-contain">
                    <div>
                        <a href="{{ route('shopPage') }}">
                            <h5>Special Offer for you</h5>
                            <div class="discount-offer">
                                <h1>50%</h1>
                                <sup>off</sup>
                            </div >
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


