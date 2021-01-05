@include('layouts.backend.header')
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                    @csrf
                    <div class="login-form-head">
                        <h4>{{ config('app.name', 'Laravel') }}</h4>
                        <p>Reset Password</p>
                    </div>
                    <div class="login-form-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="form-gp">
                            <label for="email">Email address</label>
                            <input type="email" id="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            <i class="ti-email"></i>
                            <div class="text-danger">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="submit-btn-area mt-5">
                            <button id="form_submit" type="submit">Send Password Reset Link <i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@include('layouts.backend.footer')