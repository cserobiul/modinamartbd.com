<!--tab product-->
<section class="section-pt-space">
    <div class="tab-product-main">
        <div class="tab-prodcut-contain">
            <ul class="tabs tab-title">

                @foreach($categories = \App\Models\Category::where('parent_id',1)->limit(7)->get() as $key => $category)
                    <li class="{{ $key+1 == 1 ? 'current':'' }}"><a
                            href="tab-{{ $category->slug }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
<!--tab product-->

<!-- slider tab  -->
<section class="section-py-space ratio_square product">
    <div class="custom-container">
        <div class="row">
            <div class="col pr-0">
                <div class="theme-tab product mb--5">
                    <div class="tab-content-cls ">

                        @foreach($categories as $key => $category)

                            @php
                                $cat = array($category->id);
                                foreach(\App\Models\Category::where('parent_id',$category->id)->get() as $child){
                                   array_push($cat, $child->id.',');
                                }
                            @endphp

                            <div id="tab-{{ $category->slug }}"
                                 class="tab-content {{ $key+1 == 1 ? 'active default' : '' }}">
                                <div class="product-slide-6 product-m no-arrow">
                                    @foreach(\App\Models\Product::whereIn('category_id',$cat)->limit(6)->get() as  $product)
                                        <div>
                                            <div class="product-box">
                                                <div class="product-imgbox">
                                                    <div class="product-front">
                                                        <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                            <img src="{{ asset($product->photo) }}" class="img-fluid  "
                                                                 alt="product">
                                                        </a>
                                                    </div>
                                                    <div class="product-back">
                                                        <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                            <img src="{{ asset($product->photo) }}" class="img-fluid  "
                                                                 alt="product">
                                                        </a>
                                                    </div>
                                                    <div class="product-icon icon-inline">
                                                        <button class="tooltip-top btn-cart" data-tippy-content="Add to cart"
                                                                cus-product-id="{{ $product->id }}"
                                                                cus-product-name="{{ ucwords($product->name) }}"
                                                                cus-product-slug="{{ route('productDetailsSlug',$product->slug) }}"
                                                                cus-price="{{ $product->sale_price }}"
                                                                cus-discount="{{ $product->discount_amount }}"
                                                                cus-photo="{{ asset($product->photo)}}"
                                                                cus-brand="{{ $product->brand->brand_name }}"
                                                                cus-category="{{ $product->category->name }}" >
                                                            <i data-feather="shopping-cart"></i>
                                                        </button>
                                                    </div>
                                                    <div class="new-label1">
                                                        <div>new</div>
                                                    </div>
                                                    <div class="on-sale1">
                                                        Sale
                                                    </div>
                                                </div>
                                                <div class="product-detail detail-inline ">
                                                    <div class="detail-title">
                                                        <div class="detail-left">
                                                            <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                <h6 class="price-title"
                                                                    title="{{ \App\Models\Settings::unicodeName($product->name) }}">
                                                                    {{ substr(\App\Models\Settings::unicodeName($product->name),0,25) }}
                                                                </h6>
                                                            </a>
                                                            <h6 class="pt-1">Category:
                                                                <a
                                                                    href="{{ route('categoryDetailsSlug',$product->category->slug) }}"
                                                                    title="{{ \App\Models\Settings::unicodeName($product->category->name) }}">
                                                                    {{ substr(\App\Models\Settings::unicodeName($product->category->name),0,18) }}</a>
                                                            </h6>

                                                            <h6 class="pt-1">Brand:
                                                                <a
                                                                    href="{{ route('categoryDetailsSlug',$product->brand->slug) }}"
                                                                    title="{{ \App\Models\Settings::unicodeName($product->brand->brand_name) }}">
                                                                    {{ substr(\App\Models\Settings::unicodeName($product->brand->brand_name),0,18) }}</a>
                                                            </h6>

                                                        </div>
                                                        <div class="detail-right">
                                                            <div class="check-price">
                                                                Tk {{ $product->sale_price + $product->discount_amount }}
                                                            </div>
                                                            <div class="price">
                                                                <div class="price">
                                                                    Tk {{ $product->sale_price }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- slider tab end -->

