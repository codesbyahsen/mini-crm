<div class="tab-pane" id="tabSecuritySettings">
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title">Security Settings</h4>
                <div class="nk-block-des">
                    <p>Set a unique password to protect your account.
                    </p>
                </div>
            </div>
            <div class="nk-block-head-content align-self-start d-lg-none">
                <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em
                        class="icon ni ni-menu-alt-r"></em></a>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="nk-data data-list">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="current_password">Current Password</label>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch lg"
                            data-target="current_password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <input type="password" name="current_password" class="form-control form-control-lg"
                            id="current_password" placeholder="Enter your current password"
                            autocomplete="current-password" />
                    </div>
                    @error('current_password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">New Password</label>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <input type="password" name="password" class="form-control form-control-lg" id="password"
                            placeholder="Enter your new password" autocomplete="new-password" />
                    </div>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch lg"
                            data-target="password_confirmation">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <input type="password" name="password_confirmation" class="form-control form-control-lg"
                            id="password_confirmation" placeholder="Retype your new password"
                            autocomplete="new-password" />
                    </div>
                    @error('password_confirmation')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group float-right">
                    <button type="submit" class="btn btn-lg btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
