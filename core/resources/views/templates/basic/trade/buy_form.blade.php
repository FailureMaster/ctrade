@php
    $meta = (object) $meta;
    $pair = @$meta->pair;
    $marketCurrencyWallet = @$meta->marketCurrencyWallet;
    $screen = @$meta->screen;
    $percentChargeForBuy = @$pair->percent_charge_for_buy;
    $order_count = @$meta->order_count;
    $lots = @$meta->lots;
    $fee_status = @$meta->fee_status;
    $view_portfolio = @$meta->view_portfolio;
    $jsonData = file_get_contents(resource_path('data/data1.json'));
    $data = json_decode($jsonData, true);
@endphp
<!--<h3 class="px-4 mt-3 text-white">
Portfolio </h3>-->
<form class="buy-sell-form buy-sell @if (@$meta->screen == 'small') buy-sell-one @endif buy--form" method="POST">
    @csrf
    @if ($meta->screen == 'small')
        <span class="sidebar__close"><i class="fas fa-times"></i></span>
    @endif
    <input type="hidden" name="order_side" value="{{ Status::BUY_SIDE_ORDER }}">
    <input type="hidden" name="order_type" value="{{ Status::ORDER_TYPE_LIMIT }}">

    <input type="hidden" name="order_volume_1" value="" id="order_volume_1">
    <input type="hidden" name="order_volume_2" value="" id="order_volume_2">
    @if (is_mobile())
        <div class="modal fade" id="modalBuySell" tabindex="-1" aria-labelledby="fullScreenModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header d-flex">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-dark">{{ $pair->symbol }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color:#0d1e23;">
                        <div class="buy-sell__price pt-1 pb-1">
                            <div class="input--group group-two @if (App::getLocale() == 'ar') text-end @endif">
                                <!--<span class="buy-sell__price-title fs-12">@lang('Lots')</span>-->
                                <label for="id_label_single"
                                    class="@if (is_mobile()) d-flex justify-content-between @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                                    <span class="text-themed mb-1"
                                        style="@if (is_mobile()) margin-right: 4px @endif">
                                        @lang('Volume in Lots')
                                    </span>
                                    <select id="lot-size-select" class="form--control style-three lot-size-select"
                                        name="amount"
                                        style="height: 60px; width: 50px; @if (is_mobile()) min-width: 70% !important @endif"
                                        onchange="updateLotValues(this)" data-fee-status="{{ $fee_status }}">
                                        @if ($lots && $lots->isNotEmpty())
                                            @foreach ($lots as $lot)
                                                @php
                                                    // Remove unnecessary decimal places
                                                    $lot_volume_display = $lot->lot_volume;
                                                    // Check if the value is an integer or specific allowed decimals
                                                    if (floor($lot->lot_volume) == $lot->lot_volume) {
                                                        // No decimal places for whole numbers between 1 and 10
                                                        $lot_volume_display = number_format($lot->lot_volume, 0);
                                                    } else {
                                                        // Keep the decimal for allowed specific values if needed
                                                        $lot_volume_display = rtrim(rtrim($lot->lot_volume, '0'), '.');
                                                    }
                                                @endphp
                                                <option value="{{ $lot->lot_value }}"
                                                    {{ $lot->selected == 1 ? 'selected' : '' }}>
                                                    {{ $lot_volume_display }}</option>
                                            @endforeach
                                        @else
                                            <p>No lots available</p>
                                        @endif
                                    </select>

                                </label>
                                <small class="text-themed d-block mb-1 d-none">
                                    <span class="lot-label"></span>:
                                    <span class="lot-value"></span>
                                </small>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <div id="lot-eq-fetch">
                                    <span class="lot-eq-span">{{ $pair ? $pair->percent_charge_for_buy : '0' }}</span>
                                    <span class="lot-currency ms-2">{{ @$pair->coin_name }}</span>
                                </div>
                                <div id="lot-eq2-fetch">
                                    <span class="ll-size-span"></span>
                                    <span>{{ @$pair->market_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mx-4 mb-3">
                            <ul class="p-0 m-0">
                                <li class="mt-1 pt-1 d-flex flex-column gap-2">
                                    <div
                                        class="d-flex justify-content-between align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                                        <small class="text-themed d-block mb-1 pip-label">
                                            <span class="{{ App::getLocale() == 'ar' ? '' : 'd-none' }}">
                                                @if (App::getLocale() != 'ar')
                                                    :
                                                @endif
                                            </span>
                                            @lang('Pips Value')
                                            <span class="{{ App::getLocale() == 'ar' ? 'd-none' : '' }}">
                                                @if (App::getLocale() != 'ar')
                                                    :
                                                @endif
                                            </span>
                                        </small>
                                        <small class="text-themed d-block mb-1 pip-value">$0.00</small>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                                        <small class="text-themed d-block mb-1 required-margin-label">
                                            <span class="{{ App::getLocale() == 'ar' ? '' : 'd-none' }}">
                                                @if (App::getLocale() != 'ar')
                                                    :
                                                @endif
                                            </span>
                                            @lang('Required Margin')
                                            <span class="{{ App::getLocale() == 'ar' ? 'd-none' : '' }}">
                                                @if (App::getLocale() != 'ar')
                                                    :
                                                @endif
                                            </span>
                                        </small>
                                        <small class="text-themed d-block mb-1 required-margin-value">$0.00</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @if (is_mobile())
                            {{-- <div class="py-2 px-3">
                                <div class="d-flex justify-content-between">
                                    <img src="{{ asset('assets/images/extra_images/bear.png') }}" />
                                    <img src="{{ asset('assets/images/extra_images/bull.png') }}" class="mb-1" />
                                </div>
                                <div class="traders-trend">
                                    <div class="bear" style="width: 33%;"></div>
                                    <div class="bull" style="width: 67%;"></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="bear-pct">33%</span>
                                    <small class="traders-trend-title">@lang('Traders Trend')</small>
                                    <span class="bull-pct">67%</span>
                                </div>
                            </div> --}}
                        @endif
                    </div>
                    <div class="modal-footer">
                        @auth
                            <button class="d-none btn-modal-sell btn btn--danger w-100 btn--sm sell-btn" type="submit"
                                id="sellButton" data-orderside="2"
                                style="{{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                                <span
                                    style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('SELL')</span>
                                <input type="number" step="any" class="form--control style-three sell-rate"
                                    name="sell_rate" id="sell-rate" style="display: none;">
                                <span id="sellSpan" style="color:white;display: block"></span>
                            </button>
                            <div style="margin: 0 2px;"></div>
                            <button class="d-none btn-modal-buy btn btn--base-two w-100 btn--sm buy-btn" type="submit"
                                id="buyButton" data-orderside="1"
                                style="color: white !important; {{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                                <span
                                    style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('BUY')</span>
                                <input type="number" step="any" class="form--control style-three buy-rate"
                                    name="buy_rate" id="buy-rate" style="display: none;">
                                <span id="buySpan" style="color:white;display: block"></span>
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        @if ($view_portfolio)
            <div class="summary-container pb-0">
                <h2 class="h-title p-0 mb-0 border-0">@lang('Portfolio')</h2>
                <h2 class="p-0 ch5"></h2>
                <div class="portfolio-item">
                    <div class="label p-0">@lang('Balance')</div>
                    <div class="dots"></div>
                    @auth
                        <div class="value-box {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}">
                            {{ showAmount(@$marketCurrencyWallet->balance) }} $</div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>

                <div class="portfolio-item">
                    <div class="label">@lang('Equity')</div>
                    <div class="dots"></div>
                    @auth
                        <div class="value-box" id="equity-span"></div>
                    @else
                        <div class="value-box" id="equity-span">00000</div>
                    @endauth
                </div>

                <div class="portfolio-item">
                    <div class="label">@lang('P/L')</div>
                    <div class="dots"></div>
                    @auth
                        <div class="value-box" id="pl-span"></div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>

                <div class="portfolio-item">
                    <div class="label">@lang('Free Margin')</div>
                    <div class="dots"></div>
                    @auth
                        <div class="value-box" id="free-margin-span">0</div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>

                <div class="portfolio-item">
                    <div class="label">@lang('Used Margin')</div>
                    <div class="dots"></div>
                    @auth
                        <span id="used-margin-span" class="">0</span>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>

                <div class="portfolio-item">
                    <div class="label">@lang('Credit')</div>
                    <div class="dots"></div>
                    @auth
                        <span id="credit-span {{ @$marketCurrencyWallet->credit < 0 ? 'text-danger' : 'text-success' }}">
                            <label class=" {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}">
                                {{ showAmount(@$marketCurrencyWallet->credit) }} $
                            </label>
                        </span>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>

                <div class="portfolio-item d-none">
                    <div class="label">ST Level ({{ number_format($pair->level_percent, 0) }}%)</div>
                    <div class="dots"></div>
                    @auth
                        <div class="value-box" id="level-span"></div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>

                <div class="portfolio-item p-0 m-0">
                    <div class="label">@lang('Margin Level')</div>
                    <div class="dots"></div>
                    @auth
                        <div class="value-box" id="margin_level_span"></div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
                <h2 class="mb-1 p-0 ch1"></h2>
            </div>

            <h2 class="p-0 ch5"></h2>

            <div class="trading-table__mobile pt-0" style="margin-top: 0px;margin-bottom:80px;">
                <div class="summary-container pt-0">
                    <div
                        class="positions-header p-0 m-0 align-items-end @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <h2 class="border-0 p-0 mb-0 h-title">@lang('Positions')</h2>
                        <label class="ellipsis-menu">•••</label>
                    </div>

                    <h2 class="mb-1 p-0 ch5"></h2>

                    <table id="tablesOrder" style="display: inline-table;">
                        <tbody class="order-list-body">
                            <!-- Table content goes here -->
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @else
        <div class="buy-sell__wrapper px-1 pb-0">
            <div class="@if (is_mobile()) d-flex justify-content-between mb-3 @endif">
                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('Balance')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span class="avl-market-cur-wallet text-themed" id="balance_span">
                                <label
                                    class=" {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ showAmount(@$marketCurrencyWallet->balance) }} $
                                </label>
                            </span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}
                <div class="metric-row rounded-lg px-2 d-flex align-items-center justify-content-between @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-green-500 animate-pulse-slow"></div>
                        <span class="text-gray-400 text-sm">@lang('Balance')</span>
                    </div>
                    @auth
                        <span class="avl-market-cur-wallet text-themed {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}" id="balance_span">
                            {{ showAmount(@$marketCurrencyWallet->balance) }} $
                        </span>
                    @else
                        <span class="text-white font-medium">00000</span>
                    @endauth
                </div>

                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('Equity')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="equity-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}

                <!-- Equity -->
                <div class="d-flex align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-primary animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('Equity')</span>
                    </div>
                    <span class="fw-medium">
                        @auth
                            <span id="equity-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>

                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('Bonus')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span
                                id="bonus-span {{ @$marketCurrencyWallet->bonus < 0 ? 'text-danger' : 'text-success' }}">
                                <label
                                    class=" {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ showAmount(@$marketCurrencyWallet->Bonus) }} $
                                    </labe>
                            </span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}
                {{-- <div class="d-flex align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-purple animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('Bonus')</span>
                    </div>
                    <span class="fw-medium">
                        @auth
                            <span
                                id="bonus-span {{ @$marketCurrencyWallet->bonus < 0 ? 'text-danger' : 'text-success' }}">
                                <label
                                    class=" {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ showAmount(@$marketCurrencyWallet->Bonus) }} $
                                    </labe>
                            </span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}

                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('Credit')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span
                                id="credit-span {{ @$marketCurrencyWallet->credit < 0 ? 'text-danger' : 'text-success' }}">
                                <label
                                    class=" {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ showAmount(@$marketCurrencyWallet->credit) }} $
                                </label>
                            </span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}
                <div class="d-flex align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-warning animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('Credit')</span>
                    </div>
                    <span class="fw-medium">
                        @auth
                            <span
                                id="credit-span {{ @$marketCurrencyWallet->credit < 0 ? 'text-danger' : 'text-success' }}">
                                <label
                                    class=" {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ showAmount(@$marketCurrencyWallet->credit) }} $
                                </label>
                            </span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
            </div>

            <!--<div class="flex-between mx-0 mt-1">-->
            <!--    <h7 class="buy-sell__title">@lang('Total')</h7>-->
            <!--    <span class="fs-12">-->
            <!--        <span id="total-span"></span>-->
            <!--    </span>-->
            <!--</div>-->

            <div class="@if (is_mobile()) d-flex justify-content-between mb-3 @endif">
                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('PL')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="pl-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}
                <div class="d-flex align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-danger animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('PL')</span>
                    </div>
                    <span class="value-down fw-medium">
                        @auth
                            <span id="pl-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>

                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('Used Margin')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="used-margin-span">0</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}
                <div class="d-flex align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-secondary animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('Used Margin')</span>
                    </div>
                    <span class="fw-medium">
                        @auth
                            <span id="used-margin-span">0</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>

                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('Free Margin')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="free-margin-span">0</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}
                <div class="d-flex align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-success animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('Free Margin')</span>
                    </div>
                    <span class="value-up fw-medium">
                        @auth
                            <span id="free-margin-span">0</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>

                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) d-none @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title">@lang('ST Level') ({{ number_format($pair->level_percent, 0) }}%)
                    </h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="level-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}

                <div class="d-flex d-none align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) d-none @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-info animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('ST Level') ({{ number_format($pair->level_percent, 0) }}%)</span>
                    </div>
                    <span class="text-info fw-medium">
                        @auth
                            <span id="level-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>

                {{-- <div
                    class="flex-between mx-0 mt-1 @if (is_mobile()) flex-column @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if (is_mobile()) font-size: 0.75rem @endif">
                        @lang('Margin Level')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="margin_level_span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div> --}}
                <div class="d-flex align-items-center justify-content-between metric-row rounded px-2 @if (is_mobile()) d-none @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                    <div class="d-flex align-items-center gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="status-dot bg-primary animate-pulse-slow"></div>
                        <span class="text-gray-400 small">@lang('Margin Level')</span>
                    </div>
                    <span class="text-info fw-medium">
                        @auth
                            <span id="margin_level_span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
            </div>
        </div>

        <div class="buy-sell__price buy-sell__price-web pt-1 pb-1 p-1">
            <div class="input--group group-two @if (App::getLocale() == 'ar') text-end @endif">
                <!--<span class="buy-sell__price-title fs-12">@lang('Lots')</span>-->
                <label for="id_label_single" class="@if (is_mobile()) d-flex justify-content-between @endif d-flex justify-content-between align-items-center">
                    <span class="text-themed mb-1" style="@if (is_mobile()) margin-right: 4px @endif">
                        <span class="@if (App::getLocale() != 'ar') d-none @endif">:</span>

                        <span for="">@lang('Volume in Lots')</span>

                        <span class="@if (App::getLocale() == 'ar') d-none @endif">:</span>
                    </span>
                    <select id="lot-size-select" class="form--control style-three lot-size-select" name="amount"
                        style="height: 60px; height: 100%; @if (is_mobile()) min-width: 70% !important @endif width:50px !important; width: 130px; min-width: unset !important;"
                        onchange="updateLotValues(this)" data-fee-status="{{ $fee_status }}">
                        @if ($lots && $lots->isNotEmpty())
                            @foreach ($lots as $lot)
                                @php
                                    // Remove unnecessary decimal places
                                    $lot_volume_display = $lot->lot_volume;
                                    // Check if the value is an integer
                                    if (floor($lot->lot_volume) == $lot->lot_volume) {
                                        // No decimal places for whole numbers between 1 and 10
                                        $lot_volume_display = number_format($lot->lot_volume, 0);
                                    } else {
                                        // Keep the decimal for other values but remove trailing zeros
                                        $lot_volume_display = rtrim(rtrim($lot->lot_volume, '0'), '.');
                                    }
                                @endphp
                                <option value="{{ $lot->lot_value }}" {{ $lot->selected == 1 ? 'selected' : '' }}>
                                    {{ $lot_volume_display }}</option>
                            @endforeach
                        @else
                            <p>No lots available</p>
                        @endif
                    </select>
                </label>
            </div>
        </div>

        <div class="buy-sell__price-web p-1">
            <ul class="p-0 m-0">
                <li class="d-flex">
                    {{-- <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1">
                                @if (App::getLocale() != 'ar')
                                    <span class="lot-label"></span>:
                                    <span class="lot-value"></span>
                                @else
                                    <span class="lot-value"></span>:
                                    <span class="lot-label"></span>
                                @endif
                            </small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <small class="text-themed d-block mb-1 lot-eq" id="lot-eq-fetch">
                                <span class="lot-eq-span">{{ $pair ? $pair->percent_charge_for_buy : '0' }}</span>
                                <span class="lot-currency">{{ @$pair->coin_name }}</span>
                            </small>
                        </div>
                    </div> --}}

                    <div class="d-flex justify-content-between align-items-center px-2 bg-secondary-2 rounded w-100 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="d-flex align-items-center @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                            <div class="status-dot bg-primary"></div>
                            <div class="text-muted small mx-1">
                                @if (App::getLocale() != 'ar')
                                    <span class="lot-label"></span>:
                                    <span class="lot-value"></span>
                                @else
                                    <span class="lot-value"></span>:
                                    <span class="lot-label"></span>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small">
                                <small class="text-themed d-block mb-1 lot-eq" id="lot-eq-fetch">
                                    <span class="lot-eq-span">{{ $pair ? $pair->percent_charge_for_buy : '0' }}</span>
                                    <span class="lot-currency">{{ @$pair->coin_name }}</span>
                                </small>
                                <small class="text-themed d-block mb-1 lot-eq2" id="lot-eq2-fetch">
                                    <span class="ll-size-span"></span> {{ @$pair->market_name }}
                                </small>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- <li class="d-flex mb-1 pb-1">
                    <div
                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1">&nbsp</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <small class="text-themed d-block mb-1 lot-eq2" id="lot-eq2-fetch"><span
                                    class="ll-size-span"></span> {{ @$pair->market_name }}</small>
                        </div>
                    </div>
                </li> --}}
                <li class="pt-1 @if (is_mobile()) d-flex @endif">
                    {{-- <div
                        class="d-flex w-100 flex-wrap align-items-center gap-2 @if (!is_mobile()) justify-content-between @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1 pip-label">
                                <span class="@if (App::getLocale() != 'ar') d-none @endif">:</span>
                                @lang('Pips Value')
                                <span class="@if (App::getLocale() == 'ar') d-none @endif">:</span>
                            </small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <small class="text-themed d-block mb-1 pip-value">$0.00</small>
                        </div>
                    </div> --}}
                    <div class="d-flex justify-content-between align-items-center py-1 px-2 bg-secondary-2 rounded w-100 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="d-flex align-items-center @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                            <div class="status-dot bg-success"></div>
                            <span class="text-muted small mx-1">  
                                <small class="text-themed d-block mb-1 pip-label">
                                    <span class="@if (App::getLocale() != 'ar') d-none @endif">:</span>
                                    @lang('Pips Value')
                                    <span class="@if (App::getLocale() == 'ar') d-none @endif">:</span>
                                </small>
                            </span>
                        </div>
                        <span class="small animate-value pip-value">$0.00</span>
                    </div>
                    {{-- <div
                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if (!is_mobile()) justify-content-between @endif @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1 required-margin-label">
                                <span class="@if (App::getLocale() != 'ar') d-none @endif">:</span>
                                @lang('Required Margin')
                                <span class="@if (App::getLocale() == 'ar') d-none @endif">:</span>
                            </small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <small class="text-themed d-block mb-1 required-margin-value">$0.00</small>
                        </div>
                    </div> --}}
                    <div class="d-flex justify-content-between align-items-center py-1 px-2 bg-secondary-2 rounded w-100 @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="d-flex align-items-center @if (App::getLocale() == 'ar') flex-row-reverse @endif">
                            <div class="status-dot bg-purple"></div>
                            <span class="text-muted small mx-1">  
                                <small class="text-themed d-block mb-1 required-margin-label">
                                    <span class="@if (App::getLocale() != 'ar') d-none @endif">:</span>
                                    @lang('Required Margin')
                                    <span class="@if (App::getLocale() == 'ar') d-none @endif">:</span>
                                </small>
                            </span>
                        </div>
                        <span class="small animate-value pip-value required-margin-value">$0.00</span>
                    </div>
                </li>
                <!--<li class="d-flex mt-1 pt-1">-->
                <!--    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if (App::getLocale() == 'ar') flex-row-reverse @endif">-->
                <!--        <div class="me-2">-->
                <!--            <small class="text-themed d-block mb-1 required-margin-label">-->
                <!--                <span class="@if (App::getLocale() != 'ar') d-none @endif">:</span>-->
                <!--                @lang('Required Margin')-->
                <!--                <span class="@if (App::getLocale() == 'ar') d-none @endif">:</span>-->
                <!--            </small>-->
                <!--            {{-- <h6 class="mb-0">Send money</h6> --}}-->
                <!--        </div>-->
                <!--        <div class="user-progress d-flex align-items-center gap-1">-->
                <!--            {{-- <h6 class="mb-0">+82.6</h6> <span class="text-muted">USD</span> --}}-->
                <!--            <small class="text-themed d-block mb-1 required-margin-value">$0.00</small>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</li>-->
            </ul>
        </div>
    @endif




    {{-- total price --}}
    <div style="margin-top: 10px;"></div>

    <div class="trading-bottom__button py-0">
        <!--<div class="mx-3 my-4">-->
        @auth
            @if (!is_mobile())
                <button class="btn btn--danger w-100 btn--sm sell-btn" type="submit" id="sellButton" data-orderside="2"
                    style="{{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                    <span
                        style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('SELL')</span>
                    <input type="number" step="any" class="form--control style-three sell-rate" name="sell_rate"
                        id="sell-rate" style="display: none;">
                    <span id="sellSpan" style="color:white;display: block"></span>
                </button>
                <div style="margin: 0 2px;"></div>
                <button class="btn btn--base-two w-100 btn--sm buy-btn" type="submit" id="buyButton" data-orderside="1"
                    style="color: white !important; {{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                    <span
                        style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('BUY')</span>
                    <input type="number" step="any" class="form--control style-three buy-rate" name="buy_rate"
                        id="buy-rate" style="display: none;">
                    <span id="buySpan" style="color:white;display: block"></span>
                </button>
            @else
                @if (!$view_portfolio)
                    <button class="btn btn--danger w-100 btn--sm btn-sell-button" data-type="sell" type="button"
                        id="" data-orderside="2"
                        style="{{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                        @lang('SELL')
                    </button>
                    <div style="margin: 0 2px;"></div>
                    <button class="btn btn--base-two w-100 btn--sm btn-buy-button" data-type="buy" type="button"
                        id="" data-orderside="1"
                        style="color: white !important; {{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                        @lang('BUY')
                    </button>
                @else
                    <!--<div class="m-auto" id="portfolio-content-2">-->
                    <!--    <button class="btn btn--secondary w-100 btn--md btn-modify-button" data-type="modify" type="button" id="" data-orderside="2" style="{{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">-->
                    <!--        @lang('Modify')-->
                    <!--    </button>-->
                    <!--</div>-->
                @endif
            @endif
        @else
            <div class="btn login-btn w-100 btn--sm">
                <a href="{{ route('user.login') }}">@lang('Login')</a>
                <span>@lang('or')</span>
                <a href="{{ route('user.register') }}">@lang('Register')</a>
            </div>

            <div class="mx-1"></div>

            <div class="btn login-btn w-100 btn--sm">
                <a href="{{ route('user.login') }}">@lang('Login')</a>
                <span>@lang('or')</span>
                <a href="{{ route('user.register') }}">@lang('Register')</a>
            </div>
        @endauth
    </div>

    {{-- <x-flexible-view :view="$activeTemplate . 'trade.traders_trend'" /> --}}
</form>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            updateLotValues(document.querySelector(".lot-size-select"));

            function calculateBuyValue(buyPrice) {
                // return (buyPrice * `{{ @$pair->spread }}`) + buyPrice; // old formula
                let spread = {{ @$pair->spread }}; // Get spread from Laravel
                return buyPrice + spread; // Spread as fixed amount
            }

           function calculateSellValue(sellPrice) {
                let spread = {{ @$pair->spread }}; // Get spread from Laravel
                return sellPrice - spread; // Subtract the spread from the sell price
            }

            function updateSpanValues(currentPrice) {
                let coin_name = `{{ @$pair->type }}`;
                let coin_symbol = `{{ @$pair->symbol }}`;

                var curr_price = parseFloat((coin_name === 'Crypto' || coin_name === 'COMMODITY' || coin_name ===
                    'INDEX' ? parseFloat(currentPrice.replace(/,/g, '')).toFixed(5) : formatWithPrecision(
                        currentPrice)));

                var buyValue = calculateBuyValue(curr_price);
                var sellValue = calculateSellValue(curr_price);

                document.title = `${curr_price} {{ @$pair->symbol }}`;

                let sellSpan = document.getElementById("sellSpan");
                let buySpan = document.getElementById("buySpan");

                let sellRate = document.querySelector(".sell-rate");
                let buyRate = document.querySelector(".buy-rate");

                // let buyDecimal = countDecimalPlaces(sellValue);
                let buyDecimal = countDecimalPlaces(currentPrice);

                let adjustedBuyValue = buyValue;

                if (coin_symbol === 'GOLD') {
                    if (buyDecimal == 0) {
                        // sellSpan.innerText  = removeTrailingZeros(sellValue);
                        // buySpan.innerText   = removeTrailingZeros(buyValue);
                        sellSpan.innerText = sellValue;
                        buySpan.innerText = buyValue;
                        adjustedBuyValue = removeTrailingZeros(buyValue);
                    } else {
                        // sellSpan.innerText  = removeTrailingZeros(sellValue.toFixed(2));
                        // buySpan.innerText   = removeTrailingZeros(buyValue.toFixed(buyDecimal));
                        sellSpan.innerText = sellValue.toFixed(2);
                        buySpan.innerText = buyValue.toFixed(buyDecimal);
                        adjustedBuyValue = removeTrailingZeros(buyValue.toFixed(buyDecimal));
                    }
                } else {
                    if (buyDecimal == 0 && coin_name === 'Crypto') {
                        buySpan.innerText = Math.floor(buyValue);
                        sellSpan.innerText = sellValue;
                        adjustedBuyValue = buyValue;

                    } else {
                        // buySpan.innerText   = removeTrailingZeros((coin_name === 'Crypto' ? buyValue.toFixed(buyDecimal) : buyValue.toFixed(buyDecimal)));
                        // sellSpan.innerText  = removeTrailingZeros((coin_name === 'Crypto' ? sellValue.toFixed(5) : sellValue.toFixed(5)));
                        buySpan.innerText = (coin_name === 'Crypto' ? buyValue.toFixed(buyDecimal) : buyValue
                            .toFixed(buyDecimal));
                        sellSpan.innerText = (coin_name === 'Crypto' ? sellValue.toFixed(buyDecimal) : sellValue.toFixed(buyDecimal));
                        adjustedBuyValue = (coin_name === 'Crypto' ? buyValue.toFixed(buyDecimal) : buyValue
                            .toFixed(buyDecimal));
                    }

                }


                buyRate.value = adjustedBuyValue;
                sellRate.value = sellValue;

                setTimeout(function() {
                    buySpan.style.fontWeight = 'normal';
                    sellSpan.style.fontWeight = 'normal';
                }, 100);
            }

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

            function fetchSymbolCurrentPrice() {
                let actionUrl =
                    "{{ route('trade.current-price', ['type' => @$pair->type, 'symbol' => @$pair->symbol]) }}";
                let buySpan = $('#buySpan');
                let sellSpan = $('#sellSpan');
                $.ajax({
                    url: actionUrl,
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    beforeSend: function() {
                        if (buySpan.text() === '') buySpan.append(
                            ` <i class="fa fa-spinner fa-spin"></i>`);
                        if (sellSpan.text() === '') sellSpan.append(
                            ` <i class="fa fa-spinner fa-spin"></i>`);
                    },
                    complete: function() {
                        if (buySpan.text() === '') buySpan.find(`.fa-spin`).remove();
                        if (sellSpan.text() === '') sellSpan.find(`.fa-spin`).remove();
                    },
                    success: function(resp) {
                        let current_price = resp.current_price;
                        updateSpanValues(current_price);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching order history: ", error);
                    }
                });
            }

            setInterval(function func() {
                fetchSymbolCurrentPrice();
                updateLLSize();

                let level = document.querySelector('#level-span').innerText.replace(/ USD/g, "");
                let equity = document.querySelector('#equity-span').innerText.replace(/ USD/g, "");

                if (isLevelMoreThanOrEqualToEquity(level, equity)) {
                    closeAllOpenTrade(parseFloat(level), parseFloat(equity));
                }

                return func;
            }(), 1000);

            function customUpdateTrend(type) {
                //Update trend 
                const bear = document.querySelector('.bear');
                const bull = document.querySelector('.bull');
                const bearPct = document.querySelector('.bear-pct');
                const bullPct = document.querySelector('.bull-pct');

                let val1 = Math.floor(Math.random() * 101);
                let val2 = 100 - val1;

                if (type === "buy") {
                    if (val1 > val2) {
                        bullPercentage = val1;
                        bearPercentage = val2;
                    } else {
                        bullPercentage = val2;
                        bearPercentage = val1;
                    }
                } else {
                    if (val1 < val2) {
                        bullPercentage = val1;
                        bearPercentage = val2;
                    } else {
                        bullPercentage = val2;
                        bearPercentage = val1;
                    }
                }

                bear.style.width = bearPercentage + '%';
                bull.style.width = bullPercentage + '%';
                bearPct.textContent = bearPercentage + '%';
                bullPct.textContent = bullPercentage + '%';
            }

            $(document).on('click', '.btn-sell-button, .btn-buy-button', function() {
                const type = $(this).data('type');

                // Check here the highest percentage
                if (type === "buy") {
                    $('.btn-modal-buy').removeClass('d-none');
                    $('.btn-modal-sell').addClass('d-none');
                } else {
                    $('.btn-modal-sell').removeClass('d-none');
                    $('.btn-modal-buy').addClass('d-none');
                }

                customUpdateTrend(type);

                $('#modalBuySell').modal('show');
            });

        });

        function updateLotValues(select) {
            var selectedOption = select.options[select.selectedIndex];
            var selectedLotText = selectedOption.textContent;
            var selectedLot = select.value;
            var lotLabel = document.querySelector('.lot-label');

            lotLabel.innerText = "@lang('Lot')";
            document.querySelector('.lot-value').innerText = selectedLotText.trim();

            let lotValue = {{ @$pair->percent_charge_for_buy }};
            let lotEquivalent = parseFloat(lotValue) * parseFloat(selectedLotText);
            document.querySelector('.lot-eq-span').innerText = lotEquivalent;

            updateLLSize();

            if (select.dataset.feeStatus == 1) {
                updatePipValue(select);
            }
        }

        // function updateLLSize() {
        //     let lotEquivalent = parseFloat(document.querySelector('.lot-eq-span').innerText);

        //     let currentPrice = document.querySelector("#sellSpan").innerText;
        //     let llSizeVal = parseFloat(currentPrice) * lotEquivalent;
        //     let llSize = parseInt(llSizeVal) >= 0 ? llSizeVal : 0;

        //     document.querySelector('.ll-size-span').innerText = llSize.toFixed();

        //     let leverage = parseFloat({{ @$pair->percent_charge_for_sell }} || 0);
        //     let required_margin = llSize / leverage;
        //     // document.querySelector('.required-margin-value').innerText = `${formatWithPrecision1(required_margin)} USD`;
        //     document.querySelector('.required-margin-value').innerText =
        //         `${formatWithPrecision1(required_margin)} {{ @$pair->market_name }}`;
        // }

        function updateLLSize() {
            let lotEquivalent   = parseFloat(document.querySelector('.lot-eq-span').innerText);
            
            let currentPrice    = document.querySelector("#sellSpan").innerText;
            let llSizeVal       = parseFloat(currentPrice) * lotEquivalent;
            let llSize          = parseInt(llSizeVal) >= 0 ? llSizeVal : 0;

            document.querySelector('.ll-size-span').innerText = llSize.toFixed();

            let leverage        = parseFloat({{ @$pair->percent_charge_for_sell }} || 0);
            let required_margin = llSize / leverage;
            document.querySelector('.required-margin-value').innerText = `${formatWithPrecision1(required_margin)} USD`;
        }

        // function updateLLSize() {
        //     let lotEquivalent = parseFloat(document.querySelector('.lot-eq-span').innerText);
        //     let checkCurr = document.querySelector('.lot-currency').innerText;

        //     let currentPrice = document.querySelector("#sellSpan").innerText;
        //     let llSizeVal = parseFloat(currentPrice) * lotEquivalent;
        //     let llSize = parseInt(llSizeVal) >= 0 ? llSizeVal : 0;


        //     let leverage = parseFloat({{ @$pair->percent_charge_for_sell }} || 0);
        //     let required_margin = llSize / leverage;

        //     // document.querySelector('.ll-size-span').innerText = `${formatWithPrecision1(required_margin)}`;

        //     document.querySelector('.ll-size-span').innerText = formatWithPrecision1(llSize);

        //     if (checkCurr !== "USD") {
        //         lotEquivalent = parseFloat(document.querySelector('.ll-size-span').innerText);
        //     }

        //     document.querySelector('.required-margin-value').innerText = `${lotEquivalent} USD`;

        //     // document.querySelector('.required-margin-value').innerText = `${formatWithPrecision1(required_margin)} {{ @$pair->market_name }}`;
        // }

        function updatePipValue(select) {
            let pipValueElement = document.querySelector('.pip-value');
            pipValueElement.innerText = '$ ' + select.value;
        }

        function removeTrailingZeros(number) {
            var numberString = number.toString();
            var trimmedNumberString = numberString.replace(/\.?0+$/, '');
            var trimmedNumber = parseFloat(trimmedNumberString);

            if (Number.isInteger(trimmedNumber)) {
                return trimmedNumber.toFixed(2);
            }

            return trimmedNumber;
        }

        function isLevelMoreThanOrEqualToEquity() {
            let level = parseFloat(document.querySelector('#level-span').innerText.replace(/ USD/g, ""));
            let equity = parseFloat(document.querySelector('#equity-span').innerText.replace(/ USD/g, ""));

            return level >= equity;
        }

        function closeAllOpenTrade(level, equity) {
            //
        }
    </script>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function isValidNumberOrDecimal(num) {
            return /^-?\d*\.?\d+$/.test(num);
        }
    </script>
    @if (is_mobile())
        <script>
            $(document).ready(() => {
                $('#amount').select2({
                    tags: true,
                    height: 'resolve',
                    width: 'resolve',
                    dropdownParent: $('#modalBuySell'),
                    createTag: function(params) {
                        if (!isValidNumberOrDecimal(params.term)) {
                            return null;
                        }

                        return {
                            id: (parseFloat(params.term) * 10).toFixed(2),
                            text: params.term,
                            newTag: true
                        }
                    }
                });
            });
        </script>
    @else
        <script>
            $(document).ready(() => {
                $('#amount').select2({
                    tags: true,
                    height: 'resolve',
                    width: 'resolve',
                    createTag: function(params) {

                        if (!isValidNumberOrDecimal(params.term)) {
                            return null;
                        }

                        return {
                            id: (parseFloat(params.term) * 10).toFixed(2),
                            text: params.term,
                            newTag: true
                        }
                    }
                });



            });
        </script>
    @endif
@endpush

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Existing Select2 Styles */
        .progress {
            height: 9px;
        }

        .select2-container {
            height: 100% !important;
            /* min-width: 100% !important; */
            width:130px !important;
        }

        .selection {
            min-width: 100% !important;
        }

        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }

        .select2-selection.select2-selection--single {
            color: hsl(var(--white));
            background-color: var(--pane-bg);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: hsl(var(--white));
        }

        .select2-search--dropdown .select2-search__field {
            background-color: #0d1e23;
            color: white;
        }

        .select2-search--dropdown {
            background-color: #0d1e23;
        }

        .select2-results__option--selectable {
            background-color: #0d1e23;
            color: white;
        }

        .select2-container--default .select2-results__option--selected {
            background-color: #5897fb;
        }

        .select2-container--open {
            min-width: 0 !important;
            min-height: 0 !important;
        }

        @media screen and (max-width: 575px) {
            .select2-container {
                min-width: 31% !important;
            }

            .select2-selection.select2-selection--single {
                width: 100%;
            }
        }

        /* Accordion Styles */
        @media (max-width: 578px) {
            .accordion-button {
                font-size: 0.6rem;
                /* Smaller text */
            }

            .accordion-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .accordion-body {
                font-size: 0.6rem;
                /* Smaller text for the accordion body */
            }

            .d-flex {
                display: flex;
                flex-wrap: nowrap;
                /* Keep elements in one line */
            }
        }

        /* New Accordion Arrow Styles */
        .accordion-button {
            position: relative;
            padding-right: 2rem;
            /* Space for the arrow */
        }

        .accordion-icon {
            position: absolute;
            right: 1rem;
            font-size: 1.25rem;
            color: white;
            /* Ensure the icon is visible */
        }

        .accordion-button:not(.collapsed) .accordion-icon i {
            transform: rotate(180deg);
            /* Rotate arrow when expanded */
        }

        .accordion-button.collapsed .accordion-icon i {
            transform: rotate(0deg);
            /* Reset to default arrow direction when collapsed */
        }

        .accordion-button .accordion-icon i {
            transition: transform 0.2s ease;
            /* Smooth animation for the arrow */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #1b2b34;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: start;
            align-items: center;
            height: 100vh;
        }

        [data-theme=dark] .trading-right {
            background-color: #0f1821;
        }

        .trading-right {
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            /* Full width */
            max-width: 100%;
            /* Max width 100% for larger devices */
        }

        .summary-container,
        .tab-inner-wrapper {
            background-color: #0f1821;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            /* Full width */
            max-width: 100%;
            /* Max width 100% for larger devices */
            /* margin-bottom: 80px; */
        }

        table {
            width: 100% !important;
            /* Ensure table takes 100% width */
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            color: white;
        }

        th {
            background-color: #2f2f2f;
            font-weight: bold;
        }

        /* Responsive for smaller screens */
        @media (max-width: 575px) {
            .summary-container {
                width: 100%;
                /* Full width for smaller screens */
            }

            table {
                width: 100% !important;
                /* Ensure full width on small screens */
                display: block;
                overflow-x: auto;
                /* Enable horizontal scrolling */
            }

            th,
            td {
                font-size: 12px;
                /* Smaller font for small screens */
            }
        }

        @media (max-width: 320px) {
            .summary-container {
                width: 100%;
                /* Full width for very small screens */
            }
        }

        .summary-container h2 {
            font-size: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #3c4a54;
            padding-bottom: 10px;
            color: #f0f0f0;
        }

        .summary-item {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
        }

        .summary-item:nth-child(1) {
            background-color: #7d7d7d;
        }

        .summary-item:nth-child(2) {
            background-color: #6e6e6e;
        }

        .summary-item:nth-child(3) {
            background-color: #5f5f5f;
        }

        .summary-item:nth-child(4) {
            background-color: #4f4f4f;
        }

        .summary-item:nth-child(5) {
            background-color: #3f3f3f;
        }

        .summary-item:nth-child(6) {
            background-color: #2f2f2f;
        }

        .summary-item:nth-child(7) {
            background-color: #6e6e6e;
        }

        .summary-item:nth-child(8) {
            background-color: #4f4f4f;
        }

        .label,
        .value-box,
        .c-icon,
        .portfolio-item,
        #tablesOrder td,
        #tablesOrder tr,
        #tablesOrder {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 16px;
        }

        #tablesOrder td,
        #tblHistory td {
            padding: 0 !important;
        }

        td div div:first-child div:first-child span:first-child {
            font-weight: bold;
        }

        td div div:first-child div:first-child span:last-child,
        td div div:first-child div:first-child span:nth-child(2) {
            color: #3b8bfb !important;
            font-weight: 400;
        }

        td div div:first-child div:last-child span {
            color: #97a6b5;
        }

        .negative,
        .text-danger {
            color: #c2424b !important;
        }

        .text-primary {
            color: #3b8bfb !important;
        }

        .label {
            font-size: 16px;
            color: white;
        }

        .value-box {
            font-size: 16px;
        }

        .c-icon {
            width: 30px;
            height: auto;
            border-radius: 50%;
            object-fit: cover;
        }

        /* uncomment this tomorrow */
        .portfolio-item {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .portfolio-item .label,
        .portfolio-item .value {
            padding: 0 5px;
            position: relative;
            z-index: 1;
        }

        /* This css is for displaying dotted lines */

        .dots {
            flex-grow: 1;
            height: 8px;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.2) 1px, transparent 4px);
            background-size: 10px;
            opacity: 0.2;
            margin: 0 20px;
        }

        [data-theme=light] .dots {
            background-image: radial-gradient(circle, rgb(0 0 0 / 20%) 1px, transparent 4px);
        }


        .positions-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            /* border-bottom: 1px solid #2f2f2f;  */
            /* padding-bottom: 5px; */
        }

        .h-title {
            font-size: 16px !important;
            color: #97a6b5 !important;
        }

        .ellipsis-menu {
            font-size: 16px;
            color: white;
            cursor: pointer;
            padding-right: 10px;
            /* Adjust as needed for spacing */
        }

        .ch5 {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
        }

        .ch1 {
            margin-top: 5px !important;
            margin-bottom: 0 !important;
        }

        #tablesOrder .clickable-row {
            border-color: #3c4a54 !important;
        }
    </style>

    {{-- 1/17/2025 --}}
    <style>
        .neon-border {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
        }

        .neon-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #00f7ff, #ff00f7);
            z-index: -1;
            filter: blur(8px);
            opacity: 0.3;
        }

        .glass-panel {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .value-up { color: #00f7a0; }
        .value-down { color: #ff3b69; }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .metric-row {
            background: rgba(17, 24, 39, 0.4);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            height: 2rem;
        }

        .metric-row:hover {
            background: rgba(17, 24, 39, 0.6);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .bg-green-500{
            background-color: rgb(34 197 94 / var(--tw-bg-opacity, 1));
        }	

        .text-gray-400, .lot-label, .lot-value {
            color: #ffffff;
        }

        .bg-purple{
            background-color: rgb(168 85 247 / var(--tw-bg-opacity, 1));
        }

        .trading-panel {
            background: linear-gradient(145deg, rgba(26, 31, 43, 0.95), rgba(20, 24, 33, 0.95));
            width: 240px;
            padding: 12px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                        0 2px 4px -1px rgba(0, 0, 0, 0.06),
                        inset 0 1px 1px rgba(255, 255, 255, 0.05);
        }

        .animate-value {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .bg-secondary-2{
            background: rgba(17, 24, 39, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        [data-theme=light] .metric-row, [data-theme=light] .bg-secondary-2 {
            background-color: white;
            border-bottom: 1px solid #000;
        }

        [data-theme=light] .rounded{
            border-radius: 0% !important;
        }

        [data-theme=light] .animate-value, 
        [data-theme=light] .text-gray-400, 
        [data-theme=light] .lot-label,
        [data-theme=light] .lot-value{
            color: #000000 !important;
        }
    </style>

    @if( !is_mobile() )
        <style>
            .trading-chart{
                height:600px;
            }

            .bear-pct, .bull-pct{
                font-size:12px !important;
            }
        </style>   
    @endif
@endpush
