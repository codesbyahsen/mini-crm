@extends('layouts.app')

@section('page-content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-inner card-inner-lg">
                                    <div class="tab-content">
                                        @include('profile.partials.profile-settings')
                                        @include('profile.partials.security-settings')
                                    </div>
                                </div>
                                <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg"
                                    data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                    <div class="card-inner-group" data-simplebar>
                                        <div class="card-inner">
                                            <div class="user-card">
                                                <div class="user-avatar bg-primary">
                                                    @if (auth()->user()->avatar)
                                                        <img class="avatar" src="" alt="user avatar" />
                                                    @else
                                                        <span class="name-initials">{{ getNameInitials() }}</span>
                                                    @endif
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text profile-display-name"></span>
                                                    <span class="sub-text profile-email"></span>
                                                </div>
                                                <div class="user-action">
                                                    <div class="dropdown">
                                                        <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown"
                                                            href="#"><em class="icon ni ni-more-v"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#" id="upload-button-avatar"
                                                                        data-url="{{ route('profile.upload.avatar', $user->id) }}">
                                                                        <em class="icon ni ni-camera-fill"></em><span>Upload
                                                                            Photo</span></a>
                                                                    <input type="file" id="avatarInput"
                                                                        style="display: none;"
                                                                        accept="image/png,image/jpeg,image/gif" />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .user-card -->
                                        </div><!-- .card-inner -->
                                        <div class="card-inner p-0">
                                            <ul class="link-list-menu nav nav-tabs">
                                                <li><a class="active tab-profile-settings" data-toggle="tab" href="#tabProfileSettings"><em
                                                            class="icon ni ni-user-fill-c"></em><span>Personal
                                                            Infomation</span></a></li>
                                                <li><a data-toggle="tab" href="#tabSecuritySettings"><em
                                                            class="icon ni ni-lock-alt-fill"></em><span>Security
                                                            Settings</span></a></li>
                                            </ul>
                                        </div><!-- .card-inner -->
                                    </div><!-- .card-inner-group -->
                                </div><!-- card-aside -->
                            </div><!-- .card-aside-wrap -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" role="dialog" id="edit-profile">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close cancel-edit-profile-modal" data-dismiss="modal"><em
                        class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Update Profile</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal">Personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#address">Address</a>
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <form action="{{ route('profile.update') }}">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name">Full Name</label>
                                            <input type="text" class="form-control form-control-lg field-name"
                                                id="full-name" name="name" value="" placeholder="Enter Full name">
                                            <span class="text-danger small error-name"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="display-name">Display Name</label>
                                            <input type="text" class="form-control form-control-lg field-display-name"
                                                id="display-name" name="display_name" value=""
                                                placeholder="Enter display name">
                                            <span class="text-danger small error-display-name"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="phone-no">Phone Number</label>
                                            <input type="text" class="form-control form-control-lg field-phone"
                                                id="phone-no" name="phone" value="" placeholder="Phone Number">
                                            <span class="text-danger small error-phone"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="gender">Gender</label>
                                            <select class="form-select field-gender" name="gender" id="gender"
                                                data-ui="lg">
                                                <option value="" selected>Select gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <span class="text-danger small error-gender"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="birth-day">Date of Birth</label>
                                            <input type="date" class="form-control form-control-lg field-date-of-birth"
                                                name="date_of_birth" id="birth-day" value=""
                                                placeholder="Enter your date of birth" />
                                            <span class="text-danger small error-date-of-birth"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="display-name-switch">
                                            <label class="custom-control-label" for="display-name-switch">Use full name to
                                                display
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group float-right">
                                            <button type="submit" class="btn btn-lg btn-primary">Update Profile</button>
                                            <button type="reset" data-dismiss="modal"
                                                class="link link-light ml-2 cancel-edit-profile-modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- .tab-pane -->
                        <div class="tab-pane" id="address">
                            <form action="{{ route('profile.update.address') }}" id="edit-profile-address">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="address-l1">Address Line 1</label>
                                            <input type="text"
                                                class="form-control form-control-lg field-address-line-one"
                                                id="address-l1" name="address_line_one" value="">
                                            <span class="text-danger small error-address-line-one"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="address-l2">Address Line 2</label>
                                            <input type="text"
                                                class="form-control form-control-lg field-address-line-two"
                                                id="address-l2" name="address_line_two"
                                                value="{{ old('address_line_two', $user?->address_line_one) }}">
                                            <span class="text-danger small error-address-line-two"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="address-city">City</label>
                                            <input type="text" class="form-control form-control-lg field-city"
                                                id="address-city" name="city" value="{{ old('city', $user?->city) }}">
                                            <span class="text-danger small error-city"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="address-st">State</label>
                                            <input type="text" class="form-control form-control-lg field-state"
                                                id="address-st" name="state"
                                                value="{{ old('statue', $user?->statue) }}">
                                            <span class="text-danger small error-state"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="address-county">Country</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select field-country" id="address-county"
                                                    data-search="on" name="country">
                                                    <option value="" selected>Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->name ?? '' }}">
                                                            {{ $country->name ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger small error-country"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group float-right">
                                            <button type="submit" class="btn btn-lg btn-primary">Update Address</button>
                                            <button type="reset" data-dismiss="modal"
                                                class="link link-light ml-2 cancel-edit-profile-modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
@endsection
