@include('layouts.backend.header')
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="login-form-head">
                        <h4>{{ config('app.name', 'Laravel') }}</h4>
                        <p>Reset Your Password and comeback again</p>

                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="email">Email address</label>
                            <input type="email" id="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                            <i class="ti-email"></i>
                            @if ($errors->has('email'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">New Password</label>
                            <input type="password" id="exampleInputPassword1" name="password">
                            <i class="ti-lock"></i>
                            @if ($errors->has('password'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword2">Confirm Password</label>
                            <input type="password" id="exampleInputPassword2" name="password_confirmation">
                            <i class="ti-lock"></i>
                        </div>
                        <div class="submit-btn-area mt-5">
                            <button id="form_submit" type="submit">Reset <i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@include('layouts.backend.footer')