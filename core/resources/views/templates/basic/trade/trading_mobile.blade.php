@php
    $meta    = (object) $meta;
    $pair    = $meta->pair;
    $markets = $meta->markets;
    $marketCurrencyWallet = $meta->marketCurrencyWallet;
    $coinWallet = $meta->coinWallet;
    $order_count = $meta->order_count;
    $lots                 = @$meta->lots;
    $fee_status                 = @$meta->fee_status;
    $isCategory = isset($_GET['category']);
@endphp

<div class="tab-inner-wrapper" style="background-color: var(--pane-bg); {{is_mobile() ? 'margin: 0' : ''}}">
    <div class="tab-content">
        <div class="tab-pane fade {{ !$isCategory ? 'active show' : '' }}" id="market-list-sm" role="tabpanel">
            @if (is_mobile())
                <x-flexible-view :view="$activeTemplate . 'trade.coin_sync_list'" :meta="['pair' => $pair, 'screen' => 'small']" />
            @endif
        </div>
        <div class="tab-pane fade {{ $isCategory ? 'active show' : '' }}" id="chart-sm" role="tabpanel" style=" {{is_mobile() ? '' : ''}}">
            <x-flexible-view :view="$activeTemplate . 'trade.chart'" :meta="['pair' => $pair, 'screen' => 'small']" />
            <div class="position-relative">
                <x-flexible-view :view="$activeTemplate . 'trade.buy_sell'" :meta="[
                    'pair' => $pair,
                    'marketCurrencyWallet' => $marketCurrencyWallet,
                    'coinWallet' => $coinWallet,
                    'screen' => 'medium',
                    'order_count' => $order_count,
                    'lots' => $lots,'fee_status' => $fee_status
                ]" />
            </div>
        </div>
        <div class="tab-pane fade" id="portfolio-sm" role="tabpanel" style=" {{is_mobile() ? '' : ''}}">
            <div class="position-relative">
                <x-flexible-view :view="$activeTemplate . 'trade.buy_sell'" :meta="[
                    'pair' => $pair,
                    'marketCurrencyWallet' => $marketCurrencyWallet,
                    'coinWallet' => $coinWallet,
                    'screen' => 'medium',
                    'order_count' => $order_count,
                    'lots' => $lots,
                    'fee_status' => $fee_status,
                    'view_portfolio' => true
                ]" />
            </div>
        </div>
        <div class="tab-pane fade" id="order-book-sm" role="tabpanel">
            <x-flexible-view :view="$activeTemplate . 'trade.my_order'" :meta="['pair' => $pair, 'screen' => 'small']" />
        </div>
        <div class="tab-pane fade" id="trade-history-sm" role="tabpanel">
            <x-flexible-view :view="$activeTemplate . 'trade.history'" :meta="['pair' => $pair]" />
        </div>
        <div class="tab-pane fade" id="menu-sm" role="tabpanel">
            <div class="summary-container">
                <div class="d-flex justify-content-between" id="menuHeaderContainer">
                    <h3>Menu</h3>
                    @if(Auth::check())
                    <span class="text-white">
                        <i class="fas fa-user me-2"></i> {{ __(auth()->user()->fullname) }}
                    </span>
                    @endif
                </div>
                <ul class="list-unstyled menu-list">
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-gift"></i>-->
                    <!--    <span>Rewards & Benefits</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-calendar-alt"></i>-->
                    <!--    <span>Economic Calendar</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-clipboard-list"></i>-->
                    <!--    <span>Account Types</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-user"></i>-->
                    <!--    <span>Personal Details</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-exchange-alt"></i>-->
                    <!--    <span>Manage Accounts</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-history"></i>-->
                    <!--    <span>Transaction History</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-wallet"></i>-->
                    <!--    <span>Wallet</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-undo-alt"></i>-->
                    <!--    <span>Withdraw</span>-->
                    <!--</li>-->
                    <!--<li class="menu-item">-->
                    <!--    <i class="fas fa-check-circle"></i>-->
                    <!--    <span>Account Verification</span>-->
                    <!--</li>-->
                    <li class="menu-item text-white">
                        <a href="{{ route('user.profile.setting') }}" class="text-white">
                            <i class="fas fa-undo-alt"></i>
                            <span>@lang('My Profile')</span>
                        </a>
                    </li>
                    @if(Auth::check())
                        <li class="menu-item">
                            <!-- <a href="{{ route('user.home') }}?d=1" class="text-white "> -->
                            <a class="text-white new--deposit" data-currency="{{  @$pair->market->currency->symbol }}">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Deposit</span>
                            </a>
                        </li>
                    @endif
                        @if(Auth::check())
                        <li class="menu-item">
                            <a href="{{ route('user.change.password') }}" class="text-white">
                                <i class="fas fa-key"></i>
                                <span>@lang('Change Password')</span>
                            </a>
                        </li>
                    @endif
                    
                    @if(Auth::check())
                        <li class="menu-item">
                            <a href="{{ route('user.logout') }}" class="text-white">
                                <i class="far fa-user-circle"></i>
                                <span>@lang('Logout')</span>
                            </a>
                        </li>
                    @endif

                        @php
                            $langDetails = $languages->where('code', config('app.locale'))->first();
                        @endphp
                    
                        <li class="menu-item">
                        <div class="custom--dropdown">
                            <div class="custom--dropdown__selected dropdown-list__item">
                                <div class="thumb">
                                    <img
                                        src="{{ getImage(getFilePath('language') . '/' . @$langDetails->flag, getFileSize('language')) }}">
                                </div>
                                <span class="text text-uppercase">{{ __(@$langDetails->code) }}</span>
                            </div>
                            <ul class="dropdown-list">
                                @foreach ($languages as $language)
                                    <li class="dropdown-list__item change-lang "
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
                </ul>
            </div>
    </div>
</div>


<div class="mobile-navigator">
    <div class="bg-dark">
        <div>
            <ul
                class="d-flex justify-content-around nav nav-pills"
                id="pills-sm-tab-list"
                role="tablist"
                >
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link d-flex flex-column {{ !$isCategory ? 'active' : '' }}"
                        data-bs-toggle="pill"
                        data-bs-target="#market-list-sm"
                        role="tab"
                        aria-controls="pills-markettwentyfive"
                        aria-selected="false"
                        >
                        <i class="fas fa-chart-line"></i>
                        <label>@lang('Instruments')</label>
                    </a>
                </li>
                <li class="nav-item" role="presentation" data-status="0">
                    <a
                        href="#"
                        class="nav-link m-portfolio d-flex flex-column"
                        data-bs-toggle="pill"
                        data-bs-target="#portfolio-sm"
                        role="tab"
                        aria-controls="pills-chartthree"
                        aria-selected="true"
                        >
                        <i class="fas fa-briefcase"></i>
                        @lang('Portfolio')
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link d-flex flex-column"
                        data-bs-toggle="pill"
                        data-bs-target="#order-book-sm"
                        role="tab"
                        aria-controls="pills-orderbookthree"
                        aria-selected="false"
                        >
                        <i class="fas fa-users"></i>
                        @lang('Orders')
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link d-flex flex-column"
                        data-bs-toggle="pill"
                        data-bs-target="#trade-history-sm"
                        role="tab"
                        aria-controls="pills-historytwentyfive"
                        aria-selected="false"
                        >
                        <i class="fas fa-history"></i>
                        @lang('History')
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        href="#"
                        class="nav-link d-flex flex-column"
                        data-bs-toggle="pill"
                        data-bs-target="#menu-sm"
                        role="tab"
                        aria-controls="pills-historytwentyfive"
                        aria-selected="false"
                        >
                        <i class="fas fa-bars"></i>
                        @lang('Menu')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@push('script')
    <script>
        $(document).ready(function(){
            function displayInfo(e)
            {
                const status = e.dataset.status;

                if( status === 1 ){
                    $('#portfolio-content-1').removeClass('d-none');
                    $('#portfolio-content-2').removeClass('d-none');
                }
                else{
                    $('#portfolio-content-1').addClass('d-none');
                    $('#portfolio-content-2').addClass('d-none');
                }
            }
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
            .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
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

        #menuHeaderContainer{
            margin-bottom: 20px;
            border-bottom: 1px solid #3c4a54;
        }
    </style>
@endpush