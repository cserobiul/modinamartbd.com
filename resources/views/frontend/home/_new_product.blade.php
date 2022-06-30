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
                                        <button class="tooltip-top  add-cartnoty" data-tippy-content="Add to cart"
                                                cus-product-id="{{ $productItem->id }}"
                                                cus-product-name="{{ ucwords($productItem->name) }}"
                                                cus-product-slug="{{ route('productDetailsSlug',$productItem->slug) }}"
                                                cus-price="{{ $productItem->sale_price }}"
                                                cus-discount="{{ $productItem->discount_amount }}"
                                                cus-photo="{{ asset($productItem->photo)}}"
                                                cus-brand="{{ $productItem->brand->brand_name }}"
                                                cus-category="{{ $productItem->category->name }}" >
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
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product tab end -->
