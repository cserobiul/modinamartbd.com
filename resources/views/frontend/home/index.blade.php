@extends('frontend.layouts.master')
@section('title', 'Home')
@section('homePage','active')
@section('homeBC','show')
@section('bodyClass','home')
@section('mainCss')
    <style>
        .media-banner {padding: 25px !important;}
    </style>
@endsection

@section('mainContent')
    {{--slider start--}}
    @includeIf('frontend.layouts._slider')
    {{--slider end--}}

    {{--parent category start--}}
    @includeIf('frontend.home._categories')
    {{--parent category end--}}

    {{--fashions product start --}}
    @includeIf('frontend.home._home_product_sections')
    {{--fashions product end --}}


    {{--home_full_wide banner start--}}
    @includeIf('frontend.ads._home_full_wide')
    {{--home_full_wide banner end--}}

    {{--featured products tab start--}}
{{--    @includeIf('frontend.home._featured')--}}
    {{--featured products tab end--}}

    {{--home_3col ads banner start--}}
{{--    @includeIf('frontend.ads._home_3col')--}}
    {{--home_3col ads banner end--}}

    {{--special products start--}}
    @includeIf('frontend.home._special')
    {{--special products end--}}






@endsection
