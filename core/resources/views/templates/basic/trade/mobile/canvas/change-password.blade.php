<div class="offcanvas offcanvas-end" tabindex="-1" id="changepassword-canvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header" style="padding: 10px;">
        <h4 class="mb-0 fs-18 offcanvas-title text-white">
            @lang('Change Password')
        </h4>
        <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-times-circle fa-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body pt-2" style="padding: 10px;">
        <form action="/user/change-password" method="post" class="cpass">
            @csrf
            {{-- <div class="form-group">
                <label class="form-label">@lang('Current Password')</label>
                <input type="password" class="form--control" name="current_password" required
                    autocomplete="current-password">
            </div> --}}
            <div class="form-group">
                <label class="form-label">@lang('New Password')</label>
                <input type="password" class="form--control cpass_password @if ($general->secure_password) secure-password @endif"
                    name="password" required onkeyup="validatePasswords()" autocomplete="current-password">
            </div>
            <div class="form-group">
                <label class="form-label">@lang('Confirm New Password')</label>
                <input type="password" class="form-control form--control cpass_password_confirmation" name="password_confirmation" required
                onkeyup="validatePasswords()" autocomplete="current-password">
            </div>
            <p id="error-message" class="error text-danger my-2"></p>
            <button type="submit" class="btn btn--base w-100 cpass-btn">@lang('Submit')</button>
        </form>
       
    </div>
</div>