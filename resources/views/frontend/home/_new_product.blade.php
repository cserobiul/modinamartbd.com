<!--title start-->
<div class="title8 section-big-pt-space">
    <h4>new product</h4>
</div>
<!--title end-->

<!-- product tab start -->
<section class="section-big-mb-space ratio_square product">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pr-0">
                <div class="product-slide-5 product-m no-arrow">
                    @foreach($products = \App\Models\Product::where('view_section','NEW_ARRIVAL')->get() as $productItem)
                        <div>
                            <div class="product-box product-box2">
                                <div class="product-imgbox">
                                    <div class="product-front">
                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                            @if($productItem->photo)
                                                <img src="{{ asset($productItem->photo) }}" class="img-fluid  "
                                                     alt="product">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/mega-store/product/1.jpg') }}" class="img-fluid " alt="product">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-back">
                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                            @if($productItem->photo)
                                                <img src="{{ asset($productItem->photo) }}" class="img-fluid  "
                                                     alt="product">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/mega-store/product/1.jpg') }}" class="img-fluid " alt="product">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-icon icon-inline">
                                        <button class="tooltip-top  add-cartnoty" data-tippy-content="Add to cart">
                                            <i data-feather="shopping-cart"></i>
                                        </button>
                                    </div>
                                    <div class="new-label1">
                                        <div>new</div>
                                    </div>
                                    <div class="on-sale1">
                                        on sale
                                    </div>
                                </div>
                                <div class="product-detail product-detail2 ">
                                    <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                        <h3>{{ substr(\App\Models\Settings::unicodeName($productItem->name),0,25) }}</h3>
                                    </a>
                                    <h5>
                                        Tk {{ $productItem->sale_price }}
                                        <span>
                                          Tk {{ $productItem->sale_price + $productItem->discount_amount }}
                                        </span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <div class="product-box product-box2">
                            <div class="product-imgbox">
                                <div class="product-front">
                                    <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                        <img src="{{ asset('frontend') }}/assets/images/mega-store/product/2.jpg"
                                             class="img-fluid  " alt="product">
                                    </a>
                                </div>
                                <div class="product-back">
                                    <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                        <img src="{{ asset('frontend') }}/assets/images/mega-store/product/7.jpg"
                                             class="img-fluid  " alt="product">
                                    </a>
                                </div>
                                <div class="product-icon icon-inline">
                                    <button class="tooltip-top  add-cartnoty" data-tippy-content="Add to cart">
                                        <i data-feather="shopping-cart"></i>
                                    </button>
                                    <a href="javascript:void(0)" class="add-to-wish tooltip-top"
                                       data-tippy-content="Add to Wishlist">
                                        <i data-feather="heart"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                       class="tooltip-top" data-tippy-content="Quick View">
                                        <i data-feather="eye"></i>
                                    </a>
                                    <a href="compare.html" class="tooltip-top" data-tippy-content="Compare">
                                        <i data-feather="refresh-cw"></i>
                                    </a>
                                </div>
                                <div class="new-label1">
                                    <div>new</div>
                                </div>
                                <div class="on-sale1">
                                    on sale
                                </div>
                            </div>
                            <div class="product-detail product-detail2 ">
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                </ul>
                                <a href="product-page(no-sidebar).html">
                                    <h3>men analogue watch</h3>
                                </a>
                                <h5>
                                    $10
                                    <span>
                      $30
                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
<!-- product tab end -->
