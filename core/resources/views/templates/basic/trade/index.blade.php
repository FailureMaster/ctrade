@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="trading-section bg-color" style="width: 100%">
        <div>
            <div class="row mb-3" style="max-width: 100%; margin: 0 auto">
                <template>
                    <x-flexible-view :view="$activeTemplate . 'trade.pair'" :meta="['pair' => $pair, 'screen' => 'small']" />
                </template>
                <div class="col-md-3 col-lg-2 col-xl-3 px-0" style="position: relative;">
                    @if (!is_mobile())
                        <x-flexible-view :view="$activeTemplate . 'trade.coin_sync_list'" :meta="['pair' => $pair, 'screen' => 'small']" />
                    @endif
                </div>
                <div class="col-md-9 col-lg-10 col-xl-9">
                    <div class="row gy-2">
                        <div class="col-xl-10 col-md-9 mt-1 px-1">
                            {{-- <x-flexible-view :view="$activeTemplate . 'trade.pair'" :meta="['pair' => $pair]" /> --}}
                            <x-flexible-view :view="$activeTemplate . 'trade.tab'" :meta="[
                                'screen' => 'small',
                                'markets' => $markets,
                                'pair' => $pair,
                                'closed_orders' => $closed_orders,
                                'pl' => $pl,
                                'total_profit' => $total_profit,
                                'total_loss' => $total_loss,
                            ]" />
                            <div class="d-none d-md-block d-xl-none">
                                <x-flexible-view :view="$activeTemplate . 'trade.tab'" :meta="['screen' => 'medium', 'markets' => $markets, 'pair' => $pair]" />
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-3" style="position: relative;">
                            @if (!is_mobile())
                                <x-flexible-view :view="$activeTemplate . 'trade.buy_sell'" :meta="[
                                    'pair' => $pair,
                                    'marketCurrencyWallet' => $marketCurrencyWallet,
                                    'coinWallet' => $coinWallet,
                                    'screen' => 'big',
                                    'order_count' => $order_count,
                                    'lots' => $lots,
                                    'fee_status' => $fee_status,
                                ]" :lots />
                            @endif
                            {{-- <x-flexible-view :view="$activeTemplate . 'trade.order_book'" :meta="['pair' => $pair, 'screen' => 'big']" /> --}}
                        </div>
                        <div class="col-md-5 d-xl-none d-block p-0">
                            @if (!is_mobile())
                                <x-flexible-view :view="$activeTemplate . 'trade.buy_sell'" :meta="[
                                    'pair' => $pair,
                                    'marketCurrencyWallet' => $marketCurrencyWallet,
                                    'coinWallet' => $coinWallet,
                                    'screen' => 'medium',
                                    'order_count' => $order_count,
                                    'lots' => $lots,
                                    'fee_status' => $fee_status,
                                ]" />
                            @endif
                        </div>
                    </div>
                    <div class="row gy-2.5">
                        <div class="col-sm-12 mt-0 px-1">
                            <x-flexible-view :view="$activeTemplate . 'trade.trade_order_history'" :meta="[
                                'pair' => $pair,
                                'markets' => $markets,
                                'order_count' => $order_count,
                                'marketCurrencyWallet' => $marketCurrencyWallet,
                                'requiredMarginTotal' => $requiredMarginTotal,
                            ]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (is_mobile())
        <div class="trading-mobile">
            <x-flexible-view :view="$activeTemplate . 'trade.trading_mobile'" :meta="[
                'screen' => 'small',
                'markets' => $markets,
                'widget' => $widget,
                'pair' => $pair,
                'marketCurrencyWallet' => $marketCurrencyWallet,
                'coinWallet' => $coinWallet,
                'order_count' => $order_count,
                'lots' => $lots,
                'fee_status' => $fee_status,
                'closed_orders' => $closed_orders,
                'pl' => $pl,
                'total_profit' => $total_profit,
                'total_loss' => $total_loss,
                'userGroup'  => $userGroup
            ]" />
        </div>
    @endif

    <x-confirmation-modal isCustom="true" />
    <x-stop-loss-modal />
    <x-take-profit-modal />
    <x-frozen-account-modal />
    <x-mobile-date-modal />

    <div class="offcanvas offcanvas-end p-4" tabindex="-1" id="deposit-canvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
                @lang('Deposit Preview')
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('user.deposit.insert') }}" method="post" id="depositFrm"
                class="@if ($gateways->count() <= 0) d-none @endif">
                @csrf
                <input type="hidden" name="currency" value="{{ $currency->symbol }}">
                <input type="hidden" name="wallet_type" value="spot">
                <div class="form-group position-relative" id="currency_list_wrapper">
                    <x-currency-list :action="route('user.currency.all')" valueType="2" logCurrency="true" />
                </div>
                <div class="form-group">
                    <label class="form-label text-white">@lang('Amount')</label>
                    <div class="input-group">
                        <input type="number" step="any" class="form--control form-control text-white" name="amount"
                            required style="border: 1px solid #7c666675">
                        <!-- <span class="input-group-text text-white deposit-currency-symbol">{{ __($currency->symbol) }}</span> -->
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label text-white">@lang('Gateway')</label>
                    <select class="form-control form--control form-select text-white" name="gateway" required
                        style="border: 1px solid #7c666675">
                        <option selected disabled>@lang('Select Payment Gateway')</option>
                        @foreach ($gateways as $gateway)
                            <option value="{{ $gateway->method_code }}" data-gateway='@json($gateway)'>
                                {{ __($gateway->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group preview-details d-none">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex flex-wrap justify-content-between">
                            <span>@lang('Limit')</span>
                            <span>
                                <span class="min fw-bold">0</span>
                                - <span class="max fw-bold">0</span>
                                <span class="deposit-currency-symbol">{{ __(@$singleCurrency->symbol) }}</span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex flex-wrap justify-content-between">
                            <span>@lang('Charge')</span>
                            <span>
                                <span class="charge fw-bold">0</span>
                                <span class="deposit-currency-symbol">{{ __(@$singleCurrency->symbol) }}</span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex flex-wrap justify-content-between">
                            <span> @lang('Payable')</span>
                            <span>
                                <span class="payable fw-bold">0</span>
                                <span class="deposit-currency-symbol">{{ __(@$singleCurrency->symbol) }}</span>
                            </span>
                        </li>
                    </ul>
                </div>
                <button class="deposit__button btn btn--base w-100" type="submit"> @lang('Submit') </button>
            </form>
            <div class="p-5 text-center empty-gateway @if ($gateways->count() > 0) d-none @endif">
                <img src="{{ asset('assets/images/extra_images/no_money.png') }}">
                <h6 class="mt-3">
                    @lang('No payment gateway available for ')
                    <span class="text--base deposit-currency-symbol">{{ __($currency->symbol) }}</span>
                    @lang('Currency')
                </h6>
            </div>
        </div>
    </div>

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

    <div class="offcanvas offcanvas-end p-4" tabindex="-1" id="changepassword-canvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
                @lang('Change Password')
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="" method="post" class="cpass">
                @csrf
                <div class="form-group">
                    <label class="form-label">@lang('Current Password')</label>
                    <input type="password" class="form--control" name="current_password" required
                        autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Password')</label>
                    <input type="password" class="form--control @if ($general->secure_password) secure-password @endif"
                        name="password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Confirm Password')</label>
                    <input type="password" class="form-control form--control" name="password_confirmation" required
                        autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection
@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/broadcasting.js') }}"></script>
    <script src="{{ asset('assets/global/js/iziToast.min.js') }}"></script>
    <script>
        "use strict";

        function toastr(status, message, position = "topRight") {
            if (typeof message == 'string') {
                iziToast[status]({
                    message: message,
                    position,
                    displayMode: 1
                });
            } else {
                $.each(message, function(i, val) {
                    iziToast[status]({
                        message: val,
                        position,
                        displayMode: 1
                    });
                });
            }
        }


        function ConfirmCloseOnMobile() {
            const checkClose = sessionStorage.getItem("confirmClose");
            if (checkClose === "true") {
                sessionStorage.removeItem("confirmClose");
                $("#trade-btn-pill").trigger("click");
            }
        }

        $(document).ready(function() {
            ConfirmCloseOnMobile(); // this function is to keep trade tab open after closing the order
        });
    </script>
@endpush

@push('script')
    <script>
        "use strict";
        $('.new--deposit').on('click', function(e) {
            @auth
            let currency = $(this).data('currency');
            let gateways = @json($gateways);
            let currencyGateways = gateways.filter(ele => ele.currency == currency);

            if (currencyGateways && currencyGateways.length > 0) {
                let gatewaysOption = "<option selected disabled> @lang('Select Payment Gateway')</option>";
                $.each(currencyGateways, function(i, currencyGateway) {
                    gatewaysOption += `<option value="${currencyGateway.method_code}"  data-gateway='${JSON.stringify(currencyGateway)}'>
                                ${currencyGateway.name}
                            </option>`;
                });
                $("#deposit-canvas").find('select[name=gateway]').html(gatewaysOption);
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

        $('.myprofile-btn').on('click', function(e) {
            var myOffcanvas = document.getElementById('myprofile-canvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });

        $('.changepass-btn').on('click', function(e) {
            var myOffcanvas = document.getElementById('changepassword-canvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });

        // Change password
        $(document).on('submit', '.cpass', function(e) {
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

        @auth
        $('#deposit-canvas').on('change', 'select[name=gateway]', function() {

            if (!$(this).val()) {
                $('#deposit-canvas .preview-details').addClass('d-none');
                return false;
            }

            var resource = $('select[name=gateway] option:selected').data('gateway');
            var fixed_charge = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);
            var rate = parseFloat(resource.rate);
            var amount = parseFloat($('#deposit-canvas input[name=amount]').val());

            $('#deposit-canvas .min').text(getAmount(resource.min_amount));
            $('#deposit-canvas .max').text(getAmount(resource.max_amount));

            if (!amount) {
                $('#deposit-canvas .preview-details').addClass('d-none');
                return false;
            }

            $('#deposit-canvas .preview-details').removeClass('d-none');

            var charge = parseFloat(fixed_charge + (amount * percent_charge / 100));
            var payable = parseFloat((parseFloat(amount) + parseFloat(charge)));
            var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate);


            $("#deposit-canvas").find(".empty-gateway").addClass('d-none');
            $("#deposit-canvas").find("form").removeClass('d-none');

            $('#deposit-canvas .charge').text(getAmount(charge));
            $('#deposit-canvas .payable').text(getAmount(payable));
            $('#deposit-canvas .final_amo').text(getAmount(final_amo));

            $('#deposit-canvas .method_currency').text(resource.currency);
            $('#deposit-canvas input[name=amount]').on('input');

        });

        $('#deposit-canvas').on('input', 'input[name=amount]', function() {
            var data = $('#deposit-canvas select[name=gateway]').change();
            $('#deposit-canvas .amount').text(parseFloat($(this).val()).toFixed(2));
        });
        @endauth

        pusherConnection('market-data', marketChangeHtml);

        var swiper = new Swiper(".myswiper-two", {
            slidesPerView: 5,
            spaceBetween: 0,
            navigation: {
                nextEl: ".swiper-button-next-two",
                prevEl: ".swiper-button-prev-two",
            },
            breakpoints: {
                575: {
                    slidesPerView: 6,
                    spaceBetween: 0,
                },
                992: {
                    slidesPerView: 5,
                    spaceBetween: 0,
                },
            },
        });

        window.visit_pair = {
            selection: "{{ @$pair->marketData->id }}",
            symbol: "{{ @$pair->symbol }}",
            site_name: "{{ __($general->site_name) }}"
        };

        $('header').find(`.container`).addClass(`custom--container`);

        function countDecimalPlaces(num) {
            // Convert the number to a string
            const numStr = num.toString();

            // Check if there is a decimal point
            const decimalIndex = numStr.indexOf('.');

            // If there's no decimal point, return 0
            if (decimalIndex === -1) {
                return 0;
            }

            // Calculate the number of decimal places
            const decimalPlaces = numStr.length - decimalIndex - 1;

            return decimalPlaces;
        }
    </script>
@endpush

@push('style')
    <style>
        .cookies-card {
            background-color: #181d20 !important;
            color: #93988f !important;
        }

        .has-mega-menu .mega-menu {
            background: #181d20 !important;
        }

        @media screen and (min-width: 575px) {
            .trading-mobile {
                display: none;
            }
        }

        @media screen and (max-width: 375px) {
            .nav-link {
                font-size: 11px;
            }
        }

        @media screen and (max-width: 320px) {
            .nav-link {
                font-size: 10px;
            }
        }
    </style>
@endpush

@if (is_mobile())
    @push('style')
        <style>
            .trading-right,
            .trading-table__mobile,
            .trading-table__mobile,
            .tab-inner-wrapper {
                margin-top: 0;
                padding: 0;
            }

            [data-theme=dark] .tab-inner-wrapper {
                background-color: #0f1821 !important;
            }

            [data-theme=light] .summary-container,
            .tab-inner-wrapper {
                background-color: #ffffff;
                color: #000000;
            }

            [data-theme=light] .portfolio-item .label,
            [data-theme=light] .clickable-row span,
            [data-theme=light] .menu-list .menu-item a,
            [data-theme=light] .thumb,
            [data-theme=light] span, 
            [data-theme=light] #modalBuySell span,
            [data-theme=light] #modalBuySell label,
            [data-theme=light] #modalBuySell small {
                font-weight: bold;
                color: #000000 !important;
            }

            [data-theme=light] #modalBuySell .modal-content,
            [data-theme=light] #modalBuySell .modal-body{
                background-color :#ffffff !important;
            }

            [data-theme=light] #deposit-canvas,
            [data-theme=light] #myprofile-canvas,
            [data-theme=light] #changepassword-canvas{
                background-color: #ffffff;
                color: #000000 !important;
            }

            [data-theme=light] #deposit-canvas label,
            [data-theme=light] #myprofile-canvas label,
            [data-theme=light] #changepassword-canvas label,
            [data-theme=light] .offcanvas-title{
                font-weight: bold;
                color: #000000 !important;
            }

            [data-theme=light] .slider{
                background-color: #000000;
            }

            .trading-right {
                border: none;
            }

            .btn-filter {
                background-color: #0f1821;
                color: #ffffff;
            }

            .register input,
            .cpass input {
                color: #ffffff !important;
                border-color: #ffffff;
            }

            [data-theme=light] .register input,
            [data-theme=light] .cpass input {
                color: #000000 !important;
                border-color: #000000;
            }

            [data-theme=light] h5, [data-theme=light] .ellipsis-menu, [data-theme=light] .no-order-label {
                color: #000000 !important;
            }

            .offcanvas{
                width: 100%;
            }

            #amount{
                height: 30px !important;
                padding: 0;
            }

            [data-theme=light] #mobileDateFilterDropdown {
                background-color: #ffffff;
                color: #000000;
                border: 1px solid #000000;
            }

            [data-theme=light] #mobileCustomDateFilterModal .modal-content {
                background-color: #ffffff !important;
            }

            [data-theme=light] .custom--modal .modal-content{
                background-color:#ffffff !important;
                color: #000000;
            }

            [data-theme=light] #depositFrm input, [data-theme=light] #depositFrm select{
                color: #000000 !important;
            }
        </style>
    @endpush
@else
    @push('style')
        <style>
            #market-nav a,
            #market-nav div,
            #market-nav span {
                font-size: 13px !important;
            }

            .trading-right {
                padding-right: 0 !important;
                padding-left: 0 !important;
            }
        </style>
    @endpush
@endif


@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
