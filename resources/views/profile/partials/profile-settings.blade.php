<div class="tab-pane active" id="tabProfileSettings">
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title">Personal Information</h4>
                <div class="nk-block-des">
                    <p>Basic info, like your name and address.
                    </p>
                </div>
            </div>
            <div class="nk-block-head-content align-self-start d-lg-none">
                <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em
                        class="icon ni ni-menu-alt-r"></em></a>
            </div>
        </div>
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div id="user-profile" class="nk-data data-list" data-url="{{ route('profile.edit') }}">
            <div class="data-head">
                <h6 class="overline-title">Basics</h6>
            </div>
            <div class="data-item" data-toggle="modal" data-target="#edit-profile">
                <div class="data-col">
                    <span class="data-label">Full Name</span>
                    <span class="data-value profile-name"></span>
                </div>
                <div class="data-col data-col-end"><span class="data-more"><em
                            class="icon ni ni-forward-ios"></em></span></div>
            </div><!-- data-item -->
            <div class="data-item" data-toggle="modal" data-target="#edit-profile">
                <div class="data-col">
                    <span class="data-label">Display Name</span>
                    <span class="data-value profile-display-name"></span>
                </div>
                <div class="data-col data-col-end"><span class="data-more"><em
                            class="icon ni ni-forward-ios"></em></span></div>
            </div><!-- data-item -->
            <div class="data-item">
                <div class="data-col">
                    <span class="data-label">Email</span>
                    <span class="data-value text-soft profile-email"></span>
                </div>
                <div class="data-col data-col-end"><span class="data-more disable"><em
                            class="icon ni ni-lock-alt"></em></span></div>
            </div><!-- data-item -->
            <div class="data-item" data-toggle="modal" data-target="#edit-profile">
                <div class="data-col">
                    <span class="data-label">Phone Number</span>
                    <span class="data-value profile-phone"></span>
                </div>
                <div class="data-col data-col-end"><span class="data-more"><em
                            class="icon ni ni-forward-ios"></em></span></div>
            </div><!-- data-item -->
            @auth('company')
                <div class="data-item" data-toggle="modal" data-target="#edit-profile">
                    <div class="data-col">
                        <span class="data-label">Founded In</span>
                        <span class="data-value profile-founded-in"></span>
                    </div>
                    <div class="data-col data-col-end"><span class="data-more"><em
                                class="icon ni ni-forward-ios"></em></span></div>
                </div><!-- data-item -->
                <div class="data-item" data-toggle="modal" data-target="#edit-profile">
                    <div class="data-col">
                        <span class="data-label">Website</span>
                        <span class="data-value profile-website"></span>
                    </div>
                    <div class="data-col data-col-end"><span class="data-more"><em
                                class="icon ni ni-forward-ios"></em></span></div>
                </div><!-- data-item -->
            @else
                <div class="data-item" data-toggle="modal" data-target="#edit-profile">
                    <div class="data-col">
                        <span class="data-label">Date of Birth</span>
                        <span class="data-value profile-date-of-birth"></span>
                    </div>
                    <div class="data-col data-col-end"><span class="data-more"><em
                                class="icon ni ni-forward-ios"></em></span></div>
                </div><!-- data-item -->
                <div class="data-item" data-toggle="modal" data-target="#edit-profile">
                    <div class="data-col">
                        <span class="data-label">Gender</span>
                        <span class="data-value profile-gender"></span>
                    </div>
                    <div class="data-col data-col-end"><span class="data-more"><em
                                class="icon ni ni-forward-ios"></em></span></div>
                </div><!-- data-item -->
            @endauth
            <div class="data-item" data-toggle="modal" data-target="#edit-profile" data-tab-target="#address">
                <div class="data-col">
                    <span class="data-label">Address</span>
                    <span class="data-value profile-address"></span>
                </div>
                <div class="data-col data-col-end"><span class="data-more"><em
                            class="icon ni ni-forward-ios"></em></span></div>
            </div><!-- data-item -->
        </div>
    </div><!-- .nk-block -->
</div>
