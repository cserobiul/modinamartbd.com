<div class="dropdown category-dropdown @yield('homeBC') has-border" data-visible="true">
    <a href="#" class="category-toggle" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="true" data-display="static"
       title="Browse Categories">
        <i class="w-icon-category"></i>
        <span>Browse Categories</span>
    </a>

    <div class="dropdown-box">
        <ul class="menu vertical-menu category-menu">
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('categoryDetailsSlug',$category->slug) }}" style="font-size: 15px !important;">
                        @if($category->photo !=null)
                            <img src="{{ asset($category->photo) }}" class="bcImg">
                        @else
                            <img src="{{ asset('assets/images/category/default-category-img.png') }}" class="bcImg">
                        @endif
                        {{ \App\Models\Settings::unicodeName($category->name) }}
                    </a>

                    <ul class="megamenu">
                        @foreach($category->children as $child)
                            <li>
                                <h4 class="menu-title"> {{ \App\Models\Settings::unicodeName($child->name) }}</h4>
                                <hr class="divider">
                                <ul>
                                    @foreach($child->children as $child2)
                                        <li>
                                            <a href="{{ route('categoryDetailsSlug',$child2->slug) }}">
                                                {{ \App\Models\Settings::unicodeName($child2->name) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                            <li>
                                <div class="banner-fixed menu-banner menu-banner2">
                                    <figure>
                                        <img src="{{ asset($category->photo) }}" alt="Menu Banner"
                                             width="235" height="347"/>
                                    </figure>
                                    <div class="banner-content">
{{--                                        <div class="banner-price-info mb-1 ls-normal">Get up to--}}
{{--                                            <strong--}}
{{--                                                class="text-primary text-uppercase">20%Off</strong>--}}
{{--                                        </div>--}}
{{--                                        <h3 class="banner-title ls-normal">Hot Sales</h3>--}}
{{--                                        <a href="{{ route('shopPage') }}"--}}
{{--                                           class="btn btn-dark btn-sm btn-link btn-slide-right btn-icon-right">--}}
{{--                                            Shop Now<i class="w-icon-long-arrow-right"></i>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                            </li>
                    </ul>

                </li>
            @endforeach

            <li>
                <a href="{{ route('categoryPage') }}"
                   class="font-weight-bold text-primary text-uppercase ls-25">
                    View All Categories<i class="w-icon-angle-right"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
