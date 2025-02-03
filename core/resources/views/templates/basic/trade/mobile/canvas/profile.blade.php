    {{-- Canvas --}}
    <div class="offcanvas offcanvas-end p-4" tabindex="-1" id="myprofile-canvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
                @lang('My Profile')
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form class="register py-3" action="" method="post" enctype="multipart/form-data">
                @csrf
                <h5 class="mb-3 text-white">@lang('Update Profile')</h5>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">@lang('First Name')</label>
                            <input type="text" class="form-control form--control" name="firstname"
                                value="{{ $user->firstname ?? '' }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Last Name')</label>
                            <input type="text" class="form-control form--control" name="lastname"
                                value="{{ $user->lastname ?? '' }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">@lang('State')</label>
                            <input type="text" class="form-control form--control" name="state"
                                value="{{ @$user->address->state }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">@lang('City')</label>
                            <input type="text" class="form-control form--control" name="city"
                                value="{{ @$user->address->city }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Zip Code')</label>
                            <input type="text" class="form-control form--control" name="zip"
                                value="{{ @$user->address->zip }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Address')</label>
                            <input type="text" class="form-control form--control" name="address"
                                value="{{ @$user->address->address }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">@lang('Image')</label>
                            <input type="file" class="form-control form--control" name="image">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
            </form>
        </div>
    </div>