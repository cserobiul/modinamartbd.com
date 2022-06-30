@extends('frontend.layouts.master')
@section('title', 'Brand - '.  \App\Models\Settings::unicodeName($brand->brand_name))
@section('brandPage','active')
@section('mainCss')
    <style>
        .product .product-box .product-imgbox img { border: 1px solid #cdcdcd; }
        .customPhoto{ height: 230px !important;}
    </style>
@endsection

@section('mainContent')
    <section class="section-big-pt-space ratio_asos b-g-light">
        <div class="collection-wrapper">
            <div class="custom-container">
                <div class="row">
                    <div class="col-sm-3 collection-filter category-page-side">
                        <!-- side-bar colleps block stat -->
                    @includeIf('frontend.product._filter')
                    <!-- silde-bar colleps block end here -->

                    </div>

                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="collection-product-wrapper">
                                        <div class="product-top-filter">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="filter-main-btn"><span class="filter-btn  "><i class="fa fa-filter" aria-hidden="true"></i> Filter</span></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product-filter-content">

                                                        <div class="collection-view">
                                                            <ul>
                                                                <li><i class="fa fa-th grid-layout-view"></i></li>
                                                                <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                            </ul>
                                                        </div>
                                                        <div class="collection-grid-view">
                                                            <ul>
                                                                <li><img src="{{ asset('frontend') }}/assets/images/category/icon/2.png" alt="" class="product-2-layout-view"></li>
                                                                <li><img src="{{ asset('frontend') }}/assets/images/category/icon/3.png" alt="" class="product-3-layout-view"></li>
                                                                <li><img src="{{ asset('frontend') }}/assets/images/category/icon/4.png" alt="" class="product-4-layout-view"></li>
                                                                <li><img src="{{ asset('frontend') }}/assets/images/category/icon/6.png" alt="" class="product-6-layout-view"></li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-page-per-view"></div>
                                                        <div class="product-page-filter"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-wrapper-grid product">
                                            @if(count($products) > 0)
                                            <div class="row">
                                                @foreach($products as $product)
                                                    <div class="col-xl-3 col-md-4 col-6  col-grid-box">
                                                        <div class="product-box">
                                                            <div class="product-imgbox">
                                                                <div class="product-front">
                                                                    @if(file_exists(public_path($product->photo)))
                                                                        <a href="{{ route('productDetailsSlug',$product->slug) }}"> <img src="{{ asset($product->photo) }}" class="img-fluid  customPhoto" alt="product"> </a>
                                                                    @else
                                                                        <a href="{{ route('productDetailsSlug',$product->slug) }}"> <img src="{{ asset('assets/images/no-image.png') }}" class="img-fluid  customPhoto" alt="product"> </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="product-detail detail-center detail-inverse">
                                                                <div class="detail-title">
                                                                    <div class="detail-left">
                                                                        <a href="{{ route('productDetailsSlug',$product->slug) }}">
                                                                            <h6 class="price-title"> {{ \App\Models\Settings::unicodeName($product->name) }} </h6>
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
                                                                        <h6>Price: &nbsp;&nbsp;&nbsp;</h6>
                                                                        <div class="check-price">  ৳ {{ $product->sale_price + $product->discount_amount }} </div>
                                                                        <div class="price">  ৳ {{ $product->sale_price }}</div>

                                                                    </div>
                                                                </div>
                                                                <div class="icon-detail">
                                                                    <button class="tooltip-top add-cartnoty btn-cart" data-tippy-content="Add to cart"
                                                                            cus-product-id="{{ $product->id }}"
                                                                            cus-product-name="{{ ucwords($product->name) }}"
                                                                            cus-product-slug="{{ route('productDetailsSlug',$product->slug) }}"
                                                                            cus-price="{{ $product->sale_price }}"
                                                                            cus-discount="{{ $product->discount_amount }}"
                                                                            cus-photo="{{ asset($product->photo)}}"
                                                                            cus-brand="{{ $product->brand->brand_name }}"
                                                                            cus-category="{{ $product->category->name }}" >
                                                                        <i  data-feather="shopping-cart"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @else
                                                <h2 class="text-center">No Products Found!</h2>
                                            @endif
                                        </div>

                                        {{-- pagination --}}
                                        <div class="product-pagination">
                                            <div class="theme-paggination-block">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            {{ $products->links('pagination.shop_page') }}
                                                        </nav>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('mainJs')

@endsection
