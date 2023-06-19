@extends('layouts.guest')
@section('title', 'Registration - Mini-CRM')

@section('page-content')
    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
        <div class="brand-logo pb-4 text-center">
            <a href="html/index.html" class="logo-link">
                <img class="logo-light logo-img logo-img-lg" src="./images/logo.png" srcset="./images/logo2x.png 2x"
                    alt="logo">
                <img class="logo-dark logo-img logo-img-lg" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x"
                    alt="logo-dark">
            </a>
        </div>
        <div class="card card-bordered">
            <div class="card-inner card-inner-lg">
                <ul class="nav nav-tabs mt-n3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabItem1">Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabItem2">Company</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabItem1">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Register as Employee</h4>
                                <div class="nk-block-des">
                                    <p>Create New Mini-CRM Employee Account</p>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ url('register/employee') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="first-name">First Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control field-first-name" id="first-name"
                                        name="first_name" placeholder="Enter your first name"
                                        value="{{ old('first_name') }}" />
                                </div>
                                @error('first_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="last-name">Last Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control field-last-name" id="last-name"
                                        name="last_name" placeholder="Enter your last name"
                                        value="{{ old('last_name') }}" />
                                </div>
                                @error('last_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Your Company <span class="text-muted small">&#40;Employed
                                        at&#41;</span></label>
                                <div class="form-control-wrap">
                                    <select class="form-select field-company" data-search="on" name="company_id">
                                        <option value="" selected>Select company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company?->id }}">{{ $company?->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email-address">Email Address</label>
                                <div class="form-control-wrap">
                                    <input type="email" class="form-control field-email" id="email-address" name="email"
                                        placeholder="Enter your email address" value="{{ old('email') }}" />
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <div class="form-control-wrap">
                                    <a href="#" class="form-icon form-icon-right passcode-switch lg"
                                        data-target="password">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="password" placeholder="Enter your password">
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password-confirmation">Confirm Password</label>
                                <div class="form-control-wrap">
                                    <a href="#" class="form-icon form-icon-right passcode-switch lg"
                                        data-target="password-confirmation">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input type="password" name="password_confirmation" class="form-control form-control-lg"
                                        id="password-confirmation" placeholder="Retype your password">
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <div class="custom-control custom-control-xs custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input" id="checkbox">
                                    <label class="custom-control-label" for="checkbox">I agree to Mini-CRM <a
                                            href="#">Privacy
                                            Policy</a> &amp; <a href="#"> Terms.</a></label>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
                            </div>
                        </form>
                        <div class="form-note-s2 text-center pt-4"> Already have an account? <a
                                href="{{ route('login') }}"><strong>Sign in instead</strong></a>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabItem2">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">Register as Company</h4>
                                <div class="nk-block-des">
                                    <p>Create New Mini-CRM Company Account</p>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ url('register/company') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="name">Company Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" name="name"
                                        id="name" placeholder="Enter your company full name">
                                </div>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg" name="email"
                                        id="email" placeholder="Enter your company email address">
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <div class="form-control-wrap">
                                    <a href="#" class="form-icon form-icon-right passcode-switch lg"
                                        data-target="password">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="password" placeholder="Enter your password">
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password-confirmation">Confirm Password</label>
                                <div class="form-control-wrap">
                                    <a href="#" class="form-icon form-icon-right passcode-switch lg"
                                        data-target="password-confirmation">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input type="password" name="password_confirmation" class="form-control form-control-lg"
                                        id="password-confirmation" placeholder="Retype your password">
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <div class="custom-control custom-control-xs custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input" id="checkbox">
                                    <label class="custom-control-label" for="checkbox">I agree to Mini-CRM <a
                                            href="#">Privacy
                                            Policy</a> &amp; <a href="#"> Terms.</a></label>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
                            </div>
                        </form>
                        <div class="form-note-s2 text-center pt-4"> Already have an account? <a
                                href="{{ route('login') }}"><strong>Sign in instead</strong></a>
                        </div>
                    </div>

                    {{-- <ul class="nav nav-tabs mt-n3">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabItem1">Employee</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabItem2">Company</a>
                        </li>
                    </ul> --}}

                </div>
            </div>

        </div>
    </div>
@endsection
