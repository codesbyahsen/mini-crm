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
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Confirm password</h5>
                        <div class="nk-block-des">
                            <p>{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="default-01">Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control form-control-lg" id="default-01" name="password"
                                placeholder="Enter your current password">
                        </div>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
