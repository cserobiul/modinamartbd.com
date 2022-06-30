<!--tab product-->
<section class="tab-product-main  tab-second">
    <div class="tab-prodcut-contain">
        <ul class="tabs tab-title">
            <li class="current"><a href="tab-all">all</a></li>
            @foreach($categories as $category)
                <li class=""><a href="tab-{{ $category->slug }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
</section>
<!--tab product-->

<!-- product start -->
<section class="section-big-py-space">
    <div class="custom-container">
        <div class="row ">
            <div class="col-12 p-0">
                <div class="theme-tab product">
                    <div class="tab-content-cls ">
                        <div id="tab-all" class="tab-content active default product-block3">
                            <div class="col-12 ">
                                <div class="product-slide-3 no-arrow">
                                    @foreach(\App\Models\Product::where('status','active')->limit(20)->get() as  $product)
                                        <div>
                                            <div class="product-box3">
                                                <div class="media">
                                                    <div class="img-wrapper">
                                                        <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                            @if($product->photo)
                                                                <img class="img-fluid"
                                                                     src="{{ asset($product->photo) }}"
                                                                     alt="product" style="width: 280px; height: 250px; border: 1px solid orange">
                                                            @else
                                                                <img class="img-fluid"
                                                                     src="{{ asset('frontend//assets/images/mega-store/media-product/1.jpg') }}"
                                                                     alt="product">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="product-detail">
                                                            <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                <h3>{{ $product->name }}</h3>
                                                            </a>
                                                            <h4> Tk {{ $product->sale_price }}<span> Tk {{ $product->sale_price + $product->discount_amount }}</span></h4>
                                                            <a class="btn btn-rounded  btn-sm"
                                                               href="{{ route('productDetailsSlug',$product->slug) }}">shop
                                                                now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="product-slide-3 no-arrow">
                                    @foreach(\App\Models\Product::where('status','active')->orderBy('id','DESC')->limit(20)->get() as  $product)
                                        <div>
                                            <div class="product-box3">
                                                <div class="media">
                                                    <div class="img-wrapper">
                                                        <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                            @if($product->photo)
                                                                <img class="img-fluid"
                                                                     src="{{ asset($product->photo) }}"
                                                                     alt="product" style="width: 280px; height: 250px; border: 1px solid orange">
                                                            @else
                                                                <img class="img-fluid"
                                                                     src="{{ asset('frontend//assets/images/mega-store/media-product/1.jpg') }}"
                                                                     alt="product">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="product-detail">
                                                            <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                <h3>{{ $product->name }}</h3>
                                                            </a>
                                                            <h4> Tk {{ $product->sale_price }}<span> Tk {{ $product->sale_price + $product->discount_amount }}</span></h4>
                                                            <a class="btn btn-rounded  btn-sm"
                                                               href="{{ route('productDetailsSlug',$product->slug) }}">shop
                                                                now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @foreach($categories as $category)
                            <div id="tab-{{ $category->slug }}" class="tab-content  product-block3">
                                <div class="col-12">
                                    <div class="product-slide-3 no-arrow">
                                        @foreach(\App\Models\Product::where('status','active')->where('category_id',$category->id)->limit(20)->get() as  $product)
                                            <div>
                                                <div class="product-box3">
                                                    <div class="media">
                                                        <div class="img-wrapper">
                                                            <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                @if($product->photo)
                                                                    <img class="img-fluid"
                                                                         src="{{ asset($product->photo) }}"
                                                                         alt="product">
                                                                    @else
                                                                    <img class="img-fluid"
                                                                         src="{{ asset('frontend//assets/images/mega-store/media-product/1.jpg') }}"
                                                                         alt="product">
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="product-detail">
                                                                <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                    <h3>{{ $product->name }}</h3>
                                                                </a>
                                                                <h4> Tk {{ $product->sale_price }}<span>Tk {{ $product->sale_price + $product->discount_amount }}</span></h4>
                                                                <a class="btn btn-rounded  btn-sm"
                                                                   href="{{ route('productDetailsSlug',$product->slug) }}">shop
                                                                    now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="product-slide-3 no-arrow">
                                        @foreach(\App\Models\Product::where('status','active')->where('category_id',$category->id)->orderBy('id','DESC')->limit(20)->get() as  $product)
                                            <div>
                                                <div class="product-box3">
                                                    <div class="media">
                                                        <div class="img-wrapper">
                                                            <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                @if($product->photo)
                                                                    <img class="img-fluid"
                                                                         src="{{ asset($product->photo) }}"
                                                                         alt="product">
                                                                    @else
                                                                    <img class="img-fluid"
                                                                         src="{{ asset('frontend//assets/images/mega-store/media-product/1.jpg') }}"
                                                                         alt="product">
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="product-detail">
                                                                <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                    <h3>{{ $product->name }}</h3>
                                                                </a>
                                                                <h4> Tk {{ $product->sale_price }}<span>Tk {{ $product->sale_price + $product->discount_amount }}</span></h4>
                                                                <a class="btn btn-rounded  btn-sm"
                                                                   href="{{ route('productDetailsSlug',$product->slug) }}">shop
                                                                    now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product end -->
