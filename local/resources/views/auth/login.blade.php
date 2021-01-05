@include('layouts.backend.header')
@php($banner = \App\Models\Setting::getPageBanner())
@if($banner)
<style>
    .login-area{
        background-image: url('{{asset("images/".$banner)}}') !important;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }
</style>
@endif
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    {!! csrf_field() !!}
                    <div class="login-form-head">
                        <h4>{{ \App\Models\Setting::getName() ? \App\Models\Setting::getName() :config('app.name', 'Laravel') }}</h4>
                        <p>{{ \App\Models\Setting::getSubName() ? \App\Models\Setting::getSubName() :config('app.sub_name', 'Laravel') }}</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="email">Email address</label>
                            <input type="email" id="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            <i class="ti-email"></i>
                            <div class="text-danger">
                                @if ($errors->has('email'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-gp">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            <i class="ti-lock"></i>
                            <div class="text-danger">
                                @if ($errors->has('password'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" name="remember" id="remeber" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remeber">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="submit-btn-area">
                            <button type="submit">Submit <i class="ti-arrow-right"></i></button>
                            <!-- <div class="login-other row mt-4">
                                <div class="col-6">
                                    <a class="fb-login" href="#">Log in with <i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="col-6">
                                    <a class="google-login" href="#">Log in with <i class="fa fa-google"></i></a>
                                </div>
                            </div> -->
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@include('layouts.backend.footer')