<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                        class="icon ni ni-menu"></em></a>
            </div>
            <!-- .nk-header-brand -->
            <div class="nk-header-brand d-xl-none">
                <a href="{{ route('dashboard') }}" class="logo-link">
                    <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x"
                        alt="logo">
                    <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x"
                        alt="logo-dark">
                </a>
            </div>

            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    @if (auth()->user()->avatar)
                                        <img class="avatar" src="" alt="user avatar" />
                                    @else
                                        <span class="name-initials">{{ getNameInitials() }}</span>
                                    @endif
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <div class="user-status">
                                        @if (auth()
                                                ?->user()
                                                ?->roles()
                                                ?->value('name') === 'admin')
                                            Administrator
                                        @elseif (auth()
                                                ?->user()
                                                ?->roles()
                                                ?->value('name') === 'sub-admin')
                                            Sub Admin
                                        @endif
                                    </div>
                                    <div class="user-name dropdown-indicator profile-display-name"></div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
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
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{ route('profile.index') }}"><em
                                                class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    <li><a class="dark-switch" id="dark-mode-button" href="#"><em
                                                class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        @if (auth()->guard('employee')->check())
                                            <form method="POST" action="{{ route('employees.logout') }}">
                                                @csrf
                                                <button type="submit" class="bg-transparent border-0"><em
                                                        class="icon ni ni-signout"></em><span>{{ __('Sign out') }}</span></button>
                                            </form>
                                        @elseif (auth()->guard('company')->check())
                                            <form method="POST" action="{{ route('companies.logout') }}">
                                                @csrf
                                                <button type="submit" class="bg-transparent border-0"><em
                                                        class="icon ni ni-signout"></em><span>{{ __('Sign out') }}</span></button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="bg-transparent border-0"><em
                                                        class="icon ni ni-signout"></em><span>{{ __('Sign out') }}</span></button>
                                            </form>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
