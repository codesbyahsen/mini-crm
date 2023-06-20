@extends('layouts.guest')
@section('title', 'Login')

@section('page-content')
    <div class="container nk-block nk-block-middle">
        <div class="brand-logo pb-5">
            <a href="javascript:void(0)" class="logo-link">
                <img class="logo-light logo-img logo-img-lg" src="./images/logo.png" srcset="./images/logo2x.png 2x"
                    alt="logo">
                <img class="logo-dark logo-img logo-img-lg" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x"
                    alt="logo-dark">
            </a>
        </div>
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </h5>

                @if (session('status') == 'verification-link-sent')
                    <h5 class="nk-block-title">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </h5>
                @endif
                <div class="nk-block-des text-success">
                    <p>You can now sign in with your new password</p>
                </div>

                <div class="nk-auth-body">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="form-group">
                            <button type="submit"
                                class="btn btn-lg btn-primary btn-block">{{ __('Resend Verification Email') }}</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-link btn-block">{{ __('Logout') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
