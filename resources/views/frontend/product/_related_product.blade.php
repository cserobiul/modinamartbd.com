@if(count($related_products) > 0)
<section class="section-big-py-space  ratio_asos b-g-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>related products</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 product">
                    <div class="product-slide-6 product-m no-arrow">
                        @foreach($related_products as $product)
                        <div>
                            <div class="product-box">
                                <div class="product-imgbox">
                                    <div class="product-front">
                                        <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                            <img src="{{ asset($product->photo) }}" class="img-fluid  " alt="product">
                                        </a>
                                    </div>
                                    <div class="product-back">
                                        <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                            <img src="{{ asset($product->photo) }}" class="img-fluid  " alt="product">
                                        </a>
                                    </div>
                                    <div class="product-icon icon-inline">
                                        <button data-bs-toggle="modal" data-bs-target="#addtocart"   class="tooltip-top" data-tippy-content="Add to cart" >
                                            <i  data-feather="shopping-cart"></i>
                                        </button>
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
