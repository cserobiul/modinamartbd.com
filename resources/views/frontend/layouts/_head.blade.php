<title>{{ $settings->app_name ? $settings->app_name : 'Application'}} :: @yield('title')</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="@yield('meta_description','Apol IT Company')">
<meta name="keywords" content="@yield('meta_keywords','apol, apol ltd, apol shop, apol ecommerce')">
<meta name="author" content="@yield('meta_author','apol')">
<!-- Favicon -->
@if($settings->favicon == null)
    <link rel="icon" type="image/png" href="{{ asset(('frontend/assets/images/icons/favicon.png')) }}">
@else
    <link rel="icon" type="image/png" href="{{ asset($settings->favicon) }}">
@endif

<!--Google font-->
<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

<!--icon css-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/themify.css">


<!--Slick slider css-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/slick.css">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/slick-theme.css">

<!--Animate css-->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/animate.css">
<!-- Bootstrap css -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/bootstrap.css">

<!-- Theme css -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/color1.css" media="screen" id="color">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/site.css">
@yield('mainCss')
