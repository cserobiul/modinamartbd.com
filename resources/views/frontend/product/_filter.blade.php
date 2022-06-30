<div class="collection-filter-block creative-card creative-inner category-side">
    <!-- brand filter start -->
    <div class="collection-mobile-back">
        <span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>

    <div class="collection-collapse-block open">
        <h3 class="collapse-block-title mt-0">category</h3>
        <div class="collection-collapse-block-content">
            <div class="collection-brand-filter">
                @foreach($categories as $category)
                <div class="custom-control custom-checkbox  form-check collection-filter-checkbox">
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <label class="custom-control-label form-check-label" style="cursor: default">{{ $category->name }}</label>
                </div>
                    @foreach($category->children as $child)
                    <div class="custom-control custom-checkbox  form-check collection-filter-checkbox">
                        <a href="{{ route('categoryDetailsSlug',$child->slug) }}" style="color:{{ request()->segment(2) == $child->slug ? '#00baa3' : null }}">
                            <label class="custom-control-label form-check-label">&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i> {{ $child->name }}</label>
                        </a>
                    </div>
                        @foreach($child->children as $child2)
                            <div class="custom-control custom-checkbox  form-check collection-filter-checkbox">
                                <a href="{{ route('categoryDetailsSlug',$child2->slug) }}" style="color:{{ request()->segment(2) == $child2->slug ? '#00baa3' : null }}">
                                    <label class="custom-control-label form-check-label">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> {{ $child2->name }}</label>
                                </a>
                            </div>

                        @endforeach

                    @endforeach

                @endforeach
            </div>
        </div>
    </div>

    <div class="collection-collapse-block open pt-5">
        <h3 class="collapse-block-title mt-0">brand</h3>
        <div class="collection-collapse-block-content">
            <div class="collection-brand-filter">
                @foreach(\App\Models\Brand::limit(20)->get() as $brand)
                    <div class="custom-control custom-checkbox  form-check collection-filter-checkbox">
                        <a href="{{ route('brandDetailsSlug',$brand->slug) }}">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <label class="custom-control-label form-check-label" for="zara">{{ ucwords($brand->brand_name) }}</label>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

