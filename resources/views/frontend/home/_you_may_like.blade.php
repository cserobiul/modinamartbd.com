<div class="col-lg-5 col-xl-4 right-sidebar sidebar-fixed">
    <div class="sidebar-overlay">
        <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
    </div>
    <a href="#" class="sidebar-toggle"><i class="fas fa-chevron-left"></i></a>
    <div class="sidebar-content h-100">
        <div class="title-link-wrapper mb-0">
            <h4 class="title title-link">You May Like</h4>
        </div>
        @if(count($JUST_FOR_YOU) > 0)
        <div class="widget widget-products">
            @foreach($JUST_FOR_YOU as $key => $product)
            <div class="product product-widget pt-0">
                <figure class="product-media">
                    <a href="{{ route('productDetailsSlug',$product->slug) }}">
                        <img src="{{ asset($product->photo) }}" alt="Product"
                             width="300" height="338" title="{{ \App\Models\Settings::unicodeName($product->name) }}">
                    </a>
                </figure>
                <div class="product-details">
                    <h4 class="product-name">
                        <a href="{{ route('productDetailsSlug',$product->slug) }}" title="{{ \App\Models\Settings::unicodeName($product->name) }}">{{ \App\Models\Settings::unicodeName($product->name) }}</a>
                    </h4>
                    <div class="product-price">
                        <ins class="new-price">৳ {{ $product->sale_price }}</ins><del
                            class="old-price">৳ {{ $product->sale_price + $product->discount_amount }}</del>
                    </div>
                </div>
            </div>
                @if($key == 2)
                    @break
                @endif
            @endforeach
        </div>
        @endif
    </div>
</div>

