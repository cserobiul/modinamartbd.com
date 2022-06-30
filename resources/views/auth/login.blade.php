@extends('frontend.layouts.master')
@section('title', 'Login Page')
@section('loginPage','active')
@section('mainCss')
<style>
    .loginErrorText{color: red;}
    .login-popup{border: 1px solid #00baa3; }
    .form-control{border: 1px solid #00baa3; }
</style>
@endsection

@section('mainContent')
    <section class="login-page b-g-light">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
                    <div class="theme-card">
                        <h3 class="text-center">Login</h3>
                        @error('email')
                        <p class="mt-3 loginErrorText">{{ $message }}</p>
                        @enderror
                        @error('username')
                        {{ $message }}
                        @enderror
                        @error('password')
                        {{ $message }}
                        @enderror
                        <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @CSRF
                            <div class="form-group">
                                <label >Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label >Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button class="btn btn-normal">Login</button>
                            @if (Route::has('password.request'))
                                <a class="float-end txt-default mt-2" href="{{ route('password.request') }}">Forgot your password?</a>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('mainJs')
@endsection
