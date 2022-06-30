<section class="megastore-slide collection-banner section-py-space b-g-white">
    <div class="container-fluid">
        <div class="row mega-slide-block">
            <div class="col-xl-9 col-lg-12 ">
                <div class="row">
                    <div class="col-12">
                        <div class="slide-1 no-arrow">
                            @if(count($sliders = \App\Models\Slider::orderBy('order','ASC')->get()) > 0)
                                @foreach($sliders as $key => $slider)
                                    <div>
                                        <div class="slide-main">
                                            <img src="{{ asset($slider->photo) }}" class="img-fluid bg-img"
                                                 alt="mega-store">
                                            <div class="slide-contain">

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div>
                                    <div class="slide-main">
                                        <img src="{{ asset('frontend/assets/images/mega-store/slider/1.jpg') }}" class="img-fluid bg-img"
                                             alt="mega-store">
                                        <div class="slide-contain">

                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="collection-banner-main banner-18 banner-style7 collection-color13 p-left text-center">
                            <div class="collection-img">
                                <img src="{{ asset('frontend') }}/assets/images/mega-store/slider/banner/1.jpg"
                                     class="img-fluid bg-img  " alt="banner">
                            </div>
                            <div class="collection-banner-contain ">
                                <div>
                                    <h3>smart watch</h3>
                                    <h4>speacial offer</h4>
                                    <a href="{{ route('shopPage') }}" class="btn btn-rounded btn-xs"> Shop
                                        Now </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="collection-banner-main banner-18 banner-style7 collection-color9 p-left text-center">
                            <div class="collection-img">
                                <img src="{{ asset('frontend') }}/assets/images/mega-store/slider/banner/2.jpg"
                                     class="img-fluid bg-img  " alt="banner">
                            </div>
                            <div class="collection-banner-contain ">
                                <div>
                                    <h3>stylish chair</h3>
                                    <h4>weekend sale</h4>
                                    <a href="{{ route('shopPage') }}" class="btn btn-rounded btn-xs"> Shop
                                        Now </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-12 ">
                <div class="row collection-p6">
                    <div class="col-xl-12 col-lg-4 col-md-6">
                        <div
                            class="collection-banner-main banner-17 banner-style7 collection-color14 p-left text-center">
                            <div class="collection-img">
                                <img src="{{ asset('frontend') }}/assets/images/mega-store/slider/banner/3.jpg"
                                     class="img-fluid bg-img  " alt="banner">
                            </div>
                            <div class="collection-banner-contain ">
                                <div>
                                    <h3>smart glasses</h3>
                                    <h4>best choise</h4>
                                    <a href="{{ route('shopPage') }}" class="btn btn-rounded btn-xs"> Shop
                                        Now </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-4 col-md-6">
                        <div
                            class="collection-banner-main banner-17 banner-style7 collection-color15 p-left text-center">
                            <div class="collection-img">
                                <img src="{{ asset('frontend') }}/assets/images/mega-store/slider/banner/4.jpg"
                                     class="img-fluid bg-img  " alt="banner">
                            </div>
                            <div class="collection-banner-contain ">
                                <div>
                                    <h3>smart led tv</h3>
                                    <h4>now 70% off</h4>
                                    <a href="{{ route('shopPage') }}" class="btn btn-rounded btn-xs"> Shop
                                        Now </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-4 col-md-12">
                        <div class="collection-banner-main banner-18 banner-style7  p-left text-center">
                            <div class="collection-img">
                                <img src="{{ asset('frontend') }}/assets/images/mega-store/slider/banner/5.jpg"
                                     class="img-fluid bg-img  " alt="banner">
                            </div>
                            <div class="collection-banner-contain ">
                                <div>
                                    <h3>smart phone</h3>
                                    <h4>special offer</h4>
                                    <a href="{{ route('shopPage') }}" class="btn btn-rounded btn-xs"> Shop
                                        Now </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




