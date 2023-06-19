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
                        <h5 class="nk-block-title">Reset password</h5>
                        <div class="nk-block-des">
                            <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="default-01">{{ __('Email') }}</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="email" name="email" class="form-control form-control-lg" id="default-01"
                                placeholder="Enter your email address" value="{{ old('email') }}" />
                        </div>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Send Reset Link</button>
                    </div>
                </form>
                <div class="form-note-s2 text-center pt-4">
                    <a href="{{ route('login') }}"><strong>Return to login</strong></a>
                </div>
            </div>
        </div>
    </div>
@endsection
