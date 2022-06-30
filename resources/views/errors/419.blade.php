<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ECom Application :: Error 419</title>
    <meta name="description" content="@yield('meta_description','ECom App')">
    <meta name="keywords" content="@yield('meta_keywords','ECom App, apol shop, apol ecommerce')">
    <meta name="author" content="@yield('meta_author','apol')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
<main class="main">
    <div class="error-content text-center" style="background-image: url({{ asset('assets/images/error-bg.jpg') }})">
        <div class="container">
            <a href="{{ route('home') }}">
                <center><img class="logo" src="{{ asset('assets/images/logo.png') }}" width="250"></center>
            </a>
            <h1 class="error-title">Error 419</h1><!-- End .error-title -->
            <p>Session Expired.</p>
            <a href="{{ route('home') }}" class="btn btn-outline-primary-2 btn-minwidth-lg">
                <span>BACK TO HOMEPAGE</span>
                <i class="icon-long-arrow-right"></i>
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary-2 btn-minwidth-lg">
                <span>BACK TO DASHBOARD</span>
                <i class="icon-long-arrow-right"></i>
            </a>

        </div><!-- End .container -->
    </div>
</main>
</div>

</body>
</html>
