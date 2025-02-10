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
                        <div class="col-xl-10 col-md-9 mt-1 px-1 m-graph">
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

                        <div class="col-xl-2 col-md-3 m-dashboard" style="position: relative;">
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
                    <div class="row gy-2.5" id="tbl-section">
                        <div class="col-sm-12 mt-0 px-1">
                            <x-flexible-view :view="$activeTemplate . 'trade.trade_order_history'" :meta="[
                                'pair' => $pair,
                                'markets' => $markets,
                                'order_count' => $order_count,
                                'marketCurrencyWallet' => $marketCurrencyWallet,
                                'requiredMarginTotal' => $requiredMarginTotal,
                                'isInGroup' => $isInGroup
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
                'userGroup'  => $userGroup,
                'deposits'   => $deposits,
                'withdraws' => $withdraws
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
            <form action="" method="post" id="depositFrm"
                class="@if ($gateways->count() <= 0) d-none @endif">
                @csrf
                <input type="hidden" name="currency" value="{{ $currency->symbol }}">
                <input type="hidden" name="wallet_type" value="spot">
                {{-- <div class="form-group position-relative" id="currency_list_wrapper">
                    <x-currency-list :action="route('user.currency.all')" valueType="2" logCurrency="true" />
                </div> --}}
                <div class="form-group">
                    <select class="form-control form--control form-select text-white" name="gateway" required
                    style="border: 1px solid #7c666675">
                        <option value="USD" >United States Dollar-USD</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label text-white">@lang('Amount')</label>
                    <div class="input-group">
                        <input type="number" step="any" class="form--control form-control text-white" name="amount"
                            required style="border: 1px solid #7c666675">
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

    <div class="offcanvas offcanvas-end p-4" tabindex="-1" id="deposit-confirmation-canvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
                @lang('Deposit Confirmation')
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body">
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="withdraw-offcanvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
                @lang('Withdraw')
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="#" method="post" class="@if($withdrawMethods->count() <=0 ) d-none @endif" id="frmWithdrawMoney">
                @csrf
                <input type="hidden" name="currency" value="{{ $currency->symbol }}">
                <div class="form-group">
                    <label class="form-label">@lang('Amount')</label>
                    <div class="input-group">
                        <input type="number" step="any" name="amount" value="{{ old('amount') }}" id="amount-withdraw" class="form-control form--control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Method')</label>
                    <select class="form-control form--control form-select" name="method_code" required>
                        <option selected disabled>@lang('Select Withdraw Method')</option>
                        @foreach ($withdrawMethods as $method)
                            <option value="{{ $method->id }}" data-resource='@json($method)'>
                                {{ __($method->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="wallet_type" value="spot" for_fiat="1" for_crypto="1">
                {{-- <div class="form-group">
                    <label class="form-label">@lang('Type')</label>
                    <select class="form-control form--control form-select" name="wallet_type" required>
                        <option value="spot" for_fiat="1" for_crypto="1" selected>@lang('Balance')</option>
                    </select>
                </div> --}}
                <div class="mt-3 preview-details d-none">
                    <ul class="list-group text-center list-group-flush">
                        <li class="list-group-item d-flex flex-wrap justify-content-between">
                            <span>@lang('Limit')</span>
                            <span>
                                <span class="min fw-bold">0</span>
                                <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span> -
                                 <span class="max fw-bold">0</span>
                                 <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex flex-wrap justify-content-between">
                            <span>@lang('Charge')</span>
                            <span>
                                <span class="charge fw-bold">0</span>
                                <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex flex-wrap justify-content-between">
                            <span>@lang('Receivable')</span>
                            <span>
                                <span class="receivable fw-bold"> 0</span>
                                <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                            </span>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
            </form>
            <div class="p-5 text-center empty-gateway @if($withdrawMethods->count() > 0 ) d-none @endif">
                <img src="{{ asset('assets/images/extra_images/no_money.png') }}" alt="">
                <h6 class="mt-3">
                    @lang('No withdraw method available for ')
                    <span class="text--base withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                    @lang('Currency')
                </h6>
            </div>

            <div class="mt-5 pending-withdraw-section">
                <div class="text-center">
                    <h4 class="mb-0 fs-18 offcanvas-title text-white">@lang('Pending Withdraws')</h4>
                </div>
                <div class="table-responsive" id="tblPendingWithdraw">
                    <table class="tbl-pw">
                        <thead>
                            @if (App::getLocale() != 'ar')
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Amount')</th>
                                    <th></th>
                                </tr>
                            @else
                                <tr>
                                    <th></th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            @endif
                        </thead>
                        <tbody>
                            @foreach( $pendingWithdraw as $pw )
                                @if (App::getLocale() != 'ar')
                                    <tr>
                                        <td>
                                            {{ showDateTime($pw->created_at) }} <br>
                                            {{ diffForHumans($pw->created_at) }}
                                        </td>
                                        <td>
                                            {{ showAmount($pw->amount) }} - <span class="text--danger"
                                                title="@lang('charge')">{{ showAmount($pw->charge) }} </span>
                                            <br>
                                            <strong title="@lang('Amount after charge')">
                                                {{ showAmount($pw->amount - $pw->charge) }}
                                                {{ @$pw->currency }}
                                            </strong>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning btn-cancelw" data-id="{{ Crypt::encrypt($pw->id) }}">@lang('Cancel')</button>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>
                                            <button class="btn btn-sm btn-warning btn-cancelw" data-id="{{ Crypt::encrypt($pw->id) }}">@lang('Cancel')</button>
                                        </td>
                                        <td>
                                            {{ showAmount($pw->amount) }} - <span class="text--danger"
                                                title="@lang('charge')">{{ showAmount($pw->charge) }} </span>
                                            <br>
                                            <strong title="@lang('Amount after charge')">
                                                {{ showAmount($pw->amount - $pw->charge) }}
                                                {{ @$pw->currency }}
                                            </strong>
                                        </td>
                                        <td>
                                            {{ showDateTime($pw->created_at) }} <br>
                                            {{ diffForHumans($pw->created_at) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end p-4" tabindex="-1" id="withdraw-confirmation-canvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
                @lang('Withdraw Confirmation')
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body">
        </div>
    </div>

    <div class="offcanvas offcanvas-end p-4" tabindex="-1" id="kyc-offcanvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
                @lang('KYC')
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            @if( auth()->user()->kv === 0 )
                @include('components.kyc-form')
            @elseif( auth()->user()->kv === 2 )
                @include('components.kyc-info')
            @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            else{
                const activeTab = sessionStorage.getItem("activeTab");
                
                if( activeTab != "" ){
                    $('#'+activeTab).trigger('click');
                }
            }
        }

        $(document).ready(function() {
            ConfirmCloseOnMobile(); // this function is to keep trade tab open after closing the order

            // Removing active tab when seleting market item
            $(document).on('click', '.market-coin-item', function(){
                sessionStorage.removeItem("activeTab");
            })

            
            window.addEventListener('load', function() {
                if (window.innerWidth === 1280) {
                    window.scrollBy(0, 100);
                }
            });

            $(document).on('click', '.btn-cancelw', function() {
              
                let id = $(this).attr('data-id');
         
                Swal.fire({
                    target: document.getElementById('withdraw-offcanvas'),
                    text: "Are you sure you want to cancel this withdrawal?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            data: { id : id },
                            dataType: 'json',
                            url: "{{ route('user.withdraw.cancel.pending-withdraw') }}",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if( response.success == 1 ){
                                    
                                    notify('success', response.message);

                                    $("#m-portfolio").trigger("click");

                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                notify('error', 'Failed!');
                            },
                            complete: function(response) {}
                        });
                    }
                });
            });
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
 
            // if (currencyGateways && currencyGateways.length > 0) {
            if (currencyGateways) {
                // let gatewaysOption = "<option selected disabled> @lang('Select Payment Gateway')</option>";
                // $.each(currencyGateways, function(i, currencyGateway) {
                //     gatewaysOption += `<option value="${currencyGateway.method_code}"  data-gateway='${JSON.stringify(currencyGateway)}'>
                //                 ${currencyGateway.name}
                //             </option>`;
                // });
                // $("#deposit-canvas").find('select[name=gateway]').html(gatewaysOption);
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

        $('.new--withdraw').on('click', function(e) {
            var myOffcanvas = document.getElementById('withdraw-offcanvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
        });

        $('.new--kyc').on('click', function(e) {
            var myOffcanvas = document.getElementById('kyc-offcanvas');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas).show();
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

            let url = $(this).attr('action');

            $.ajax({
                method: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false, 
                processData: false,
                url: url,
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

        $(document).on('click', '.clickable-row', function(){
            $('.collapse').removeClass('show');

            if( $('[data-theme=light]').length > 0 ) 
                $('.clickable-row[aria-expanded="true"]').css('background-color', '#ffffff');
            else
                $('.clickable-row[aria-expanded="true"]').css('background-color', '#0F1821');
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

        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4); // Add '/' after MM
            }
            this.value = value;
        
            // Validate MM (01-12)
            let mm = parseInt(value.substring(0, 2), 10);
            if (mm > 12) {
                this.value = '12/' + value.substring(3, 5); // Set max month to 12
            }
        });
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

        @media screen and (max-width: 1280px) {
            .m-dashboard{
                width:23%;
            }

            .m-graph{
                width:77%;
            }
        }

        .card-image-container img{
            height:100px;
        }
        .card-m-image-container img{
            height:50px;
        }

        .row-mobile{
            --bs-gutter-x: 0 !important;
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

            
            [data-theme=dark] .amount-section{
                color: #ffffff;
                border: 1px solid #ffffff;
                border-radius: 4px;
            }

            [data-theme=light] .amount-section{
                border: 1px solid #7c666675;
                border-radius: 4px;
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
            [data-theme=light] #changepassword-canvas,
            [data-theme=light] #deposit-confirmation-canvas,
            [data-theme=light] #withdraw-offcanvas,
            [data-theme=light] #kyc-offcanvas,
            [data-theme=light] #withdraw-confirmation-canvas{
                background-color: #ffffff;
                color: #000000 !important;
            }

            [data-theme=light] #deposit-canvas label,
            [data-theme=light] #myprofile-canvas label,
            [data-theme=light] #changepassword-canvas label,
            [data-theme=light] .offcanvas-title,
            [data-theme=light] #deposit-confirmation-canvas label{
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
            [data-theme=light] .cpass input,
            [data-theme=light] #customDepositConfirmForm input,
            [data-theme=light] #customDepositConfirmForm,
            [data-theme=light] #customDepositConfirmForm select ,
            [data-theme=light] #frmWithdrawMoney input,
            [data-theme=light] #frmWithdrawMoney select,
            [data-theme=light] #frmWithdrawMoney,
            [data-theme=light] #frmConfirmWithdraw,
            [data-theme=light] #frmConfirmWithdraw input{
                color: #000000 !important;
                border-color: #7c666675 !important;
            }

            [data-theme=light] h5, [data-theme=light] .ellipsis-menu, [data-theme=light] .no-order-label, [data-theme=light] .empty-gateway h6 {
                color: #000000 !important;
            }

            .offcanvas{
                width: 100%;
            }

            #amount{
                height: 45px;
                padding: 15px;
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

            [data-theme=light] #depositFrm input, [data-theme=light] #depositFrm select, 
            [data-theme=light] #customDepositConfirmForm input,
            [data-theme=light] #customDepositConfirmForm select,
            #customDepositConfirmForm h4{
                color: #000000 !important;
            }

            [data-theme=dark] #customDepositConfirmForm input,
            [data-theme=dark] #customDepositConfirmForm select,
            [data-theme=dark] #frmWithdrawMoney .form--control,
            [data-theme=dark] #frmWithdrawMoney select{
                color: #ffffff;
                border: 1px solid #ffffff;
            }

            [data-theme=dark] #customDepositConfirmForm h4{
                color: #ffffff !important;
            }

            [data-theme=dark] .confirm-withdraw-content h5{
                color: #ffffff !important;
            }

            [data-theme=dark] .confirm-withdraw-content form input{
                border-color: #ffffff !important;
                color: #ffffff !important;
            }

            .btn-sm{
                padding: .25rem .5rem;
                font-size: .875rem;
                line-height: 1.5;
                border-radius: .2rem;
            }

            [data-theme=light] .tbl-pw tr td{
                color: #000000 !important;
            }

            .tbl-pw{
                display:table;
            }

            .pending-withdraw-section tbody tr td:last-child {
                padding-right: 0;
            }
        </style>
        @if (App::getLocale() == 'ar')
            <style>
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
