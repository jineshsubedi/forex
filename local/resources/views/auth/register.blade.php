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

    <!-- login area start -->
    <div class="login-area login-bg" style="background: url('{{asset('backend/assets/images/bg/singin-bg.jpg')}}') center/cover no-repeat; position: relative;z-index: 1;">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-xl-4 offset-xl-8 col-lg-6 offset-lg-6">
                    <div class="login-box-s2 ptb--100">
                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf
                            <div class="login-form-head">
                                <h4>Sign up</h4>
                                <p>Hello there, Sign up and Join with Us</p>
                            </div>
                            <div class="login-form-body">
                                <div class="form-gp">
                                    <label for="name">Full Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                    <i class="ti-user"></i>
                                    <div class="text-danger">
                                        @if ($errors->has('name'))
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-gp">
                                    <label for="email">Email address</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
                                    <label for="exampleInputPassword1">Password</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    <i class="ti-lock"></i>
                                    <div class="text-danger">
                                        @if ($errors->has('password'))
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-gp">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    <i class="ti-lock"></i>
                                    <div class="text-danger"></div>
                                </div>
                                <div class="submit-btn-area">
                                    <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                                    <!-- <div class="login-other row mt-4">
                                        <div class="col-6">
                                            <a class="fb-login" href="#">Sign up with <i class="fa fa-facebook"></i></a>
                                        </div>
                                        <div class="col-6">
                                            <a class="google-login" href="#">Sign up with <i class="fa fa-google"></i></a>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="form-footer text-center mt-5">
                                    <p class="text-muted">Have an account? <a href="{{route('login')}}">Sign in</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->
@include('layouts.backend.footer')