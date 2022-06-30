@extends('backend.layouts.master_front')
@section('title', isset($pageTitle) ?  $pageTitle : 'Error 404')
@section('customPluginCSS')
@endsection
<?php
$settings = \App\Models\Settings::where('id',1)->first();
?>
@section('frontContent')
    <div class="col-lg-4 col-sm-12">
        <form class="card auth_form">
            <div class="header">
                @if(!empty($settings->logo))
                    <img class="logo" src="{{ asset($settings->logo)  }}" alt="Apol App Logo">
                @else
                    <img class="logo" src="{{ asset('assets/images/logo.svg') }}" alt="Apol App Logo">
                @endif
                <h5>Error 404</h5>
                <span>Page not found</span>
            </div>
            <div class="body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search...">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-search"></i></span>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-block waves-effect waves-light">GO TO HOMEPAGE</a>
                <div class="signin_with mt-3">
                    @if(!empty($settings->phone))
                        <a href="tel:{{ $settings->phone }}" class="link">Need Help?</a>
                    @else
                        <a href="tel:01644394107" class="link">Need Help?</a>
                    @endif

                </div>
            </div>
        </form>
        <div class="copyright text-center">
            @include('backend.layouts._copyright')
        </div>
    </div>
    <div class="col-lg-8 col-sm-12">
        <div class="card">
            <img src="{{ asset('assets/images/404.svg') }}" alt="404" />
        </div>
    </div>
@endsection

@section('customPluginJS')
@endsection
@section('customJS')
@endsection
