@foreach($categories as $category)
    @if($category->show_home == 1)
        <div class="title1 section-my-space">
            <h4>{{ $category->name }}</h4>
        </div>
        <!-- End of Tab -->
        @php
            $cat = array();
            foreach($category->children as $child){
                 array_push($cat, $child->id.',');
                 foreach($child->children as $child2){
                     array_push($cat, $child2->id.',');
                 }
            }
        @endphp


        <section class="product section-pb-space mb--5">
            <div class="custom-container">
                <div class="row">
                    <div class="col pr-0">
                        <div class="product-slide-6 no-arrow">
                            @foreach(\App\Models\Product::whereIn('category_id',$cat)->limit(10)->get() as  $product)
                                <div>
                                    <div class="product-box">
                                        <div class="product-imgbox">
                                            <div class="product-front">
                                                @if(file_exists(public_path($product->photo)))
                                                    <a href="{{ route('productDetailsSlug',$product->slug) }}"> <img src="{{ asset($product->photo) }}" class="img-fluid  customPhoto" alt="product"> </a>
                                                @else
                                                    <a href="{{ route('productDetailsSlug',$product->slug) }}"> <img src="{{ asset('assets/images/no-image.png') }}" class="img-fluid  customPhoto" alt="product"> </a>
                                                @endif
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
                                                            {{ substr(\App\Models\Settings::unicodeName($product->name),0,20) }}
                                                        </h6>
                                                    </a>
                                                    Category: <a
                                                        href="{{ route('categoryDetailsSlug',$product->category->slug) }}"
                                                        title="{{ \App\Models\Settings::unicodeName($product->category->name) }}">
                                                        {{ substr(\App\Models\Settings::unicodeName($product->category->name),0,18) }}</a>
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
                </div>
            </div>
        </section>

    @endif
@endforeach
