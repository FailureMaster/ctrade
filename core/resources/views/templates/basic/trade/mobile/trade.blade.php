@extends($activeTemplate . 'layouts.frontend')

@section('content')
 <div class="trade-container">
    <div class="summary-container pb-0">
        <h2 class="h-title p-0 mb-0 border-0">@lang('Portfolio')</h2>
        <h2 class="p-0 ch5"></h2>
        <div class="portfolio-item">
            <div class="label p-0">@lang('Balance')</div>
            <div class="dots"></div>
            @auth
                <span class="value-box {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success' }}" id="balance_span">
                    {{ showAmount(@$marketCurrencyWallet->balance) }} $</span>
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
</div> 

<x-confirmation-modal isCustom="true" />
<x-stop-loss-modal />
<x-take-profit-modal />

{{-- Canva --}}
<div class="offcanvas offcanvas-bottom custom-offcanvas p-4" tabindex="-1" id="trade-canvas" aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-header">
        <h4 class="mb-0 fs-18 offcanvas-title text-white">
        </h4>
        <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-times-circle fa-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body">
       <div class="body-section">

       </div>
    </div>
</div>

{{-- Menu --}}
@include($activeTemplate . 'partials.mobile.menu')
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            let isClosingAllOrders = false;

            let openRows = [];

            var i = 1;
            let equity = 0;
            let total_open_order_profit = 0;
            let total_amount = 0;
            let pl = 0;
            let order_count = parseInt({{ @$order_count }}) || 0;
            let balance = parseFloat({{ @$balance }}) || 0;
            let free_margin = 0;
            let level_percent = (parseFloat({{ @$pair->level_percent }}) || 0) / 100;
            let total_used_margin = 0;
            let required_margin_total = {{ @$requiredMarginTotal ?? 0 }}
            let bonus = parseFloat({{ @$bonus }}) || 0;
            let credit = parseFloat({{ @$credit }}) || 0;
            let margin_level = 0;
            let st_level_percentage = parseInt({{ @$pair->level_percent }}) || 0;

            function generateOrderRow(order, jsonData) {
                // sell price is current price from API
                // buy price is when you add the spread.

                openRows = [];

                // Collect IDs of open rows, To retain open state of accordion
                document.querySelectorAll('.collapse.show').forEach(row => {
                    openRows.push(row.id);
                });

                let current_price = jsonData[order.pair.symbol].replace(/,/g, '')

                let spread = order.pair.spread;
                
                if( order.order_spread != null ) spread = order.order_spread;

                let decimalCount = countDecimalPlaces(current_price);

                current_price = parseFloat(current_price);

                // Current Price Formula
                if (parseInt(order.order_side) === 1) 
                    current_price = (current_price - parseFloat(spread));
                else
                    current_price = (current_price + parseFloat(spread));
                
                current_price = parseFloat(current_price).toFixed(decimalCount);

                let lotValue = order.pair.percent_charge_for_buy;

                if( order.lot_value != null ){
                    lotValue = order.lot_value;
                }

                let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);

                let total_price = parseInt(order.order_side) === 2 ?
                    formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price)) * lotEquivalent)) :
                    formatWithPrecision(((parseFloat(current_price) - parseFloat(order.rate)) * lotEquivalent));

                total_open_order_profit = parseFloat(total_open_order_profit) + parseFloat(total_price);
                total_amount = parseFloat(total_amount) + parseFloat(formatWithPrecision1(order.amount));

                // let ll_size = parseFloat(document.querySelector('.ll-size-span').innerText);
                // total_used_margin = parseFloat(total_used_margin) + (ll_size / parseFloat(order.pair
                //     .percent_charge_for_sell));

                let actionUrl =
                    `{{ route('user.order.close', ['id' => ':id', 'order_side' => ':order_side', 'amount' => ':amount', 'closed_price' => ':closed_price', 'profit' => ':profit']) }}`;

                actionUrl = actionUrl
                        .replace(':id', order.id)
                        .replace(':order_side', order.order_side)
                        .replace(':amount', total_price)
                        .replace(':closed_price', parseFloat(current_price))
                        .replace(':profit', parseFloat(total_price));

                    let button = order.status == 0 ?
                        `
                            <button 
                                type="button" 
                                style="font-size: 12px; border: transparent; color: white !important;"
                                class="btn btn-secondary px-4 py-2 confirmationBtn text-uppercase" 
                                data-question="@lang('Close the order now with current profit?')" 
                                data-orderid="${order.id}"
                                data-action="${actionUrl}"
                                data-title="@lang('Close Order') #${order.id}"
                                data-symbol="${order.pair.symbol.replace('_', '/')}"
                                data-open="${parseFloat(order.rate).toFixed(decimalCount)}"
                                data-curr="${current_price}"
                                data-volume="${removeTrailingZeros(order.no_of_lot)}"
                                data-profit="${removeTrailingZeros(total_price)}"
                                title="Close Order"
                            >@lang('Close')</button>
                        ` : '';


                    let slButtonLabel = order.stop_loss ? parseFloat(order.stop_loss).toFixed(decimalCount) :
                        "{{ __('SL') }}";
                    let tpButtonLabel = order.take_profit ? parseFloat(order.take_profit).toFixed(decimalCount) :
                        "{{ __('TP') }}";

                    let buttonStopLoss = `
                        <button 
                            type="button" 
                            style="font-size: 12px; border: transparent; color: white !important;"
                            class="btn btn-secondary px-4 py-2 stopLossModalBtn" 
                            data-orderid="${order.id}"
                            data-action="${actionUrl}"
                            data-title="@lang('Stop Loss') #${order.id}"
                            data-symbol="${order.pair.symbol.replace('_', '/')}"
                            data-open="${parseFloat(order.rate).toFixed(decimalCount)}"
                            data-curr="${current_price}"
                            data-volume="${removeTrailingZeros(order.no_of_lot)}"
                            data-profit="${removeTrailingZeros(total_price)}"
                            data-equivalent="${lotEquivalent}"
                            data-side="${order.order_side}"
                            title="Stop Loss"
                        >${slButtonLabel}</button>
                    `;

                let buttonTakeProfit = `
                    <button 
                        type="button" 
                        style="font-size: 12px; border: transparent; color: white !important;"
                        class="btn btn-secondary px-4 py-2 takeProfitModalBtn" 
                        data-orderid="${order.id}"
                        data-action="${actionUrl}"
                        data-title="@lang('Take Profit') #${order.id}"
                        data-symbol="${order.pair.symbol.replace('_', '/')}"
                        data-open="${parseFloat(order.rate).toFixed(decimalCount)}"
                        data-curr="${current_price}"
                        data-volume="${removeTrailingZeros(order.no_of_lot)}"
                        data-profit="${removeTrailingZeros(total_price)}"
                        data-equivalent="${lotEquivalent}"
                        data-side="${order.order_side}"
                        title="Take Profit"
                    >${tpButtonLabel}</button>
                `;
                var run_time = parseFloat(document.title);

                let profitClass = total_price <= 0 ? 'text-danger' : 'text-success';

                let orderSideBadge = (order.order_side == 2) ? 'S' : 'B'; // Check if sell (2) or buy (1)
                let badgeClass = (order.order_side == 2) ? 'text-danger' :
                'text-success'; // Red for sell, green for buy

                // Modify the HTML generation to use orderSideBadge
                if (window.innerWidth < 579) {

                    let is_collapsed = 0;

                    if (openRows.includes(`collapse${order.id}`)) {
                        is_collapsed = 1;
                    }

                    // new code
                    // return `
                    //     <tr class="clickable-row clickable-header flex flex-column" id="heading${order.id}" data-bs-toggle="collapse" data-bs-target="#collapse${order.id}" ${ is_collapsed ? 'aria-expanded="true"' : '' }>
                    //         <td class="p-0">
                    //             <div class="d-flex justify-content-between align-items-center">
                    //                 <div class="d-flex flex-column">
                    //                     <div>
                    //                         <span class="h-label h-symbol">${order.pair.symbol.replace('_', '/')},</span>
                    //                         <span class="${ total_price < 0 ? 'negative' : 'text-primary'}">${order.custom_order_side_badge}</span>
                    //                         <span class="h-label">${removeTrailingZeros(order.no_of_lot)}</span>
                    //                     </div>
                    //                     <div>
                    //                         <span class="h-label">${parseFloat(order.rate).toFixed(decimalCount)}</span>
                    //                         <span class="h-label">&rarr;</span>
                    //                         <span class="h-label" >${current_price}</span>
                    //                     </div>
                    //                 </div>
                    //                 <div>
                    //                     <span class="${ total_price < 0 ? 'negative' : 'text-primary'}">
                    //                         <label class="${ total_price < 0 ? 'negative' : 'text-primary'}">${parseFloat(total_price).toFixed(decimalCount)}</label>
                    //                     </span>
                    //                 </div>
                    //             </div>     
                    //             <div id="collapse${order.id}" class="collapse order-collapse ${ is_collapsed ? 'show' : '' } py-2" aria-labelledby="heading${order.id}">
                    //                 <div class="d-flex @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif">
                    //                     <strong>@lang('Actions') @if (App::getLocale() != 'ar') : @endif </strong> &nbsp&nbsp ${buttonStopLoss} &nbsp&nbsp ${buttonTakeProfit} &nbsp&nbsp ${button}
                    //                 </div>
                    //             </div>
                    //         </td>
                    //     </tr>
                    //     `;
                    // }
                    return `
                        <tr class="clickable-row clickable-header flex flex-column" id="heading${order.id}" data-bs-toggle="collapse" data-bs-target="#collapse${order.id}" ${ is_collapsed ? 'aria-expanded="true"' : '' }>
                            <td class="p-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <div>
                                            <span class="h-label h-symbol">${order.pair.symbol.replace('_', '/')},</span>
                                            <span class="${ total_price < 0 ? 'negative' : 'text-primary'}">${order.custom_order_side_badge}</span>
                                            <span class="h-label">${removeTrailingZeros(order.no_of_lot)}</span>
                                        </div>
                                        <div>
                                            <span class="h-label">${parseFloat(order.rate).toFixed(decimalCount)}</span>
                                            <span class="h-label">&rarr;</span>
                                            <span class="h-label" >${current_price}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="${ total_price < 0 ? 'negative' : 'text-primary'}">
                                            <label class="${ total_price < 0 ? 'negative' : 'text-primary'}">${parseFloat(total_price).toFixed(2)}</label>
                                        </span>
                                    </div>
                                </div>     
                                <div id="" class="collapse order-collapse py-2" aria-labelledby="">
                                    <div class="d-flex flex-column @if (App::getLocale() == 'ar') d-flex flex-row-reverse @endif text-center">
                                        <strong class="mb-2">@lang('Actions') @if (App::getLocale() != 'ar') @endif </strong> <div class="d-flex justify-content-between">${buttonStopLoss} ${buttonTakeProfit} ${button}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        `;
                    }
            }

            function updateBalance() {
                $.ajax({
                    url: `{{ route('trade.fetchUserBalance') }}`,
                    method: 'GET',
                    success: function(response) {
                        $('#balance_span').html(
                            `<label class="${response.balance < 0 ? 'text-danger' : 'text-success'}">${formatWithPrecision1(response.balance)} $</label>`
                            );
                        $('#bonus-span').html(
                            `<label class="${response.bonus < 0 ? 'text-danger' : 'text-success'}">${formatWithPrecision1(response.bonus)} $</label>`
                            );
                        $('#credit-span').html(
                            `<label class="${response.credit < 0 ? 'text-danger' : 'text-success'}">${formatWithPrecision1(response.credit)} $</label>`
                            );
                        balance = parseFloat(response.balance) || 0
                    },
                    error: function(xhr, status, error) {}
                });
            }

            function fetchOrderHistory() {


                if (isClosingAllOrders) return;

                let actionUrl =
                    "{{ route('trade.order.list', ['pairSym' => @$pair->symbol ?? 'default_symbol', 'status' => 0]) }}";
                $.ajax({
                    url: actionUrl,
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    data: {},
                    success: function(resp) {
                        let html = '';
                        let initial_equity = Number(resp.wallet.balance) + Number(resp.wallet.bonus) +
                            Number(resp.wallet.credit)

                        equity = 0;
                        pl = 0;
                        total_open_order_profit = 0;
                        total_amount = 0;
                        total_used_margin = 0;

                        let jsonMarketData = resp.marketData;

                        let pairDecimalCount = countDecimalPlaces(jsonMarketData['{{@$pair->type}}']['{{@$pair->symbol}}'].replace(/,/g, ''));

                        if (resp.orders && resp.orders.length > 0) {
                            resp.orders.forEach(order => {
                                html += generateOrderRow(order, jsonMarketData[order.pair
                                .type]);
                            });

                            pl = total_open_order_profit;
                            equity = initial_equity + pl;
                            if (equity < 0) {
                                equity = 0;
                            }

                            $('.open-orders-count').text(`(${resp.orders.length})`)
                        } else {
                            pl = 0;
                            equity = initial_equity;

                            if (equity < 0) {
                                equity = 0;
                            }

                            html =
                                `<tr class="text-center" style="border-bottom: transparent !important;"><td colspan="13" class="text-center p-4">@lang('No order found')</td></tr>`;
                        }

                        if (resp.totalRequiredMargin === 0) {
                            margin_level = 0;
                        } else {
                            margin_level = (equity / resp.totalRequiredMargin) * 100;
                        }

                        free_margin = equity - resp.totalRequiredMargin;

                        // let level = equity * level_percent; //old formula
                        let level = level_percent * resp.totalRequiredMargin;

                        $('#used-margin-span').html(
                            `<label class="${(resp.totalRequiredMargin < 0 ? 'text-danger':'text-success')}">${formatWithPrecision1(parseFloat(resp.totalRequiredMargin))} $</label>`
                            );
                        $('#free-margin-span').html(
                            `<label class="${(free_margin < 0 ? 'text-danger':'text-success')}">${formatWithPrecision1(free_margin)} $`
                            );
                        $('#equity-span').html(
                            `<label class="${(equity < 0 ? 'text-danger':'text-success')}">${formatWithPrecision1(equity)} $</label>`
                            );
                        $('#pl-span').html(
                            `<label class="${(pl < 0 ? 'text-danger':'text-success')}">${formatWithPrecision1(pl)} $</label>`
                            );
                        $('#level-span').html(
                            `<label class="${(level < 0 ? 'text-danger':'text-success')}">${formatWithPrecision1(level)} $</label>`
                            );
                        $('#margin_level_span').html(
                            `<label class="${(margin_level < 0 ? 'text-danger':'text-success')}">${formatWithPrecision1(margin_level)} %</label>`
                            );

                        // if ((parseInt(margin_level) > 0) && (parseInt(margin_level) <=
                        //         st_level_percentage
                        //         )) { // if ST Level is equal to Margin Level, close all orders.
                        //     isClosingAllOrders = true;

                        //     closeAllOrders(resp)
                        // }
                            
                        // if ( parseInt(free_margin) < 0 || parseInt(margin_level) <= 100 ) { 
                        //     isClosingAllOrders = true;

                        //     closeAllOrders(resp)
                        // }else{
                        //     // console.log(parseInt(free_margin));
                        //     // console.log(parseInt(margin_level));
                        //     // console.log('not in criteria');
                        // }

                        closeOrdersBasedOnSLTP(resp)

                        $('.order-list-body').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching order history: ', error);
                    }
                });
            }

            fetchOrderHistory();

            setInterval(function() {

                updateBalance();
                fetchOrderHistory();

            }, 3000);

            function closeOrdersBasedOnSLTP(response) {
                const token = "{{ csrf_token() }}";
                let jsonMarketData = response.marketData;

                response.orders.forEach((order, index) => {
                    let jsonData = jsonMarketData[order.pair.type];
                    let current_price = jsonData[order.pair.symbol].replace(/,/g, '');

                    current_price = parseFloat(current_price);

                    if (parseInt(order.order_side) == 2) {
                        current_price = (current_price * order.pair.spread) + current_price;
                    }

                    let lotValue = order.pair.percent_charge_for_buy;
                    let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);
                    let total_price = parseInt(order.order_side) == 2 ?
                        formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price)) *
                            lotEquivalent)) :
                        formatWithPrecision(((parseFloat(current_price) - parseFloat(order.rate)) *
                            lotEquivalent));

                    const IS_TRUE_VALUE = 1;

                    let stopLossOperator = order.stop_loss_close_at_high === IS_TRUE_VALUE ? '<=' : '>=';
                    let takeProfitOperator = order.take_profit_close_at_high === IS_TRUE_VALUE ? '<=' :
                    '>=';

                    const compareValues = (set_price, operator, current_price) => {
                        switch (operator) {
                            case '<=':
                                return set_price <= current_price;
                            case '>=':
                                return set_price >= current_price;
                            default:
                                throw new Error('Unsupported operator');
                        }
                    };

                    // if set stop loss OR take profit price > current price; close_at_high will be true (1)
                    // if close_at_high is true (1) operator will be "<="
                    // if close_at_high is false (0) operator will be ">="

                    if (compareValues(Number(formatWithPrecision(parseFloat(order.stop_loss))),
                            stopLossOperator, Number(formatWithPrecision(current_price))) ||
                        compareValues(Number(formatWithPrecision(parseFloat(order.take_profit))),
                            takeProfitOperator, Number(formatWithPrecision(current_price)))) {

                        let actionUrl = `{{ route('user.order.close-all-orders') }}`;

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            url: actionUrl,
                            method: "POST",
                            data: {
                                id: order.id,
                                closed_price: parseFloat(current_price),
                                profit: parseFloat(total_price)
                            },
                            success: function(resp) {},
                            error: function(xhr, status, error) {
                                console.error("Error closing order: ", error);
                            }
                        });
                    }
                });
            }

            $(document).on('click', '.clickable-row', function(e){
                e.preventDefault();
                let elem = $(this).find('.order-collapse').html();
                let symbol = $(this).find('.h-symbol').text().replace(/,/g, '')
                let offcanvas = $('#trade-canvas'); // jQuery object
                let offcanvasElement = document.getElementById("trade-canvas"); // Plain JS element

                // Update offcanvas content
                $('.body-section').html(elem);
                offcanvas.find('.offcanvas-title').text(symbol);

                let parentLink = $(this);

                // Get the clicked element's position
                let rect = parentLink[0].getBoundingClientRect();
                let windowHeight = window.innerHeight;
                let offcanvasHeight = offcanvas.outerHeight();

                let topPosition;
                let spaceBelow = windowHeight - rect.bottom;
                let spaceAbove = rect.top;

                // Check if there's enough space below, otherwise place it above
                if (spaceBelow >= offcanvasHeight) {
                    topPosition = rect.bottom + window.scrollY; // Place below
                } else if (spaceAbove >= offcanvasHeight) {
                    topPosition = rect.top + window.scrollY - offcanvasHeight; // Place above
                } else {
                    topPosition = windowHeight - offcanvasHeight - 20; // Stick near bottom if no space
                }

                // Set the offcanvas position
                offcanvas.css({
                    // top: `${topPosition}px`,
                    // top: `20px`,
                    display: 'block'
                });

                // Show Bootstrap Offcanvas properly
                let bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
                bsOffcanvas.show();
            });
        });
    </script>
@endpush
@push('style')
    <style>

        .ellipsis-menu {
            font-size: 16px;
            color: white;
            cursor: pointer;
            padding-right: 10px; /* Adjust as needed for spacing */
        }

        .dashboard-card{
            padding: 20px 18px;
            background-color: hsl(var(--white) / 0.03);
            border-radius: 6px;
            transition: 0.2s linear;
        }

        .dashboard-fluid .dashboard-body .dashboard-card__coin-name {
            font-size: 12px !important;
            margin-bottom: 10px;
        }

        .dashboard-fluid .dashboard-body .dashboard-card__coin-title {
            font-size: 24px;
            margin-bottom: 0px;
        }

        span.dashboard-card__icon i {
            font-size: 45px;
            color: hsl(49 69% 45%) !important;
        }

        #tblPortfolio td{
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        .ch5-portfolio{
            border-bottom: 1px solid #3c4a54;
        }

        .label, .value-box, .c-icon, .portfolio-item, #tblPortfolio td, #tblPortfolio tr, #tblPortfolio{
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 16px;
        }

        #tblPortfolio .clickable-row{
            border-bottom:1px solid #3c4a54 !important;
        }

        .portfolio-item {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 1rem;
            color: #ffffff;
        }

        .portfolio-item .label, 
        .portfolio-item .value {
            padding: 0 5px;
            position: relative;
            z-index: 1;
        } 

        .dots {
            flex-grow: 1;
            height: 8px;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.2) 1px, transparent 4px);
            background-size: 10px;
            opacity: 0.2;
            margin: 0 20px;
        }

        .label{
            font-size: 16px;
            color: white;
        }

        
        .trade-container{
            overflow-y:scroll;
        }

        .negative, .text-danger {
            color: #c2424b !important;
        }

        .custom--modal .modal-content {
            background-color: #0d1e23 !important;
            border-radius: 10px !important;
        }

        .custom--modal .modal-title {
            color: hsl(var(--white) / 0.5);
        }

       .custom--modal .question {
            color: hsl(var(--white)) !important;
        }

    </style>

    @if (App::getLocale() == 'ar')
        <style>
           .portfolio-item {
                flex-flow: row-reverse;
            }
        </style>
    @endif
@endpush
