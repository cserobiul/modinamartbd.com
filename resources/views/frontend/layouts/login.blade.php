<div class="login-popup modal" id="signin-modal">
    <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
        <ul class="nav nav-tabs text-uppercase" role="tablist">
            <li class="nav-item">
                <a href="#sign-in" class="nav-link active">Sign In</a>
            </li>
            <li class="nav-item">
                <a href="#sign-up" class="nav-link">Sign Up</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="sign-in">
                <p style="color: red !important;">

                </p>
                @error('email')
                <div class="alert alert-danger print-error-msg">
                    {{ $message }}
                </div>
                @enderror
                @error('username')
                <div class="alert alert-danger print-error-msg">
                    {{ $message }}
                </div>
                @enderror

                <div class="alert alert-success print-success-msg" style="display:none">
                    <strong></strong>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @CSRF
                    <div class="form-group">
                        <label>Email address *</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group mb-0">
                        <label>Password *</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-checkbox d-flex align-items-center justify-content-between">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Your Password?</a>
                        @endif
                    </div>
                    <button type="submit" href="#" class="btn btn-primary">Sign In</button>
                </form>
            </div>

            <div class="tab-pane" id="sign-up">
                <div class="form-group">
                    <label>Your Email address *</label>
                    <input type="text" class="form-control" name="email_1" id="email_1" required>
                </div>
                <div class="form-group mb-5">
                    <label>Password *</label>
                    <input type="text" class="form-control" name="password_1" id="password_1" required>
                </div>
                <p>Your personal data will be used to support your experience
                    throughout this website, to manage access to your account,
                    and for other purposes described in our <a href="#" class="text-primary">privacy policy</a>.</p>
                <a href="#" class="d-block mb-5 text-primary">Signup as a vendor?</a>
                <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                    <input type="checkbox" class="custom-checkbox" id="agree" name="agree" required="">
                    <label for="agree" class="font-size-md">I agree to the <a  href="#" class="text-primary font-size-md">privacy policy</a></label>
                </div>
                <a href="#" class="btn btn-primary">Sign Up</a>
            </div>
        </div>
    </div>
</div>
