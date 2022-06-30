@extends('frontend.layouts.master')
@section('title', 'Forgot Password')
@section('forgotPage','active')
@section('mainCss')
    <style>
        .errorText{color: red;}
        .successText{color: green;}
    </style>
@endsection

@section('mainContent')
    <section class="login-page pwd-page b-g-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="theme-card">
                        <h3>Forget Your Password</h3>
                        <form class="theme-form" method="POST" {{ route('password.email') }}>
                            @csrf
                            <div class="row">
                                <p class="mt-3 mb-2">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                                <div class="col-md-12 mt-3">
                                    @if (session('status'))
                                        <p class="successText pb-3">{{ session('status') }}</p>
                                    @endif
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="e.g.: info@zariq.com.bd"  required autofocus>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-normal">Email Password Reset Link</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('mainJs')
@endsection
