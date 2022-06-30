<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="@yield('meta_description','Apol IT Company')">
<meta name="keywords" content="@yield('meta_keywords','apol, apol ltd, apol shop, apol ecommerce')">
<meta name="author" content="@yield('meta_author','apol')">
<meta name="robots" content="all">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') :: {{ isset($settings->app_name) ? $settings->app_name: 'Apol Shop' }}</title>
<!-- Favicon-->
@if(!empty($settings->favicon))
<link rel="icon" href="{{ asset($settings->favicon) }}" type="image/x-icon">
@else
<link rel="icon" href="{{ asset('assets/images/loader.svg') }}" type="image/x-icon">
@endif
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
@yield('customPluginCSS')
<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">

