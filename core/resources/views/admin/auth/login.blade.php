@extends('admin.layouts.master')
@section('content')
    <div class="login-main">
        {{-- <div class="login-main" style="background-image: url('{{ asset('assets/admin/images/login.jpg') }}')"> --}}
        <div class="container custom-container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-8 col-sm-11">
                    <div class="login-area">
                        <div class="login-wrapper">
                            <div class="login-wrapper__top">
                                <h3 class="title text-white">@lang('Welcome to') <strong>{{ __($general->site_name) }}</strong>
                                </h3>
                                <p class="text-white">{{ __($pageTitle) }} @lang('to') {{ __($general->site_name) }}
                                    @lang('Dashboard')</p>
                            </div>
                            <div class="login-wrapper__body">
                                <form action="{{ route('admin.login') }}" method="POST"
                                    class="cmn-form mt-30 verify-gcaptcha login-form">
                                    @csrf
                                    <div class="form-group">
                                        <label>@lang('Username')</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="{{ old('username') }}"
                                            name="username" aria-describedby="basic-addon1" required>
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                 

                                    <div class="form-group">
                                        <label>@lang('Password')</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" name="password" aria-describedby="basic-addon2" required>
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-key" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                    <x-captcha />
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" name="remember" type="checkbox" id="remember">
                                            <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn cmn-btn w-100">@lang('LOGIN')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
