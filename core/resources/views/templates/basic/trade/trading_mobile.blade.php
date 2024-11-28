@php
    $meta = (object) $meta;
    $pair = $meta->pair;
    $markets = $meta->markets;
    $marketCurrencyWallet = $meta->marketCurrencyWallet;
    $coinWallet = $meta->coinWallet;
    $order_count = $meta->order_count;
    $lots = @$meta->lots;
    $fee_status = @$meta->fee_status;
    $isCategory = isset($_GET['category']);
    $widget = $meta->widget;
    $closed_orders = @$meta->closed_orders;
    $pl = @$meta->pl;
    $total_profit = @$meta->total_profit;
    $total_loss = @$meta->total_loss;
    $userGroup = @$meta->userGroup;
    $deposits = @$meta->deposits;
    $withdraws = @$meta->withdraws;
@endphp

<div class="tab-inner-wrapper" style="background-color: var(--pane-bg); {{ is_mobile() ? 'margin: 0' : '' }}">
    <div class="tab-content">
        <div class="tab-pane fade {{ !$isCategory ? 'active show' : '' }}" id="market-list-sm" role="tabpanel">
            @if (is_mobile())
                <x-flexible-view :view="$activeTemplate . 'trade.coin_sync_list'" :meta="['pair' => $pair, 'screen' => 'small']" />
            @endif
        </div>
        <div class="tab-pane fade {{ $isCategory ? 'active show' : '' }}" id="chart-sm" role="tabpanel"
            style=" {{ is_mobile() ? '' : '' }}">
            <x-flexible-view :view="$activeTemplate . 'trade.chart'" :meta="['pair' => $pair, 'screen' => 'small']" />
            <div class="position-relative">
                <x-flexible-view :view="$activeTemplate . 'trade.buy_sell'" :meta="[
                    'pair' => $pair,
                    'marketCurrencyWallet' => $marketCurrencyWallet,
                    'coinWallet' => $coinWallet,
                    'screen' => 'medium',
                    'order_count' => $order_count,
                    'lots' => $lots,
                    'fee_status' => $fee_status,
                ]" />
            </div>
        </div>
        <div class="tab-pane fade" id="portfolio-sm" role="tabpanel" style=" {{ is_mobile() ? '' : '' }}">
            <div class="position-relative">
                <x-flexible-view :view="$activeTemplate . 'trade.buy_sell'" :meta="[
                    'pair' => $pair,
                    'marketCurrencyWallet' => $marketCurrencyWallet,
                    'coinWallet' => $coinWallet,
                    'screen' => 'medium',
                    'order_count' => $order_count,
                    'lots' => $lots,
                    'fee_status' => $fee_status,
                    'view_portfolio' => true,
                    'marketCurrencyWallet' => $marketCurrencyWallet,
                    'deposits' => $deposits,
                    'withdraws' => $withdraws
                ]" />
            </div>
        </div>
        <div class="tab-pane fade" id="order-book-sm" role="tabpanel">
            <x-flexible-view :view="$activeTemplate . 'trade.my_order'" :meta="['pair' => $pair, 'screen' => 'small']" />
        </div>
        <div class="tab-pane fade" id="trade-history-sm" role="tabpanel">
            <x-flexible-view :view="$activeTemplate . 'trade.history'" :meta="[
                'pair' => $pair,
                'closed_orders' => $closed_orders,
                'pl' => $pl,
                'total_profit' => $total_profit,
                'total_loss' => $total_loss,
            ]" />
        </div>
        <div class="tab-pane fade" id="wallet-sm" role="tabpanel">
            <x-flexible-view :view="$activeTemplate . 'trade.portfolio'" :meta="[
                'widget' => $widget,
                'marketCurrencyWallet' => $marketCurrencyWallet,
                'deposits' => $deposits ,
                'withdraws' => $withdraws
            ]" />
        </div>
        <div class="tab-pane fade" id="menu-sm" role="tabpanel">
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
                                <span>{{ ( $userGroup != null ? ( ucwords($userGroup->name).' '.__('account') ) : __('Standard account') ) }}</span>
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
        </div>
    </div>


    <div class="mobile-navigator">
        <div class="bg-dark">
            <div>
                <ul class="d-flex justify-content-around nav nav-pills" id="pills-sm-tab-list" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link m-markets d-flex flex-column {{ !$isCategory ? 'active' : '' }}" data-type="m-markets" data-bs-toggle="pill"
                            data-bs-target="#market-list-sm" role="tab" aria-controls="pills-markettwentyfive"
                            aria-selected="false">
                            <i class="fas fa-chart-line" id="m-markets"></i>
                            <label>@lang('Markets')</label>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation" data-status="0">
                        <a class="nav-link m-portfolio d-flex flex-column" data-type="trade-btn-pill" data-bs-toggle="pill"
                            data-bs-target="#portfolio-sm" role="tab" aria-controls="pills-chartthree"
                            aria-selected="true">
                            <i class="fas fa-briefcase" id="trade-btn-pill"></i>
                            @lang('Trade')
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link m-closed d-flex flex-column" data-bs-toggle="pill"
                            data-bs-target="#trade-history-sm" role="tab" data-type="m-closed" aria-controls="pills-historytwentyfive"
                            aria-selected="false">
                            <i class="fas fa-history" id="m-closed"></i>
                            @lang('Closed Orders')
                        </a>
                    </li>
                    <li class="nav-item" role="presentation" data-status="0">
                        <a class="nav-link m-portfolio d-flex flex-column" data-type="m-portfolio" data-bs-toggle="pill"
                            data-bs-target="#wallet-sm" role="tab" aria-controls="pills-orderbookthree"
                            aria-selected="false">
                            <i class="fas fa-briefcase" id="m-portfolio"></i>
                            @lang('Dashboard')
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link d-flex flex-column" data-type="m-menu" data-bs-toggle="pill" data-bs-target="#menu-sm"
                            role="tab" aria-controls="pills-historytwentyfive" aria-selected="false">
                            <i class="fas fa-bars" id="m-menu"></i>
                            @lang('Menu')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                function displayInfo(e) {
                    const status = e.dataset.status;

                    if (status === 1) {
                        $('#portfolio-content-1').removeClass('d-none');
                        $('#portfolio-content-2').removeClass('d-none');
                    } else {
                        $('#portfolio-content-1').addClass('d-none');
                        $('#portfolio-content-2').addClass('d-none');
                    }
                }

                $(document).on('click', '.nav-link', function(){
                    let type = $(this).attr('data-type');
                    if( type === "m-closed" ){
                        fetchHistory();
                    }
                    sessionStorage.setItem("activeTab", type);
                });

                let isSwitching = false;

                document.querySelectorAll('.nav-link').forEach(link => {
                    link.addEventListener('click', function (e) {
                        if (isSwitching) {
                            e.preventDefault();
                            return;
                        }
                        isSwitching = true;

                        setTimeout(() => {
                            isSwitching = false;
                        }, 5000); 
                    });
                });

                $(document).on('click', '.theme-switch', function(){
                    $('.history-body .clickable-row').css('background-color', 'unset');
                });
            });
        </script>
    @endpush
    @push('style')
        <style>
            .tab-inner-wrapper {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                overflow: auto;
                padding: 2px;
                margin-bottom: 80px;
            }

            .mobile-navigator {
                position: fixed;
                bottom: 0;
                width: 100%;
                right: 0;
                z-index: 999;
            }

            @media screen and (max-width: 575px) {
                .nav-pills .nav-link {
                    padding: 20px 10px !important;
                    border-radius: 0 !important;
                }

                .nav-pills .nav-link.active,
                .nav-pills .show>.nav-link {
                    border-top: 4px solid yellow !important;
                    background: transparent !important;
                }
            }

            @media screen and (min-width: 575px) {
                .trading-mobile {
                    display: none;
                }
            }

            .menu-list {
                margin-top: 20px;
            }

            .menu-item {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
            }

            .menu-item i {
                font-size: 1.5rem;
                margin-right: 10px;
            }

            .menu-item .text-danger {
                font-size: 0.8rem;
                margin-left: 5px;
            }

            .summary-container h3 {
                font-size: 20px;
                padding-bottom: 10px;
                color: #f0f0f0;
            }

            #menuHeaderContainer {
                margin-bottom: 20px;
                border-bottom: 1px solid #3c4a54;
            }
        </style>

        @if (is_mobile())
            <style>
                .lang-dropdown .dropdown-list__item {
                    white-space: nowrap;
                    display: flex;
                    flex-flow: row;
                    padding-left: 0;
                    align-items: center;
                }

                .lang-dropdown span {
                    margin-right: 5px;
                }

                .lang-dropdown-list div .thumb {
                    width: 30px !important;
                }
            </style>
        @endif

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
            </style>

            @if (is_mobile())
                <style>
                    .offcanvas-header {
                        flex-flow: row-reverse;
                    }

                    #myprofile-canvas .register,
                    .register input,
                    #deposit-canvas form,
                    #deposit-canvas form input,
                    #changepassword-canvas form,
                    #changepassword-canvas form input,
                    #customDepositConfirmForm form,
                    #customDepositConfirmForm input,
                    #customDepositConfirmForm select,
                    #customDepositConfirmForm .form-group, {
                        text-align: right;
                    }

                    .a-label {
                        padding: 0;
                        width: unset !important;
                    }
                </style>
            @endif
        @endif
    @endpush
