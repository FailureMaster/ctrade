@php
    $meta = (object) $meta;
    $closed_orders = @$meta->closed_orders;
    $pl = @$meta->pl;
    $total_profit = @$meta->total_profit;
    $total_loss = @$meta->total_loss;
@endphp
<div class="trading-table two">
    <div class="flex-between trading-table__header">
        {{-- Header Content --}}
    </div>
    <div class="tab-content" id="pills-tabContentfortyfour">
        <div class="tab-pane fade show active" id="pills-marketnineteen" role="tabpanel"
            aria-labelledby="pills-marketnineteen-tab" tabindex="0">
            <div class="table-wrapper-two">
                @auth
                    <table class="table table-two history-table">
                        @if (App::getLocale() == 'ar')
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('Status')</th>
                                    <th class="text-center">@lang('Profit')</th>
                                    <th class="text-center">@lang('Take Profit')</th>
                                    <th class="text-center">@lang('Stop Loss')</th>
                                    <th class="text-center">@lang('Closed Price')</th>
                                    <th class="text-center">@lang('Open Price')</th>
                                    <th class="text-center">@lang('Volume')</th>
                                    <th class="text-center">@lang('Type')</th>
                                    <th class="text-center">@lang('Symbol')</th>
                                    <th class="text-center">@lang('Close Date')</th>
                                    <th class="text-center">@lang('Open Date')</th>
                                    <th class="text-center">@lang('Order ID')</th>
                                    <!--<th></th>-->
                                </tr>
                            </thead>
                        @else
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('Order ID')</th>
                                    <th class="text-center">@lang('Open Date')</th>
                                    <th class="text-center">@lang('Close Date')</th>
                                    <th class="text-center">@lang('Symbol')</th>
                                    <th class="text-center">@lang('Type')</th>
                                    <th class="text-center">@lang('Volume')</th>
                                    <th class="text-center">@lang('Open Price')</th>
                                    <th class="text-center">@lang('Closed Price')</th>
                                    <th class="text-center">@lang('Stop Loss')</th>
                                    <th class="text-center">@lang('Take Profit')</th>
                                    <th class="text-center">@lang('Profit')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <!--<th></th>-->
                                </tr>
                            </thead>
                        @endif
                        <tbody class="history-body">
                            {{-- Rows will be added here dynamically --}}
                        </tbody>
                    </table>
                @else
                    <div class="empty-thumb">
                        <img src="{{ asset('assets/images/extra_images/user.png') }}" alt="Please login" />
                        <p class="empty-sell" style="color:#d1d4dc">@lang('Please login to explore your order')</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
<div class="trading-table__mobile">
    <div class="summary-container pb-0 sc-history">
        <h2 class="h-title p-0 mb-0 border-0">@lang('Transactions Logs')</h2>
        <h2 class="p-0 ch5"></h2>
        <div class="portfolio-item">
            <div class="label p-0">@lang('Total Orders')</div>
            <div class="dots"></div>
            @auth
                @if ($closed_orders != null)
                    <div class="value-box">{{ $closed_orders->count() }}</div>
                @endif
            @else
                <div class="value-box">00000</div>
            @endauth
        </div>

        <div class="portfolio-item">
            <div class="label">@lang('P/L')</div>
            <div class="dots"></div>
            @auth
                @if ($pl != null)
                    <div class="value-box {{ getAmount($pl) >= 0 ? 'text-success' : 'text-danger' }}" id="">
                        {{ number_format(getAmount($pl), 2, '.', '') }}$</div>
                @endif
            @else
                <div class="value-box" id="">00000</div>
            @endauth
        </div>

        <div class="portfolio-item">
            <div class="label">@lang('Sell')</div>
            <div class="dots"></div>
            @auth
                @if ($closed_orders != null)
                    <div class="value-box {{ getAmount($closed_orders->where('order_side', Status::SELL_SIDE_ORDER)->sum('profit')) >= 0 ? 'text-success' : 'text-danger' }}"
                        id="">
                        {{ getAmount($closed_orders->where('order_side', Status::SELL_SIDE_ORDER)->sum('profit')) }}$</div>
                @endif
            @else
                <div class="value-box">00000</div>
            @endauth
        </div>

        <div class="portfolio-item">
            <div class="label">@lang('Buy')</div>
            <div class="dots"></div>
            @auth
                @if ($closed_orders != null)
                    <div class="value-box {{ getAmount($closed_orders->where('order_side', Status::BUY_SIDE_ORDER)->sum('profit')) >= 0 ? 'text-success' : 'text-danger' }}"
                        id="">
                        {{ getAmount($closed_orders->where('order_side', Status::BUY_SIDE_ORDER)->sum('profit')) }}$</div>
                @endif
            @else
                <div class="value-box">00000</div>
            @endauth
        </div>

        <div class="portfolio-item">
            <div class="label">@lang('Profit')</div>
            <div class="dots"></div>
            @auth
                @if ($total_profit != null)
                    <div class="value-box {{ getAmount($total_profit) >= 0 ? 'text-success' : 'text-danger' }}"
                        id="">{{ getAmount($total_profit) }}$</div>
                @endif
            @else
                <div class="value-box">00000</div>
            @endauth
        </div>

        <div class="portfolio-item">
            <div class="label">@lang('Lose')</div>
            <div class="dots"></div>
            @auth
                @if ($total_profit != null)
                    <div class="value-box {{ getAmount($total_loss) >= 0 ? 'text-success' : 'text-danger' }}"
                        id="">{{ getAmount($total_loss) }}$</div>
                @endif
            @else
                <div class="value-box">00000</div>
            @endauth
        </div>
        <h2 class="mb-1 p-0 ch1"></h2>
    </div>

    <h2 class="p-0 ch5"></h2>
    <div class="summary-container pt-0" id="history-sc">
        <div class="d-flex align-items-center justify-content-between @if (App::getLocale() == 'ar') flex-row-reverse @endif">
            <h2 class="h-title p-0 mb-0 border-0">@lang('Closed Orders')</h2>
            <x-mobile-date-filter/>
        </div>

        <h2 class="p-0 ch5 ch5-history"></h2>

        <table id="tblHistory" style="display: inline-table;">
            <tbody class="history-body">
            </tbody>
        </table>
    </div>

</div>
@push('style')
    <style>
        .history-table thead tr th {
            font-size: 0.875rem !important;
        }

        .history-body>tr>td {
            border-bottom: 1px solid #3c4a54 !important;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            "use strict";

            function formatWithPrecision(value, precision = 5) {
                // Formats numbers with a specified precision
                return Number(value).toFixed(precision);
            }

            function formatWithPrecision1(value, precision = 2) {
                // Formats numbers with a specified precision
                return Number(value).toFixed(precision);
            }

            function getRandomItem(arr) {
                const randomIndex = Math.floor(Math.random() * arr.length);
                const item = arr[randomIndex];

                return item;
            }

            var i = 1;

            function generateHistoryRow(order, jsonData) {

                openRowsHistory = [];

                // Collect IDs of open rows, To retain open state of accordion
                document.querySelectorAll('.history-collapse.show').forEach(row => {
                    openRowsHistory.push(row.id);
                })

                let current_price = order.rate;

                let lotValue = order.pair.percent_charge_for_buy;

                let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);
                let leverage = parseFloat(order.pair.percent_charge_for_sell);
                let total_price = formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price)) *
                    lotEquivalent) * leverage);

                let profitClass = order.profit <= 0 ? 'text-danger' : 'text-success';


                let orderSideBadge = (order.order_side == 2) ? 'S' : 'B'; // Check if sell (2) or buy (1)
                let badgeClass = (order.order_side == 2) ? 'text-danger' :
                    'text-success'; // Red for sell, green for buy

                current_price = parseFloat(current_price);


                let decimalCount = countDecimalPlaces(current_price);

                if (window.innerWidth < 579) {

                    let is_collapsed = 0;

                    if (openRowsHistory.includes(`collapse${order.id}`)) {
                        is_collapsed = 1;
                    }

                    // Comment this tomorrow
                    // return `
                //     <tr class="clickable-row clickable-header" id="heading${order.id}" data-bs-toggle="collapse" data-bs-target="#collapse${order.id}" ${ is_collapsed ? 'aria-expanded="true"' : '' }>
                //         <td><span class="chevron"  ></span></td>
                //         <td>#${order.id}</td>
                //         <td>${order.pair.symbol.replace('_', '/')}</td>
                //         <td class="buy">${order.order_side_badge}</td>
                //         <td class="${profitClass}">${removeTrailingZeros(formatWithPrecision(order.profit)) || 0}</td>
                //     </tr>

                //     <tr id="collapse${order.id}" class="collapse ${ is_collapsed ? 'show' : '' }" aria-labelledby="heading${order.id}">
                //         <td colspan="6">
                //             <strong>Date:</strong> ${order.formatted_date}<br><br>
                //             <strong>Open Price:</strong> ${formatWithPrecision(order.rate)}<br><br>
                //             <strong>Closed Price:</strong> <span>${removeTrailingZeros(formatWithPrecision(order.closed_price)) || 0}</span><br><br>
                //             <strong>Stop Loss:</strong> ${order.stop_loss ? formatWithPrecision(order.stop_loss) : '-'}<br><br>
                //             <strong>Take Profit:</strong> ${order.take_profit ? formatWithPrecision(order.take_profit) : '-'}<br><br>
                //             <strong>Volume:</strong> ${removeTrailingZeros(order.no_of_lot)}<br><br>
                //             <strong>Profit:</strong> <span class="${profitClass}">${removeTrailingZeros(formatWithPrecision(order.profit)) || 0}</span><br><br>
                //             <strong>Status:</strong> ${order.status_badge}<br>
                //         </td>
                //     </tr>
                // `;
                    // End of comment this tomorrow

                    // Uncomment this tomorrow
                    let customOrderProfit = removeTrailingZeros(formatWithPrecision(order.profit));
                    return `
                    <tr class="clickable-row clickable-header" id="heading${order.id}" data-bs-toggle="collapse" data-bs-target="#collapse${order.id}" ${ is_collapsed ? 'aria-expanded="true"' : '' }>
                        <td class="p-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <div>
                                        <span class="h-label">${order.pair.symbol.replace('_', '/')},</span>
                                        <span class="${ total_price < 0 ? 'negative' : 'text-primary'}">${order.custom_order_side_badge}</span>
                                        <span class="h-label">${removeTrailingZeros(order.no_of_lot)}</span>
                                    </div>
                                    <div>
                                        <span class="h-label">${parseFloat(order.rate).toFixed(decimalCount)}</span>
                                        <span class="h-label">&rarr;</span>
                                        <span class="h-label" >${parseFloat(order.closed_price).toFixed(decimalCount) || 0}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="${ order.profit < 0 ? 'negative' : 'text-primary'}">${parseFloat(customOrderProfit).toFixed(2) || 0}</label>
                                </div>
                            </div>     
                        </td>
                    </tr>
                    
                    <tr id="collapse${order.id}" class="history-collapse collapse ${ is_collapsed ? 'show' : '' }" aria-labelledby="heading${order.id}" >
                        <td colspan="6">
                            <div class="@if (App::getLocale() == 'ar') text-end @endif">
                                <strong>@lang('Date'):</strong> ${order.formatted_date}<br>
                                <strong>@lang('Open Price'):</strong> ${parseFloat(order.rate).toFixed(decimalCount)}<br>
                                <strong>@lang('Closed Price'):</strong>${parseFloat(order.closed_price).toFixed(decimalCount) || 0}<br>
                                <strong>@lang('Stop Loss'):</strong> ${order.stop_loss ? parseFloat(order.stop_loss).toFixed(decimalCount) || 0 : '0'}<br>
                                <strong>@lang('Take Profit'):</strong> ${order.take_profit ? parseFloat(order.take_profit).toFixed(decimalCount) : '0'}<br>
                                <strong>@lang('Volume'):</strong> ${removeTrailingZeros(order.no_of_lot)}<br>
                                @if (App::getLocale() != 'ar')
                                <strong>@lang('Profit'):</strong> <label class="${profitClass}">${removeTrailingZeros(formatWithPrecision(order.profit)) || 0}</label><br>
                                @else
                                    <label class="${profitClass}">${removeTrailingZeros(formatWithPrecision(order.profit)) || 0}</label>:<strong>@lang('Profit')</strong><br>
                                @endif

                                @if (App::getLocale() != 'ar')
                                <strong>@lang('Status'):</strong> ${order.status_badge}<br>
                                @else
                                ${order.status_badge}:<strong>@lang('Status')</strong><br>
                                @endif
                            </div> 
                        </td>
                    </tr>
            `;
                    // End of Uncomment this tomorrow
                }
                return `
            @if (App::getLocale() != 'ar')
                <tr data-order-id="${order.id}">
                    <td class="text-center p-2">#${order.id}</td>
                    <td class="text-center p-2">${order.formatted_date}</td>
                    <td class="text-center p-2">${order.close_date}</td>
                    <td class="text-center p-2">${order.pair.symbol.replace('_', '/')}</td>
                    <td class="text-center p-2">${order.order_side_badge}</td>
                    <td class="text-center p-2">${removeTrailingZeros(order.no_of_lot)}</td>
                    <td class="text-center p-2">${parseFloat(order.rate).toFixed(decimalCount)}</td>
                    <td class="text-center p-2">${parseFloat(order.closed_price).toFixed(decimalCount) || 0}</span></td>
                    <td class="text-center p-2">${order.stop_loss ? parseFloat(order.stop_loss).toFixed(decimalCount) || 0 : '-'}</td>
                    <td class="text-center p-2">${order.take_profit ? parseFloat(order.take_profit).toFixed(decimalCount) : '-'}</td>
                    <td class="text-center p-2"><span class="${profitClass}">${parseFloat(order.profit).toFixed(decimalCount) || 0}</span></td>
                    <td class="text-center p-2">${order.status_badge}</td>
                </tr>
            @else
                <tr data-order-id="${order.id}">
                    <td class="text-center p-2">${order.status_badge}</td>
                    <td class="text-center p-2"><span class="${profitClass}">${parseFloat(order.profit).toFixed(decimalCount) || 0}</span></td>
                    <td class="text-center p-2">${order.take_profit ? removeTrailingZeros(parseFloat(order.take_profit).toFixed(decimalCount)) : '-'}</td>
                    <td class="text-center p-2">${order.stop_loss ? removeTrailingZeros(parseFloat(order.stop_loss).toFixed(decimalCount)) : '-'}</td>
                    <td class="text-center p-2">${removeTrailingZeros(parseFloat(order.closed_price).toFixed(decimalCount)) || 0}</span></td>
                    <td class="text-center p-2">${removeTrailingZeros(parseFloat(order.rate).toFixed(decimalCount))}</td>
                    <td class="text-center p-2">${removeTrailingZeros(order.no_of_lot)}</td>
                    <td class="text-center p-2">${order.order_side_badge}</td>
                    <td class="text-center p-2">${order.pair.symbol.replace('_', '/')}</td>
                    <td class="text-center p-2">${order.close_date}</td>
                    <td class="text-center p-2">${order.formatted_date}</td>
                    <td class="text-center p-2">#${order.id}</td>
                </tr>
            @endif
        `;
            }

            let openRowsHistory = [];

            function fetchHistory() {

                let date_filter = null;
                let from_date   = $('input[name="customfilterFrom"]').val();
                let to_date     = $('input[name="customfilterTo"]').val();

                if ($('.dropdown-item.active').length > 0) {
                    date_filter = $('.dropdown-item.active').attr('data-value');
                }

                let actionUrl =
                    "{{ route('trade.order.list', ['pairSym' => @$pair->symbol ?? 'default_symbol', 'status' => 'history']) }}";

                actionUrl += `?filter=${date_filter}&from_date=${from_date}&to_date=${to_date}&history=1`;

                $.ajax({
                    url: actionUrl,
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    data: {}, // Now fetching all orders without status differentiation
                    success: function(resp) {
                        let html = '';
                        let jsonMarketData = resp.marketData;

                        if (resp.orders && resp.orders.length > 0) {
                            resp.orders.forEach(order => {
                                html += generateHistoryRow(order, jsonMarketData[order.pair
                                    .type]);
                            });
                        } else {
                            html =
                                `<tr class="text-center px-4"><td class="no-order-label" colspan="9">@lang('No order found')</td></tr>`;
                        }

                        if( resp.html != "" ){
                            $('.sc-history').html( resp.html );
                        }

                        $('.history-body').html(html);

                        $('.close-orders-count').text(`(${resp.orders.length})`)
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching history: ", error);
                    }
                });
            }

            fetchHistory();
            setInterval(function() {

                // openRowsHistory = [];

                // // Collect IDs of open rows, To retain open state of accordion
                // document.querySelectorAll('.collapse.show').forEach(row => {
                //     openRowsHistory.push(row.id);
                // })

                // fetchHistory();
            }, 10000);
            // setInterval(function func() {
            //     return func;
            // }(), 10000);

            $(document).off('click', '#mobileDateFilterDropdown .dropdown-item').on('click', '#mobileDateFilterDropdown .dropdown-item', function(e) {
                
                $('.dropdown-item').removeClass('active');
                
                $(this).addClass('active');

                let loadhistory = 0;

                if( loadhistory == 0 ){
                    fetchHistory();
                    loadhistory = 1;
                }
            })
        });
    </script>
@endpush

@push('style')
    <style>
        .dropdown-toggle::after {
            content: none;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dropdown-item .label {
            display: flex;
            align-items: center;
        }

        .dropdown-item .label i {
            font-size: 1.2rem;
        }

        .dropdown-item .date-range {
            font-size: 0.9rem;
            color: white !important;
        }

        .dropdown-menu {
            width: 220px;
        }

        .dropdown-item.active {
            background-color: #007bff !important;
            color: white !important;
        }

        .dropdown-menu {
            background-color: #293543;
        }

        .dropdown-menu li .dropdown-item {
            margin: 0 !important;
        }

        .dropdown-menu li .dropdown-item {
            padding: .5rem;
        }

        #dateFilterDropdown {
            border: unset !important;
            color: #fff;
        }

        .h-title {
            font-size: 16px !important;
            color: #97a6b5 !important;
        }

        #tblHistory td {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        .ch5 {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
        }

        .ch5-history {
            border-bottom: 1px solid #3c4a54;
        }

        .label,
        .value-box,
        .c-icon,
        .portfolio-item,
        #tblHistory td,
        #tblHistory tr,
        #tblHistory {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 16px;
        }

        .ellipsis-menu {
            font-size: 16px;
            color: white;
            cursor: pointer;
            padding-right: 10px; /* Adjust as needed for spacing */
        }

        #history-sc{
            margin-bottom:5rem;
        }
    </style>
@endpush
{{-- @php
    $meta = (object) $meta;
    $pair = @$meta->pair;
@endphp
<div class="trading-right__bottom">
    <div class="d-flex trading-market__header justify-content-between text-center">
        <div class="trading-market__header-two">
            @lang('Price')({{ $pair->market->currency->symbol }})
        </div>
        <div class="trading-market__header-one">
            @lang('Amount') ({{ $pair->coin->symbol }})
        </div>
        <div class="trading-market__header-three">
            @lang('Date/Time')
        </div>
    </div>
    <div class="tab-content" id="pills-tabContentfortyfour">
        <div class="tab-pane fade show active" id="pills-marketnineteen" role="tabpanel"
            aria-labelledby="pills-marketnineteen-tab" tabindex="0">
            <div class="market-wrapper">
                <div class="history  trade-history"></div>
            </div>
        </div>
    </div>
</div>

@if (!app()->offsetExists('trade_script'))
@php app()->offsetSet('trade_script',true) @endphp
@push('script')
    <script>
        "use strict";
        (function ($) {
            let pairSymbol    = "{{ $pair->symbol }}";
            let sellSideTrade = parseInt("{{ Status::SELL_SIDE_TRADE }}");


            function newTradeHmtl (data) {
               let trades=data.trade;

               let newHtml=``;
               $.each(trades, function (symbol, trade) {
                    if(pairSymbol != symbol){
                        return;
                    }
                    $.each(trade, function (i, element) {
                        newHtml+=`<ul class="history__list flex-between trade-history-item" data-rate="${element.rate}">
                        <li class="history__amount-item text-start ${ sellSideTrade == parseInt(element.trade_side) ? 'text-danger' : '' }">
                            ${showAmount(element.rate)}
                        </li>
                        <li class="history__price-item text-center"> ${showAmount(element.amount)} </li>
                        <li class="history__date-item"> ${new Date().toLocaleString()} </li>
                    </ul>`
                    });
               });
               $('.trade-history').prepend(newHtml);
            }
            pusherConnection('trade', newTradeHmtl);

            $('.trade-history').on('click','.trade-history-item',function (e) {
                let rate=$(this).data('rate');
                $('.buy-rate').val(getAmount(rate)).trigger('change');
                $('.buy-amount').val(1);
                $('.sell-amount').val(1);
                $('.sell-rate').val(getAmount(rate)).trigger('change');
            });

            function tradeHistory(){
                let action        = "{{ route('trade.history',':curSym') }}";

                $.ajax({
                    url: action.replace(':curSym',"{{@$pair->symbol}}"),
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    success: function (resp) {
                        let html=``;
                        if(resp.success){
                            if(resp.trades.length > 0){
                                $.each(resp.trades, function (i, trade) {
                                    html+=`<ul class="history__list flex-between trade-history-item" data-rate="${trade.rate}">
                                        <li class="history__amount-item text-start ${ sellSideTrade == parseInt(trade.trade_side) ? 'text-danger' : '' }">
                                            ${showAmount(trade.rate)}
                                        </li>
                                        <li class="history__price-item text-center"> ${showAmount(trade.amount)} </li>
                                        <li class="history__date-item"> ${trade.formatted_date} </li>
                                    </ul>`
                                    ;
                                });
                                $('.trade-history').removeClass('justify-content-center');
                            }else{
                                html+=`
                                <div class="empty-thumb">
                                    <img src="{{ asset('assets/images/extra_images/empty.png') }}"/>
                                    <p   class="empty-sell" style="color:##d1d4dc">@lang('No trade found')</p>
                                </div>
                                `;
                                $('.trade-history').addClass('justify-content-center');
                            }
                        }
                        $('.trade-history').html(html);
                    }
                });
            }
            tradeHistory();
        })(jQuery);
    </script>
@endpush
@endif
 --}}
