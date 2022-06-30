@extends('frontend.layouts.master')
@section('title', 'Categories Page')
@section('categoryPage','active')
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
                                            <div class="row">
                                                @foreach($categories as $category)
                                                    <div class="col-xl-3 col-md-4 col-6  col-grid-box">
                                                        <div class="product-box">
                                                            <div class="product-imgbox">
                                                                <div class="product-front">
                                                                    @if(file_exists(public_path($category->photo)))
                                                                        <a href="{{ route('categoryDetailsSlug',$category->slug) }}"> <img src="{{ asset($category->photo) }}" class="img-fluid  customPhoto" alt="product"> </a>
                                                                    @else
                                                                        <a href="{{ route('categoryDetailsSlug',$category->slug) }}"> <img src="{{ asset('assets/images/no-image.png') }}" class="img-fluid  customPhoto" alt="product"> </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="product-detail detail-center">
                                                                <div class="detail-title">
                                                                    <div class="detail-left">
                                                                        <a href="{{ route('categoryDetailsSlug',$category->slug) }}">
                                                                            <h6 class="price-title"> {{ \App\Models\Settings::unicodeName($category->name) }} </h6>
                                                                        </a>
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
