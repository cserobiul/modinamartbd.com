<!DOCTYPE html>
<html lang="en">
<head>
@includeIf('frontend.layouts._head')
</head>
<body class="bg-light">

<!-- loader start -->
<div class="loader-wrapper">
    <div>
        <img src="{{ asset('assets/images/loader.gif') }}" alt="loader">
    </div>
</div>
<!-- loader end -->

<!--header start-->
@includeIf('frontend.layouts._header')
<!--header end-->

@yield('mainContent')

<!-- footer start -->
@includeIf('frontend.layouts._footer')
<!-- footer end -->

@includeIf('frontend.layouts._newsletter')
@includeIf('frontend.layouts._footer_script')


</body>
</html>
