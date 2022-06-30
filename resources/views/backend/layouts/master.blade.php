<!doctype html>
<html class="no-js " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('backend.layouts._head')
</head>

<body class="theme-blush font-montserrat">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ asset('assets/images/loader.svg') }}" width="48" height="48" alt="Apol Shop"></div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Main Search -->
@include('backend.layouts._search')

<!-- Right Icon menu Sidebar -->
{{--@include('backend.layouts._right_icon_menu')--}}

<!-- Left Sidebar -->
@include('backend.layouts._left_sidebar')

<!-- Right Sidebar -->

<!-- Main Content -->
<section class="content">
    @yield('mainContent')
</section>
<!-- Jquery Core Js -->
@include('backend.layouts._footer_script')
</body>
</html>
