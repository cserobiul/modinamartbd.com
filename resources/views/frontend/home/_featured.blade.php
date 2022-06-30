<section class=" ratio_square">
    <div class="custom-container b-g-white section-pb-space">
        <div class="row">
            <div class="col p-0">
                <div class="theme-tab product">
                    <ul class="tabs tab-title media-tab">
                        <li class="current"><a href="tab-new_arrival">New Arrival</a></li>
                        <li class=""><a href="tab-most_popular">Most Popular</a></li>
                        <li class=""><a href="tab-best_sellers">Best Sellers</a></li>
                        <li class=""><a href="tab-flash_sell">Flash Sell</a></li>
                    </ul>
                    <div class="tab-content-cls">
                        <div id="tab-new_arrival" class="tab-content active default ">
                            <div class="media-slide-5 product-m no-arrow">
                                @php
                                 $products = \App\Models\Product::where('view_section','NEW_ARRIVAL')->get();
                                @endphp
                                @foreach($products->chunk(3) as $product)
                                <div>
                                    @foreach($product as $productItem)
                                    <div class="media-banner media-banner-1 border-0">
                                        <div class="media-banner-box">
                                            <div class="media">
                                                <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                                    <img src="{{ asset($productItem->photo) }}" style="width: 90px; height: 100px;" class="img-fluid " alt="banner">
                                                </a>
                                                <div class="media-body">
                                                    <div class="media-contant">
                                                        <div>
                                                            <div class="product-detail">
                                                                <a href="{{ route('productDetailsSlug',$productItem->slug) }}"><p>{{ substr(\App\Models\Settings::unicodeName($productItem->name),0,25) }}</p></a>
                                                                Category: <a href="{{ route('categoryDetailsSlug',$productItem->category->slug) }}">{{ substr(\App\Models\Settings::unicodeName($productItem->category->name),0,18) }}</a>
                                                                <h6>Tk {{ $productItem->sale_price }} <span>Tk {{ $productItem->sale_price + $productItem->discount_amount }}</span></h6>
                                                            </div>
                                                            <div class="cart-info">
                                                                <button class="tooltip-top btn-cart" data-tippy-content="Add to cart"
                                                                        cus-product-id="{{ $productItem->id }}"
                                                                        cus-product-name="{{ ucwords($productItem->name) }}"
                                                                        cus-product-slug="{{ route('productDetailsSlug',$productItem->slug) }}"
                                                                        cus-price="{{ $productItem->sale_price }}"
                                                                        cus-discount="{{ $productItem->discount_amount }}"
                                                                        cus-photo="{{ asset($productItem->photo)}}"
                                                                        cus-brand="{{ $productItem->brand->brand_name }}"
                                                                        cus-category="{{ $productItem->category->name }}" >
                                                                    <i data-feather="shopping-cart"></i> Add to cart
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="tab-most_popular" class="tab-content ">
                            <div class="media-slide-5 product-m no-arrow">
                                @php
                                    $products = \App\Models\Product::where('view_section','MOST_POPULAR')->get();
                                @endphp
                                @foreach($products->chunk(3) as $product)
                                    <div>
                                        @foreach($product as $productItem)
                                            <div class="media-banner media-banner-1 border-0">
                                                <div class="media-banner-box">
                                                    <div class="media">
                                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                                            <img src="{{ asset($productItem->photo) }}" style="width: 90px; height: 100px;" class="img-fluid " alt="banner">
                                                        </a>
                                                        <div class="media-body">
                                                            <div class="media-contant">
                                                                <div>
                                                                    <div class="product-detail">
                                                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}"><p>{{ substr(\App\Models\Settings::unicodeName($productItem->name),0,25) }}</p></a>
                                                                        Category: <a href="{{ route('categoryDetailsSlug',$productItem->category->slug) }}">{{ substr(\App\Models\Settings::unicodeName($productItem->category->name),0,18) }}</a>
                                                                        <h6>Tk {{ $productItem->sale_price }} <span>Tk {{ $productItem->sale_price + $productItem->discount_amount }}</span></h6>
                                                                    </div>
                                                                    <div class="cart-info">
                                                                        <button class="tooltip-top btn-cart" data-tippy-content="Add to cart"
                                                                        cus-product-id="{{ $productItem->id }}"
                                                                        cus-product-name="{{ ucwords($productItem->name) }}"
                                                                        cus-product-slug="{{ route('productDetailsSlug',$productItem->slug) }}"
                                                                        cus-price="{{ $productItem->sale_price }}"
                                                                        cus-discount="{{ $productItem->discount_amount }}"
                                                                        cus-photo="{{ asset($productItem->photo)}}"
                                                                        cus-brand="{{ $productItem->brand->brand_name }}"
                                                                        cus-category="{{ $productItem->category->name }}" >
                                                                    <i data-feather="shopping-cart"></i> Add to cart
                                                                </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="tab-best_sellers" class="tab-content ">
                            <div class="media-slide-5 product-m no-arrow">
                                @php
                                    $products = \App\Models\Product::where('view_section','BEST_SELLER')->get();
                                @endphp
                                @foreach($products->chunk(3) as $product)
                                    <div>
                                        @foreach($product as $productItem)
                                            <div class="media-banner media-banner-1 border-0">
                                                <div class="media-banner-box">
                                                    <div class="media">
                                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                                            <img src="{{ asset($productItem->photo) }}" style="width: 90px; height: 100px;" class="img-fluid " alt="banner">
                                                        </a>
                                                        <div class="media-body">
                                                            <div class="media-contant">
                                                                <div>
                                                                    <div class="product-detail">
                                                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}"><p>{{ substr(\App\Models\Settings::unicodeName($productItem->name),0,25) }}</p></a>
                                                                        Category: <a href="{{ route('categoryDetailsSlug',$productItem->category->slug) }}">{{ substr(\App\Models\Settings::unicodeName($productItem->category->name),0,18) }}</a>
                                                                        <h6>Tk {{ $productItem->sale_price }} <span>Tk {{ $productItem->sale_price + $productItem->discount_amount }}</span></h6>
                                                                    </div>
                                                                    <div class="cart-info">
                                                                        <button class="tooltip-top btn-cart" data-tippy-content="Add to cart"
                                                                        cus-product-id="{{ $productItem->id }}"
                                                                        cus-product-name="{{ ucwords($productItem->name) }}"
                                                                        cus-product-slug="{{ route('productDetailsSlug',$productItem->slug) }}"
                                                                        cus-price="{{ $productItem->sale_price }}"
                                                                        cus-discount="{{ $productItem->discount_amount }}"
                                                                        cus-photo="{{ asset($productItem->photo)}}"
                                                                        cus-brand="{{ $productItem->brand->brand_name }}"
                                                                        cus-category="{{ $productItem->category->name }}" >
                                                                    <i data-feather="shopping-cart"></i> Add to cart
                                                                </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="tab-flash_sell" class="tab-content ">
                            <div class="media-slide-5 product-m no-arrow">
                                @php
                                    $products = \App\Models\Product::where('view_section','FLASH_SELL')->get();
                                @endphp
                                @foreach($products->chunk(3) as $product)
                                    <div>
                                        @foreach($product as $productItem)
                                            <div class="media-banner media-banner-1 border-0">
                                                <div class="media-banner-box">
                                                    <div class="media">
                                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}">
                                                            <img src="{{ asset($productItem->photo) }}" style="width: 90px; height: 100px;" class="img-fluid " alt="banner">
                                                        </a>
                                                        <div class="media-body">
                                                            <div class="media-contant">
                                                                <div>
                                                                    <div class="product-detail">
                                                                        <a href="{{ route('productDetailsSlug',$productItem->slug) }}"><p>{{ substr(\App\Models\Settings::unicodeName($productItem->name),0,25) }}</p></a>
                                                                        Category: <a href="{{ route('categoryDetailsSlug',$productItem->category->slug) }}">{{ substr(\App\Models\Settings::unicodeName($productItem->category->name),0,18) }}</a>
                                                                        <h6>Tk {{ $productItem->sale_price }} <span>Tk {{ $productItem->sale_price + $productItem->discount_amount }}</span></h6>
                                                                    </div>
                                                                    <div class="cart-info">
                                                                        <button class="tooltip-top btn-cart" data-tippy-content="Add to cart"
                                                                                cus-product-id="{{ $productItem->id }}"
                                                                                cus-product-name="{{ ucwords($productItem->name) }}"
                                                                                cus-product-slug="{{ route('productDetailsSlug',$productItem->slug) }}"
                                                                                cus-price="{{ $productItem->sale_price }}"
                                                                                cus-discount="{{ $productItem->discount_amount }}"
                                                                                cus-photo="{{ asset($productItem->photo)}}"
                                                                                cus-brand="{{ $productItem->brand->brand_name }}"
                                                                                cus-category="{{ $productItem->category->name }}" >
                                                                            <i data-feather="shopping-cart"></i> Add to cart
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
