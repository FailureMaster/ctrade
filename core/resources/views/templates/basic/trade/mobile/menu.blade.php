@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <div class="summary-container">
        <div class="d-flex justify-content-between" id="menuHeaderContainer">
            <h2 class="h-title p-0 mb-0 border-0">{{ __(gs()->site_name) }}</h2>
            @if (Auth::check())
                <span class="text-white">
                    <i class="fas fa-user me-2"></i> {{ __(auth()->user()->fullname) }} &nbsp;
                    {{ auth()->user()->lead_code ?? auth()->user()->id }}
                </span>
            @endif
        </div>
        <ul class="list-unstyled menu-list">
            @if (Auth::check())
                <li class="menu-item text-white @if (App::getLocale() == 'ar') justify-content-end @endif">
                    {{-- <a href="{{ route('user.profile.setting') }}" class="text-white"> --}}
                    <a href="#"
                        class="text-white @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif">
                        <i class="fas fa-university"></i>
                        <span>{{ ( $userGroup != null ? ( ucwords($userGroup->name).' '.__('Account') ) : __('Standard Account') ) }}</span>
                    </a>
                </li>
            @endif

            @if (Auth::check())
                <li class="menu-item text-white @if (App::getLocale() == 'ar') justify-content-end @endif">
                    {{-- <a href="{{ route('user.profile.setting') }}" class="text-white"> --}}
                    <a href="#"
                        class="text-white myprofile-btn @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif">
                        <i class="fas fa-undo-alt"></i>
                        <span>@lang('My Profile')</span>
                    </a>
                </li>
            @endif

            @if (Auth::check())
                <li class="menu-item @if (App::getLocale() == 'ar') justify-content-end @endif">
                    <!-- <a href="{{ route('user.home') }}?d=1" class="text-white "> -->
                    <a class="text-white new--deposit @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif"
                        data-currency="{{ @$pair->market->currency->symbol }}">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>@lang('Deposit')</span>
                    </a>
                </li>
            @endif

            @if (Auth::check())
                <li class="menu-item @if (App::getLocale() == 'ar') justify-content-end @endif">
                    <a class="text-white new--withdraw @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif">
                        <i class="fas fa-wallet"></i>
                        <span>@lang('Withdraw')</span>
                    </a>
                </li>
            @endif

            @if (Auth::check())
            @php
                $kycStatusClass = "text-danger";
                $kycStatus      = "Unverified";
                if( auth()->user()->kv === 1 ){
                    $kycStatus =  "Verified";
                    $kycStatusClass = "text-success";
                } 
                if( auth()->user()->kv === 2 ){
                    $kycStatusClass = "text-warning";
                    $kycStatus =  "Pending";
                } 
            @endphp
                <li class="menu-item @if (App::getLocale() == 'ar') justify-content-end @endif">
                    <a class="text-white {{ auth()->user()->kv != 1 ? "new--kyc" : "" }} @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif">
                        <i class="fas fa-id-card"></i>
                        <label class="{{ $kycStatusClass }}">@lang('KYC') {{ __($kycStatus) }}</label>
                    </a>
                </li>
            @endif

        
            @if (Auth::check())
                <li class="menu-item @if (App::getLocale() == 'ar') justify-content-end @endif">
                    {{-- <a href="{{ route('user.change.password') }}" class="text-white"> --}}
                    <a href="#"
                        class="text-white changepass-btn @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif">
                        <i class="fas fa-key"></i>
                        <span>@lang('Change Password')</span>
                    </a>
                </li>
            @endif



            @php
                $langDetails = $languages->where('code', config('app.locale'))->first();
            @endphp

            <li class="menu-item @if (App::getLocale() == 'ar') justify-content-end @endif">
                <div class="custom--dropdown lang-dropdown">
                    <div
                        class="custom--dropdown__selected dropdown-list__item lang-dropdown-list @if (App::getLocale() == 'ar') d-flex flex-row-reverse text-end px-0 @endif">
                        <span>@lang('Language') @if (App::getLocale() != 'ar')
                                :
                            @endif </span>
                        <div class="d-flex  @if (App::getLocale() != 'ar') flex-row-reverse @endif">
                            <div class="thumb">
                                <img
                                    src="{{ getImage(getFilePath('language') . '/' . @$langDetails->flag, getFileSize('language')) }}">
                            </div>
                            <span class="text-uppercase a-label">{{ __(@$langDetails->code) }}</span>
                        </div>
                    </div>
                    <ul class="dropdown-list">
                        @foreach ($languages as $language)
                            <li class="dropdown-list__item change-lang @if (App::getLocale() == 'ar') d-flex flex-row-reverse text-end @endif"
                                data-code="{{ @$language->code }}">
                                <div class="thumb">
                                    <img
                                        src="{{ getImage(getFilePath('language') . '/' . @$language->flag, getFileSize('language')) }}">
                                </div>
                                <span class="text text-uppercase">{{ __(@$language->code) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="@if (App::getLocale() == 'ar') d-flex justify-content-end @endif"
                style="margin-bottom: 15px">
                <div class="theme-switch-wrapper">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" class="d-none" id="checkbox">
                        <span class="slider">
                            <i class="las la-sun m-0"></i>
                        </span>
                    </label>
                </div>
            </li>
            @if (Auth::check())
                <li class="menu-item @if (App::getLocale() == 'ar') justify-content-end @endif">
                    <a href="{{ route('user.logout') }}"
                        class="text-white @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif">
                        <i class="far fa-user-circle"></i>
                        <span>@lang('Logout')</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    {{-- Menu --}}
    @include($activeTemplate . 'partials.mobile.menu')

    {{-- My Profile Canvas --}}
    @include($activeTemplate . 'trade.mobile.canvas.profile')

    {{-- Deposit Canvas --}}
    @include($activeTemplate . 'trade.mobile.canvas.deposit')

    {{-- Withdraw Canvas --}}
    @include($activeTemplate . 'trade.mobile.canvas.withdraw')

    {{-- KYC --}}
    @include($activeTemplate . 'trade.mobile.canvas.kyc')

    {{-- Change Password --}}
    @include($activeTemplate . 'trade.mobile.canvas.change-password')
@endsection
@push('style')
    @if (App::getLocale() == 'ar')
        <style>
            .menu-item i {
                margin-right: 0;
                margin-left: .5rem;
            }

            .portfolio-item {
                flex-flow: row-reverse;
            }

            .summary-container .h-title {
                text-align: right;
            }

            #deposit-confirmation-canvas .offcanvas-body,
            #deposit-confirmation-canvas .offcanvas-body form input, 
            #deposit-confirmation-canvas .offcanvas-body form select,
            #frmWithdrawMoney input, 
            #frmWithdrawMoney, select,
            #frmWithdrawMoney label,
            #withdraw-confirmation-canvas .offcanvas-body h5, 
            #withdraw-confirmation-canvas .offcanvas-body form,
            #withdraw-confirmation-canvas .offcanvas-body form input,
            #deposit-canvas .offcanvas-body #depositFrm div, 
            .register,
            .register input,
            .cpass,
            .cpass input {
                text-align: right !important;
            }
        </style>
    @endif
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        "use strict";

        $('.myprofile-btn').on('click', function(e) {
            var myOffcanvas = document.getElementById('myprofile-canvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });

        $(document).on('submit', '.register', function(e) {
            e.preventDefault();

            let frm = new FormData($('.register')[0]);

            $.ajax({
                method: 'POST',
                data: frm,
                processData: false,
                contentType: false,
                url: "{{ route('user.update.profile') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    notify(response.success, response.message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {

                    if (XMLHttpRequest.status == 422) {

                        var errors = XMLHttpRequest.responseJSON.errors;

                        $.each(errors, function(i, e) {
                            $('[name="' + i + '"]').parent().find('span.error').html(`*${e}`);
                            notify('error', e);
                        });
                    }
                },
                complete: function(response) {}
            });
        });
     
        // Deposit script
        $('.new--deposit').on('click', function(e) {
            @auth
                let currency = $(this).data('currency');
                let gateways = @json($gateways);
                let currencyGateways = gateways.filter(ele => ele.currency == currency);
    
                if (currencyGateways) {
        
                    $("#deposit-canvas").find('.deposit-currency-symbol').val(currency);

                    $("#deposit-canvas").find(".empty-gateway").addClass('d-none');
                    $("#deposit-canvas").find("form").removeClass('d-none');
                } else {
                    $("#deposit-canvas").find(".empty-gateway").removeClass('d-none');
                    $("#deposit-canvas").find("form").addClass('d-none');
                }
                $("#deposit-canvas").find('.deposit-currency-symbol').text(currency);
            @endauth

            var myOffcanvas = document.getElementById('deposit-canvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });

        $(document).on('submit', '#depositFrm', function(e) {
            e.preventDefault();

            let frm = $(this).serialize();

            $.ajax({
                method: 'POST',
                data: frm,
                dataType: 'json',
                url: "{{ route('user.deposit.newInsert') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    if( response.success == 1 ){
                        $('#deposit-confirmation-canvas .offcanvas-body').html(response.html);
                        var myOffcanvas = document.getElementById('deposit-confirmation-canvas');
                        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
                    }
                    else
                        notify('error', response.message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                },
                complete: function(response) {}
            });
        });

        $(document).on('submit', '#customDepositConfirmForm', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                method: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false, 
                processData: false,
                url: "{{ route('user.deposit.new.manual.update') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    if( response.success == 1 ){
                        notify('success', response.message);
                        $('.text-reset').trigger('click');
                    }
                    else
                        notify('error', response.message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (XMLHttpRequest.status == 422) {
                        var errors = XMLHttpRequest.responseJSON.errors;

                        $.each(errors, function(i, e) {
                            notify('error', e);
                        });
                    }
                },
                complete: function(response) {}
            });
        });

        // Withdraw script
        $('.new--withdraw').on('click', function(e) {
            var myOffcanvas = document.getElementById('withdraw-offcanvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });
        
        $(document).on('submit', '#frmWithdrawMoney', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                method: 'POST',
                data: formData,
                dataType: 'json',
                url: "{{ route('user.withdraw.new-money') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    if( response.success == 1 ){
                        $('#withdraw-confirmation-canvas .offcanvas-body').html( response.html );
                        var myOffcanvas = document.getElementById('withdraw-confirmation-canvas');
                        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
                    }
                    else
                        notify('error', response.message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (XMLHttpRequest.status == 422) {
                        var errors = XMLHttpRequest.responseJSON.errors;

                        $.each(errors, function(i, e) {
                            notify('error', e);
                        });
                    }
                    else
                        notify('error', response.message);
                },
                complete: function(response) {}
            });
        });

        $(document).on('submit', '#frmConfirmWithdraw', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                method: 'POST',
                data: formData,
                dataType: 'json',
                url: "{{ route('user.withdraw.new-submit') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    if( response.success == 1 ){
                        $('#frmWithdrawMoney')[0].reset();
                        $('#withdraw-offcanvas .preview-details').addClass('d-none');
                        // notify('success', response.message);
                        $('.text-reset').trigger('click');
                        $('#tblPendingWithdraw').html( response.html );
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                        
                        setTimeout(() => {
                            var myOffcanvas = document.getElementById('withdraw-offcanvas');
                            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
                        }, 5000);
                    }
                    else
                        notify('error', response.message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (XMLHttpRequest.status == 422) {
                        var errors = XMLHttpRequest.responseJSON.errors;

                        $.each(errors, function(i, e) {
                            notify('error', e);
                        });
                    }
                    else
                        notify('error', response.message);
                },
                complete: function(response) {}
            });
        });

        $('#withdraw-offcanvas').on('change', 'select[name=method_code]', function() {
            if (!$(this).val()) {
                $('#withdraw-offcanvas .preview-details').addClass('d-none');
                return false;
            }

            var resource       = $('select[name=method_code] option:selected').data('resource');
            var fixed_charge   = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);

            $('#withdraw-offcanvas  .min').text(getAmount(resource.min_limit));
            $('#withdraw-offcanvas  .max').text(getAmount(resource.max_limit));

            var amount = parseFloat($('#withdraw-offcanvas input[name=amount]').val());

            if (!amount) {
                $('#withdraw-offcanvas .preview-details').addClass('d-none');
                return false;
            }

            $('#withdraw-offcanvas .preview-details').removeClass('d-none');

            var charge = parseFloat(fixed_charge + (amount * percent_charge / 100));
            $('#withdraw-offcanvas  .charge').text(getAmount(charge));

            var receivable = parseFloat((parseFloat(amount) - parseFloat(charge)));

            $('#withdraw-offcanvas .receivable').text(getAmount(receivable));
            var final_amo = parseFloat(parseFloat(receivable));

            $('#withdraw-offcanvas .final_amo').text(getAmount(final_amo));
            $('#withdraw-offcanvas .base-currency').text(resource.currency);
            $('#withdraw-offcanvas .method_currency').text(resource.currency);
            $('#withdraw-offcanvas input[name=amount]').on('input');
        });

        $('#withdraw-offcanvas input[name=amount]').on('input', function() {
            var data = $('select[name=method_code]').change();
            $('#withdraw-offcanvas .amount').text(parseFloat($(this).val()).toFixed(2));
        });

        // KYC script
        $('.new--kyc').on('click', function(e) {
            var myOffcanvas = document.getElementById('kyc-offcanvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });

        $(document).on('submit', '.frmKYC', function(e) {
            e.preventDefault();

            let frm = new FormData($('.frmKYC')[0]);
            let url = $(this).attr('action');
            
            $.ajax({
                method: 'POST',
                data: frm,
                processData: false,
                contentType: false,
                url: url,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    if( response.success == 1 ){
                        notify('success', response.message);
                        
                        setTimeout(() => {
                            location.reload(); 
                        }, 1500);
                    }
                    else
                        notify('error', response.message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notify('error', response.message);
                },
                complete: function(response) {}
            });
        });

        // Change Password
        $('.changepass-btn').on('click', function(e) {
            var myOffcanvas = document.getElementById('changepassword-canvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });

        // Change password
        $(document).on('submit', '.cpasss', function(e) {
            e.preventDefault();

            let frm = $(this).serialize();

            $.ajax({
                method: 'POST',
                data: frm,
                url: "{{ route('user.update.password') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    if( response.success == "error" ){
                        notify(response.success, response.message);
                    }
                    else{
                        Swal.fire({
                            allowOutsideClick: false,
                            target: document.getElementById('changepassword-canvas'),
                            text: response.message,
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#d33",
                            confirmButtonText: "Ok"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('user.logout') }}";
                            }
                        });
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {

                    if (XMLHttpRequest.status == 422) {

                        var errors = XMLHttpRequest.responseJSON.errors;

                        $.each(errors, function(i, e) {
                            $('[name="' + i + '"]').parent().find('span.error').html(`*${e}`);
                            notify('error', e);
                        });
                    }
                },
                complete: function(response) {}
            });
        });

        function validatePasswords() {
            let password = $('.cpass_password').val();
            let confirmPassword = $('.cpass_password_confirmation').val();
            let errorMessage = document.getElementById("error-message");
      
            if (password && confirmPassword && password != confirmPassword) {
                errorMessage.textContent = "Passwords do not match!";
                $('.cpass-btn').prop('disabled', true); // Disable the submit button
            } else {
                errorMessage.textContent = ""; // Clear the error message
                $('.cpass-btn').prop('disabled', false); // Disable the submit button
            }
        }
    </script>
@endpush