<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ECom Application :: Reset Password</title>
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
        <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('{{ asset('assets/images/login-bg.jpg') }}')">
            <div class="container">
                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a href="{{ route('home') }}">
                                    <center><img class="logo" src="{{ asset('assets/images/logo.png') }}" width="250"></center>
                                </a>
                                <a class="nav-link">Login</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="" role="tabpanel" aria-labelledby="">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address *</label>
                                        <input type="text" class="form-control" id="email" value="{{ old('email',$request->email) }}" name="email" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Confirm Password *</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>Reset Password</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>
