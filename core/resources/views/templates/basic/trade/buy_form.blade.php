@php
    $meta                 = (object) $meta;
    $pair                 = @$meta->pair;
    $marketCurrencyWallet = @$meta->marketCurrencyWallet;
    $screen               = @$meta->screen;
    $percentChargeForBuy  = @$pair->percent_charge_for_buy;
    $order_count          = @$meta->order_count;
    $lots                 = @$meta->lots;
    $fee_status           = @$meta->fee_status;
    $view_portfolio       = @$meta->view_portfolio;
    $jsonData             = file_get_contents(resource_path('data/data1.json'));
    $data                 = json_decode($jsonData, true);
@endphp
<!--<h3 class="px-4 mt-3 text-white">Portfolio </h3>-->
<form class="buy-sell-form buy-sell @if(@$meta->screen=='small') buy-sell-one @endif buy--form" method="POST">
    @csrf
    @if ($meta->screen=='small')
        <span class="sidebar__close"><i class="fas fa-times"></i></span>
    @endif
    <input type="hidden" name="order_side" value="{{ Status::BUY_SIDE_ORDER }}">
    <input type="hidden" name="order_type" value="{{ Status::ORDER_TYPE_LIMIT }}">

    @if (is_mobile())
    <div class="modal fade" id="modalBuySell" tabindex="-1" aria-labelledby="fullScreenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen"> 
            <div class="modal-content">
                <div class="modal-header d-flex">
                   <div class="d-flex align-items-center">
                        <span class="fw-bold text-dark">{{$pair->symbol}}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#0d1e23;">
                    <div class="buy-sell__price pt-1 pb-1">
                        <div class="input--group group-two @if(App::getLocale() == 'ar') text-end @endif">
                            <!--<span class="buy-sell__price-title fs-12">@lang('Lots')</span>-->
                            <label for="id_label_single" class="@if(is_mobile()) d-flex justify-content-between @endif">
                                <span class="text-themed mb-1" style="@if(is_mobile()) margin-right: 4px @endif">
                                    @lang('Volume in Lots')
                                </span>
                               <select id="lot-size-select" class="form--control style-three lot-size-select" name="amount" style="height: 60px; width: 50px; @if(is_mobile()) min-width: 70% !important @endif" onchange="updateLotValues(this)" data-fee-status="{{$fee_status}}">
                                    @if($lots && $lots->isNotEmpty())
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
                                            <option value="{{ $lot->lot_value }}" {{$lot->selected == 1 ? 'selected' : ''}}>{{ $lot_volume_display }}</option>
                                        @endforeach
                                    @else
                                        <p>No lots available</p>
                                    @endif
                                </select>

                            </label>
                            <small class="text-themed d-block mb-1 d-none">
                                <span class="lot-label"></span>
                                <span class="lot-value"></span>
                            </small>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="lot-eq-span">{{ $pair ? $pair->percent_charge_for_buy : '0' }}</span> 
                                <span class="lot-currency ms-2">{{ @$pair->coin_name }}</span> 
                            </div> 
                            <div>
                                <span class="ll-size-span"></span> 
                                <span>{{ @$pair->market_name }}</span> 
                            </div> 
                        </div>
                    </div>
                    <div class="mx-4 mb-3">
                        <ul class="p-0 m-0">
                            <li class="mt-1 pt-1 d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <small class="text-themed d-block mb-1 pip-label">
                                        <span class="{{ App::getLocale() == 'ar' ? '' : 'd-none' }}">:</span>
                                        @lang('Pips Value')
                                        <span class="{{ App::getLocale() == 'ar' ? 'd-none' : '' }}">:</span>
                                    </small>
                                    <small class="text-themed d-block mb-1 pip-value">$0.00</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <small class="text-themed d-block mb-1 required-margin-label">
                                        <span class="{{ App::getLocale() == 'ar' ? '' : 'd-none' }}">:</span>
                                        @lang('Required Margin')
                                        <span class="{{ App::getLocale() == 'ar' ? 'd-none' : '' }}">:</span>
                                    </small>
                                    <small class="text-themed d-block mb-1 required-margin-value">$0.00</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @if( is_mobile() )
                        <div class="py-2 px-3">
                            <div class="d-flex justify-content-between">
                                <img src="{{ asset('assets/images/extra_images/bear.png') }}"/>
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
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @auth
                        <button class="d-none btn-modal-sell btn btn--danger w-100 btn--sm sell-btn" type="submit" id="sellButton" data-orderside="2" style="{{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                            <span style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('SELL')</span>
                            <input type="number" step="any" class="form--control style-three sell-rate" name="sell_rate" id="sell-rate" style="display: none;"> 
                            <span id="sellSpan" style="color:white;display: block"></span>
                        </button>
                        <div style="margin: 0 2px;"></div>
                        <button class="d-none btn-modal-buy btn btn--base-two w-100 btn--sm buy-btn" type="submit" id="buyButton" data-orderside="1" style="color: white !important; {{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                            <span style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('BUY')</span>
                            <input type="number" step="any" class="form--control style-three buy-rate" name="buy_rate" id="buy-rate" style="display: none;"> 
                            <span id="buySpan" style="color:white;display: block"></span>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

        @if( $view_portfolio )
            <!--<div class="p-4" id="portfolio-content-2" style="background-color: #0d1e23; color: #fff; font-size: 0.75rem;">-->
            <!--     Accordion Body with the rest of the details -->
            <!--    <div class="d-flex justify-content-between mt-1">-->
            <!--        <h7 class="buy-sell__title">@lang('Balance')</h7>-->
            <!--        <span class="">-->
            <!--            @auth-->
            <!--                <span class="text-themed">{{ showAmount(@$marketCurrencyWallet->balance) }} USD</span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->

            <!--    <div class="d-flex justify-content-between mt-1">-->
            <!--        <h7 class="buy-sell__title">@lang('Equity')</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="equity-span"></span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->
                
            <!--    <div class="d-flex justify-content-between mt-2">-->
            <!--        <h7 class="buy-sell__title">@lang('P/L')</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="pl-span"></span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->

            <!--    <div class="d-flex justify-content-between mt-2">-->
            <!--        <h7 class="buy-sell__title">@lang('Bonus')</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="bonus-span">{{ showAmount(@$marketCurrencyWallet->bonus) }} USD</span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->

            <!--    <div class="d-flex justify-content-between mt-2">-->
            <!--        <h7 class="buy-sell__title">@lang('Credit')</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="credit-span">{{ showAmount(@$marketCurrencyWallet->credit) }} USD</span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->

            <!--    <div class="d-flex justify-content-between mt-2">-->
            <!--        <h7 class="buy-sell__title">@lang('Free Margin')</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="free-margin-span">0</span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->
            <!--    <div class="d-flex justify-content-between mt-2">-->
            <!--        <h7 class="buy-sell__title">@lang('Used Margin')</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="used-margin-span">0</span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->

            <!--    <div class="d-none mt-2">-->
            <!--        <h7 class="buy-sell__title">@lang('ST Level') ({{ number_format($pair->level_percent, 0) }}%)</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="level-span"></span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->

            <!--    <div class="d-flex justify-content-between mt-2">-->
            <!--        <h7 class="buy-sell__title">@lang('Margin Level')</h7>-->
            <!--        <span class="fs-12 text-themed">-->
            <!--            @auth-->
            <!--                <span id="margin_level_span"></span>-->
            <!--            @else-->
            <!--                <span>00000</span>-->
            <!--            @endauth-->
            <!--        </span>-->
            <!--    </div>-->
            <!--</div>-->
            
           <div class="summary-container">
                <h2>Portfolio</h2>
                <div class="summary-item">
                    <div class="label">Balance</div>
                    @auth
                        <div class="value-box">{{ showAmount(@$marketCurrencyWallet->balance) }} $</div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item">
                    <div class="label">Equity</div>
                    @auth
                        <div class="value-box" id="equity-span"></div>
                    @else
                        <div class="value-box" id="equity-span">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item">
                    <div class="label">P/L</div>
                    @auth
                        <div class="value-box" id="pl-span"></div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item">
                    <div class="label">Bonus</div>
                    @auth
                        <div class="value-box">{{ showAmount(@$marketCurrencyWallet->bonus) }} $</div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item">
                    <div class="label">Credit</div>
                    @auth
                        <div class="value-box">{{ showAmount(@$marketCurrencyWallet->credit) }} $</div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item">
                    <div class="label">Free Margin</div>
                    @auth
                        <div class="value-box" id="free-margin-span">0</div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item">
                    <div class="label">Used Margin</div>
                    @auth
                        <div class="value-box" id="used-margin-span">0</div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item d-none">
                    <div class="label">ST Level ({{ number_format($pair->level_percent, 0) }}%)</div>
                    @auth
                        <div class="value-box" id="level-span"></div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            
                <div class="summary-item">
                    <div class="label">Margin Level</div>
                    @auth
                        <div class="value-box" id="margin_level_span"></div>
                    @else
                        <div class="value-box">00000</div>
                    @endauth
                </div>
            </div>
        @endif
    @else
        <div class="buy-sell__wrapper">
            <div class="@if(is_mobile()) d-flex justify-content-between mb-3 @endif">
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('Balance')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span class="avl-market-cur-wallet text-themed" id="balance_span">{{ showAmount(@$marketCurrencyWallet->balance) }}</span> 
                            <span>$</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
                
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('Equity')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="equity-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
        
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('Bonus')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="bonus-span">{{ showAmount(@$marketCurrencyWallet->bonus) }} $</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
        
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('Credit')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="credit-span">{{ showAmount(@$marketCurrencyWallet->credit) }} $</span>
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
            
            <div class="@if(is_mobile()) d-flex justify-content-between mb-3 @endif">
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('PL')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="pl-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
                
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('Used Margin')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="used-margin-span">0</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
                
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('Free Margin')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="free-margin-span">0</span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
                
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) d-none @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title">@lang('ST Level') ({{ number_format($pair->level_percent,0) }}%)</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="level-span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
                
                <div class="flex-between mx-0 mt-1 @if(is_mobile()) flex-column @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                    <h7 class="buy-sell__title" style="@if(is_mobile()) font-size: 0.75rem @endif">@lang('Margin Level')</h7>
                    <span class="fs-12 text-themed">
                        @auth
                            <span id="margin_level_span"></span>
                        @else
                            <span>00000</span>
                        @endauth
                    </span>
                </div>
            </div>
        </div>
        
        <div class="buy-sell__price pt-1 pb-1">
            <div class="input--group group-two @if(App::getLocale() == 'ar') text-end @endif">
                <!--<span class="buy-sell__price-title fs-12">@lang('Lots')</span>-->
                <label for="id_label_single" class="@if(is_mobile()) d-flex justify-content-between @endif">
                    <span class="text-themed mb-1" style="@if(is_mobile()) margin-right: 4px @endif">
                        <span class="@if(App::getLocale() != 'ar') d-none @endif">:</span>
                        @lang('Volume in Lots')
                        <span class="@if(App::getLocale() == 'ar') d-none @endif">:</span>
                    </span>
                    <select id="lot-size-select" class="form--control style-three lot-size-select" name="amount"  style="height: 60px; height: 100%; @if(is_mobile()) min-width: 70% !important @endif" onchange="updateLotValues(this)" data-fee-status="{{$fee_status}}">
                        @if($lots && $lots->isNotEmpty())
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
                                <option value="{{$lot->lot_value}}" {{$lot->selected == 1 ? 'selected' : ''}}>{{$lot_volume_display}}</option>
                            @endforeach
                        @else
                            <p>No lots available</p>
                        @endif
                    </select>

                </label>
            </div>
        </div>
        
        <div class="mx-4 mb-3">
            <ul class="p-0 m-0">
                <li class="d-flex">
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1">
                                <span class="lot-label"></span>
                                <span class="lot-value"></span>
                            </small>
                            {{-- <h6 class="mb-0">Send money</h6> --}}
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <small class="text-themed d-block mb-1 lot-eq">
                                <span class="lot-eq-span">{{ $pair ? $pair->percent_charge_for_buy : '0' }}</span> <span class="lot-currency">{{ @$pair->coin_name }}</span>
                            </small>
                        </div>
                    </div>
                </li>
                <li class="d-flex mb-1 pb-1">
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1">&nbsp</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <small class="text-themed d-block mb-1 lot-eq2"><span class="ll-size-span"></span> {{ @$pair->market_name }}</small>
                        </div>
                    </div>
                </li>
                <li class="mt-1 pt-1 @if(is_mobile()) d-flex @endif">
                    <div class="d-flex w-100 flex-wrap align-items-center gap-2 @if(!is_mobile()) justify-content-between @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1 pip-label">
                                <span class="@if(App::getLocale() != 'ar') d-none @endif">:</span>
                                @lang('Pips Value')
                                <span class="@if(App::getLocale() == 'ar') d-none @endif">:</span>
                            </small>
                            {{-- <h6 class="mb-0">Send money</h6> --}}
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            {{-- <h6 class="mb-0">+82.6</h6> <span class="text-muted">USD</span> --}}
                            <small class="text-themed d-block mb-1 pip-value">$0.00</small>
                        </div>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if(!is_mobile()) justify-content-between @endif @if(App::getLocale() == 'ar') flex-row-reverse @endif">
                        <div class="me-2">
                            <small class="text-themed d-block mb-1 required-margin-label">
                                <span class="@if(App::getLocale() != 'ar') d-none @endif">:</span>
                                @lang('Required Margin')
                                <span class="@if(App::getLocale() == 'ar') d-none @endif">:</span>
                            </small>
                            {{-- <h6 class="mb-0">Send money</h6> --}}
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            {{-- <h6 class="mb-0">+82.6</h6> <span class="text-muted">USD</span> --}}
                            <small class="text-themed d-block mb-1 required-margin-value">$0.00</small>
                        </div>
                    </div>
                </li>
                <!--<li class="d-flex mt-1 pt-1">-->
                <!--    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2 @if(App::getLocale() == 'ar') flex-row-reverse @endif">-->
                <!--        <div class="me-2">-->
                <!--            <small class="text-themed d-block mb-1 required-margin-label">-->
                <!--                <span class="@if(App::getLocale() != 'ar') d-none @endif">:</span>-->
                <!--                @lang('Required Margin')-->
                <!--                <span class="@if(App::getLocale() == 'ar') d-none @endif">:</span>-->
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
    
    <div class="trading-bottom__button">
    <!--<div class="mx-3 my-4">-->
        @auth
            @if(!is_mobile())
                <button class="btn btn--danger w-100 btn--sm sell-btn" type="submit" id="sellButton" data-orderside="2" style="{{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                    <span style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('SELL')</span>
                    <input type="number" step="any" class="form--control style-three sell-rate" name="sell_rate" id="sell-rate" style="display: none;"> 
                    <span id="sellSpan" style="color:white;display: block"></span>
                </button>
                <div style="margin: 0 2px;"></div>
                <button class="btn btn--base-two w-100 btn--sm buy-btn" type="submit" id="buyButton" data-orderside="1" style="color: white !important; {{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                    <span style="{{ App::getLocale() == 'ar' ? 'font-size: 1.4rem !important;margin-top: -5px;margin-bottom: 5px;' : '' }}">@lang('BUY')</span>
                    <input type="number" step="any" class="form--control style-three buy-rate" name="buy_rate" id="buy-rate" style="display: none;"> 
                    <span id="buySpan" style="color:white;display: block"></span>
                </button>
            @else
                @if(! $view_portfolio )
                    <button class="btn btn--danger w-100 btn--sm btn-sell-button" data-type="sell" type="button" id="" data-orderside="2" style="{{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
                        @lang('SELL')
                    </button>
                    <div style="margin: 0 2px;"></div>
                    <button class="btn btn--base-two w-100 btn--sm btn-buy-button" data-type="buy" type="button" id="" data-orderside="1" style="color: white !important; {{ App::getLocale() == 'ar' ? 'padding: 5px 10px !important' : '' }}">
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

    <x-flexible-view :view="$activeTemplate . 'trade.traders_trend'"/>
</form>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        updateLotValues(document.querySelector(".lot-size-select"));

        function calculateBuyValue(buyPrice) {
            return (buyPrice * `{{@$pair->spread}}`) + buyPrice;
        }
        
        function calculateSellValue(sellPrice) {
            return sellPrice; // No calculation needed for sell value
        }

        function updateSpanValues(currentPrice) {
            let coin_name           = `{{@$pair->type}}`;
            let coin_symbol         = `{{@$pair->symbol}}`;

            var curr_price          = parseFloat((coin_name === 'Crypto' || coin_name === 'COMMODITY' || coin_name === 'INDEX' ? parseFloat(currentPrice.replace(/,/g, '')).toFixed(5) : formatWithPrecision(currentPrice)));
            
            var buyValue            = calculateBuyValue(curr_price);
            var sellValue           = calculateSellValue(curr_price);
            
            document.title          = `${curr_price} {{@$pair->symbol}}`;
            
            let sellSpan            = document.getElementById("sellSpan");
            let buySpan             = document.getElementById("buySpan");
            
            let sellRate            = document.querySelector(".sell-rate");
            let buyRate             = document.querySelector(".buy-rate");

            let buyDecimal          = countDecimalPlaces(sellValue);

            let adjustedBuyValue    = buyValue;

            if (coin_symbol === 'GOLD') {
                if (buyDecimal == 0) {
                    sellSpan.innerText  = removeTrailingZeros(sellValue);
                    buySpan.innerText   = removeTrailingZeros(buyValue);
                    adjustedBuyValue    = removeTrailingZeros(buyValue);
                }else{
                    sellSpan.innerText  = removeTrailingZeros(sellValue.toFixed(2));
                    buySpan.innerText   = removeTrailingZeros(buyValue.toFixed(buyDecimal));
                    adjustedBuyValue    = removeTrailingZeros(buyValue.toFixed(buyDecimal));
                }
            } else {
                if (buyDecimal == 0 && coin_name === 'Crypto') {
                    buySpan.innerText   = Math.floor(buyValue);
                    sellSpan.innerText  = sellValue;
                    adjustedBuyValue    = buyValue;
                    
                } else {
                    buySpan.innerText   = removeTrailingZeros((coin_name === 'Crypto' ? buyValue.toFixed(buyDecimal) : buyValue.toFixed(buyDecimal)));
                    sellSpan.innerText  = removeTrailingZeros((coin_name === 'Crypto' ? sellValue.toFixed(5) : sellValue.toFixed(5)));
                    adjustedBuyValue    = (coin_name === 'Crypto' ? buyValue.toFixed(buyDecimal) : buyValue.toFixed(buyDecimal));
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
            let actionUrl = "{{ route('trade.current-price', ['type' => @$pair->type, 'symbol' => @$pair->symbol ]) }}";
            let buySpan = $('#buySpan');
            let sellSpan = $('#sellSpan');
            $.ajax({
                url: actionUrl,
                type: "GET",
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    if (buySpan.text() === '') buySpan.append(` <i class="fa fa-spinner fa-spin"></i>`);
                    if (sellSpan.text() === '') sellSpan.append(` <i class="fa fa-spinner fa-spin"></i>`);
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

        function customUpdateTrend( type ){
            //Update trend 
            const bear      = document.querySelector('.bear');
            const bull      = document.querySelector('.bull');
            const bearPct   = document.querySelector('.bear-pct');
            const bullPct   = document.querySelector('.bull-pct');
            
            let val1 = Math.floor(Math.random() * 101);
            let val2 = 100 - val1;

            if( type === "buy" )
            {
                if( val1 > val2 ) {
                    bullPercentage = val1;
                    bearPercentage = val2;
                }
                else{
                    bullPercentage = val2;
                    bearPercentage = val1;
                }
            }else{
                if( val1 < val2 ) {
                    bullPercentage = val1;
                    bearPercentage = val2;
                }else{
                    bullPercentage = val2;
                    bearPercentage = val1;
                }
            }

            bear.style.width    = bearPercentage + '%';
            bull.style.width    = bullPercentage + '%';
            bearPct.textContent = bearPercentage + '%';
            bullPct.textContent = bullPercentage + '%';
        }

        $(document).on('click', '.btn-sell-button, .btn-buy-button', function(){
            const type = $(this).data('type');

            // Check here the highest percentage
            if( type === "buy" ){
                $('.btn-modal-buy').removeClass('d-none');
                $('.btn-modal-sell').addClass('d-none');
            }
            else{
                $('.btn-modal-sell').removeClass('d-none');
                $('.btn-modal-buy').addClass('d-none');
            }

            customUpdateTrend( type );

            $('#modalBuySell').modal('show');
        });
        
    });

    function updateLotValues(select) {
        var selectedOption  = select.options[select.selectedIndex];
        var selectedLotText = selectedOption.textContent;
        var selectedLot     = select.value;
        var lotLabel        = document.querySelector('.lot-label');
        
        lotLabel.innerText                              =  "@lang('Lot'):";
        document.querySelector('.lot-value').innerText  = selectedLotText
        
        let lotValue                                     = {{ @$pair->percent_charge_for_buy }};
        let lotEquivalent                                = parseFloat(lotValue) * parseFloat(selectedLotText);
        document.querySelector('.lot-eq-span').innerText = lotEquivalent;
        
        updateLLSize();

        if (select.dataset.feeStatus == 1) {
            updatePipValue(select);
        }
    }

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

    function updatePipValue(select) {
        let pipValueElement         = document.querySelector('.pip-value');
        pipValueElement.innerText   = '$ ' + select.value;
    }
    
    function removeTrailingZeros(number) {
        var numberString        = number.toString();
        var trimmedNumberString = numberString.replace(/\.?0+$/, '');
        var trimmedNumber       = parseFloat(trimmedNumberString);

        if (Number.isInteger(trimmedNumber)) {
            return trimmedNumber.toFixed(2);
        }
        
        return trimmedNumber;
    }
    
    function isLevelMoreThanOrEqualToEquity() {
        let level   = parseFloat(document.querySelector('#level-span').innerText.replace(/ USD/g, ""));
        let equity = parseFloat(document.querySelector('#equity-span').innerText.replace(/ USD/g, ""));
        
        return level >= equity;
    }
    
    function closeAllOpenTrade(level, equity)
    {
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
@if( is_mobile() )
    <script>
        $(document).ready(() => {
            $('#lot-size-select').select2({
                tags: true,
                height: 'resolve',
                width: 'resolve',
                dropdownParent: $('#modalBuySell'),
                createTag: function (params) {
                    if (! isValidNumberOrDecimal(params.term)) {
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
                createTag: function (params) {
                    
                    if (! isValidNumberOrDecimal(params.term)) {
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
        min-width: 100% !important;
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
            font-size: 0.6rem; /* Smaller text */
        }
    
        .accordion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    
        .accordion-body {
            font-size: 0.6rem; /* Smaller text for the accordion body */
        }
    
        .d-flex {
            display: flex;
            flex-wrap: nowrap; /* Keep elements in one line */
        }
    }

    /* New Accordion Arrow Styles */
    .accordion-button {
        position: relative;
        padding-right: 2rem; /* Space for the arrow */
    }

    .accordion-icon {
        position: absolute;
        right: 1rem;
        font-size: 1.25rem;
        color: white; /* Ensure the icon is visible */
    }

    .accordion-button:not(.collapsed) .accordion-icon i {
        transform: rotate(180deg); /* Rotate arrow when expanded */
    }

    .accordion-button.collapsed .accordion-icon i {
        transform: rotate(0deg); /* Reset to default arrow direction when collapsed */
    }

    .accordion-button .accordion-icon i {
        transition: transform 0.2s ease; /* Smooth animation for the arrow */
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

    .summary-container {
        background-color: #0d1e23;
        padding: 20px;
        border-radius: 8px;
        width: 100%; /* Full width */
        max-width: 100%; /* Max width 100% for larger devices */
        /* margin-bottom: 80px; */
    }

    table {
        width: 100% !important; /* Ensure table takes 100% width */
        border-collapse: collapse;
    }

    th, td {
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
            width: 100%; /* Full width for smaller screens */
        }
        
        table {
            width: 100% !important; /* Ensure full width on small screens */
            display: block;
            overflow-x: auto; /* Enable horizontal scrolling */
        }
        
        th, td {
            font-size: 12px; /* Smaller font for small screens */
        }
    }

    @media (max-width: 320px) {
        .summary-container {
            width: 100%; /* Full width for very small screens */
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

    .summary-item:nth-child(1) { background-color: #7d7d7d; }
    .summary-item:nth-child(2) { background-color: #6e6e6e; }
    .summary-item:nth-child(3) { background-color: #5f5f5f; }
    .summary-item:nth-child(4) { background-color: #4f4f4f; }
    .summary-item:nth-child(5) { background-color: #3f3f3f; }
    .summary-item:nth-child(6) { background-color: #2f2f2f; }
    .summary-item:nth-child(7) { background-color: #6e6e6e; }
    .summary-item:nth-child(8) { background-color: #4f4f4f; }

    .label {
        font-size: 16px;
        color: white;
    }

    .value-box {
        font-weight: bold;
        font-size: 16px;
    }

    .c-icon{
        width: 30px;
        height: auto;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

@endpush


