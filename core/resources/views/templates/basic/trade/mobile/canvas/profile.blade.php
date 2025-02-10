    {{-- Canvas --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="myprofile-canvas" aria-labelledby="offcanvasLabel" style="padding: 10px;">
        <div class="offcanvas-header p-0">
            <h5 class="mb-0 offcanvas-title text-white">
                @lang('Update Profile')
            </h5>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body p-0">
            <form class="pb-3" action="" method="post" enctype="multipart/form-data">
                @csrf
                {{-- <h5 class="mb-3 text-white">@lang('Update Profile')</h5> --}}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group"></div>
                        <div class="form-group mb-2">
                            <label class="">@lang('First Name')</label>
                            <div class="input-group">
                                <input type="text" class="form-control form--control text-themed" name="firstname"
                                    value="{{ $user->firstname ?? '' }}" required style="border: 1px solid #7c666675">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="">@lang('Last Name')</label>
                            <div class="input-group">
                                <input type="text" class="form-control form--control text-themed" name="lastname"
                                    value="{{ $user->lastname ?? '' }}" required style="border: 1px solid #7c666675">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="">@lang('State')</label>
                            <div class="input-group">
                                <input type="text" class="form-control form--control text-themed" name="state"
                                    value="{{ @$user->address->state }}" style="border: 1px solid #7c666675">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="">@lang('City')</label>
                            <div class="input-group">
                                <input type="text" class="form-control form--control text-themed" name="city"
                                    value="{{ @$user->address->city }}" style="border: 1px solid #7c666675">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="">@lang('Zip Code')</label>
                            <div class="input-group">
                                <input type="text" class="form-control form--control text-themed" name="zip"
                                    value="{{ @$user->address->zip }}" style="border: 1px solid #7c666675">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="">@lang('Address')</label>
                            <div class="input-group">
                                <input type="text" class="form-control form--control text-themed" name="address"
                                    value="{{ @$user->address->address }}" style="border: 1px solid #7c666675">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="">@lang('Image')</label>
                            <div class="input-group">
                                <input type="file" class="form-control form--control text-themed" name="image" 
                                    style="border: 1px solid #7c666675">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
            </form>
        </div>
    </div>