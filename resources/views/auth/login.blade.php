@extends('layouts.guest')
@section('title', 'Login')

@section('page-content')

    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
        <div class="brand-logo pb-4 text-center">
            <a href="javascript:void(0)" class="logo-link">
                <img class="logo-light logo-img logo-img-lg" src="./images/logo.png" srcset="./images/logo2x.png 2x"
                    alt="logo">
                <img class="logo-dark logo-img logo-img-lg" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x"
                    alt="logo-dark">
            </a>
        </div>
        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                @if (Session::has('status'))
                    <div class="my-3">
                        <div class="alert alert-success alert-icon alert-dismissible">
                            <em class="icon ni ni-check-circle"></em> {{ session('status') }} <button class="close"
                                data-dismiss="alert"></button>
                        </div>
                    </div>
                @endif
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">Sign-In</h4>
                        <div class="nk-block-des">
                            <p>{{ __('Access the Mini-CRM panel using your email and password.') }}</p>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="default-01">{{ __('Email') }}</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="email" name="email" class="form-control form-control-lg" id="default-01"
                                placeholder="Enter your email address" />
                        </div>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        @if (Route::has('password.request'))
                            <div class="form-label-group">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <a class="link link-primary link-sm"
                                    href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            </div>
                        @endif
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" name="password" class="form-control form-control-lg" id="password"
                                placeholder="Enter your passcode">
                        </div>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-control-xs custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="remember" id="checkbox">
                            <label class="custom-control-label" for="checkbox">{{ __('Remember me') }}</label>
                        </div>
                    </div>

                </form>
                {{-- <div class="form-note-s2 text-center pt-4"> New on our platform? <a
                            href="{{ route('register') }}">Create an account</a>
                    </div> --}}
            </div>
        </div>
    </div>
@endsection
