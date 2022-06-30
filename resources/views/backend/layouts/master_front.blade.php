<!doctype html>
<html class="no-js " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('backend.layouts._head')
</head>

<body class="theme-blush">

<div class="authentication">
    <div class="container">
        <div class="row">
            @yield('frontContent')
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
@include('backend.layouts._footer_script')
</body>
</html>
