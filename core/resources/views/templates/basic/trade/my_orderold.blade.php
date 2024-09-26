@php
    $meta           = (object) $meta;
    $pair           = @$meta->pair;
    $balance        = @$meta->marketCurrencyWallet->balance;
    $bonus        = @$meta->marketCurrencyWallet->bonus;
    $credit        = @$meta->marketCurrencyWallet->credit;
    $order_count    = @$meta->order_count;
    $screen         = @$meta->screen;
    $requiredMarginTotal        = @$meta->requiredMarginTotal;
@endphp

{{-- Your Blade Template --}}
{{-- Blade Template for Trading Table --}}
<div class="trading-table two">
    <div class="flex-between trading-table__header">
        {{-- Header Content --}}
    </div>
    <div class="tab-content" id="pills-tabContenttwenty">
        <div class="tab-pane fade show active">
            <div class="table-wrapper-two">
                @auth
                    <table class="table table-two my-order-list-table">
                        @if(App::getLocale() == 'ar')
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('Close')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th class="text-center">@lang('Profit')</th>
                                    <th class="text-center">@lang('Take Profit')</th>
                                    <th class="text-center">@lang('Stop Loss')</th>
                                    <th class="text-center">@lang('Required Margin')</th>
                                    <th class="text-center">@lang('Current Price')</th>
                                    <th class="text-center">@lang('Open Price')</th>
                                    <th class="text-center">@lang('Volume')</th>
                                    <th class="text-center">@lang('Type')</th>
                                    <th class="text-center">@lang('Symbol')</th>
                                    <th class="text-center">@lang('Date')</th>
                                    <th class="text-center">@lang('Order ID')</th>
                                </tr>
                            </thead>
                        @else
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('Order ID')</th>
                                    <th class="text-center">@lang('Date')</th>
                                    <th class="text-center">@lang('Symbol')</th>
                                    <th class="text-center">@lang('Type')</th>
                                    <th class="text-center">@lang('Volume')</th>
                                    <th class="text-center">@lang('Open Price')</th>
                                    <th class="text-center">@lang('Current Price')</th>
                                    <th class="text-center">@lang('Required Margin')</th>
                                    <th class="text-center">@lang('Stop Loss')</th>
                                    <th class="text-center">@lang('Take Profit')</th>
                                    <th class="text-center">@lang('Profit')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th class="text-center">@lang('Close')</th>
                                </tr>
                            </thead>
                        @endif
                        <tbody class="order-list-body">
                            {{-- Rows will be added here dynamically --}}
                        </tbody>
                    </table>
                @else
                    <div class="empty-thumb">
                        <img src="{{ asset('assets/images/extra_images/user.png') }}" alt="Please login"/>
                        <p class="empty-sell" style="color:#d1d4dc">@lang('Please login to explore your order')</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
<div class="trading-table__mobile">
    <div class="card order-list-body">
      {{-- Data will be added here dynamically --}}
    </div>
</div>
@props([
    'isCustom' => false
])
@push('script')
<script>

// Formats numbers with a specified precision
function formatWithPrecision(value, precision = 5) {
    return Number(value).toFixed(precision);
}

// Formats numbers with a specified precision
function formatWithPrecision1(value, precision = 2) {
    return Number(value).toFixed(precision);
}
   
$(document).ready(function() {
    "use strict";

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

    function updateBalance() {
        $.ajax({
            url: `{{ route('trade.fetchUserBalance') }}`,
            method: 'GET',
            success: function(response) {
                $('#balance_span').html(`${formatWithPrecision1(response.balance)}`);
                $('#bonus-span').html(`${formatWithPrecision1(response.bonus)}`);
                $('#credit-span').html(`${formatWithPrecision1(response.credit)}`);
                balance = parseFloat(response.balance) || 0
            },
            error: function(xhr, status, error) {
            }
        });
    }
    
    function generateOrderRow(order, jsonData) {
        let current_price = jsonData[order.pair.symbol]
        
        let lotValue = order.pair.percent_charge_for_buy;

        let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);

        let total_price = parseInt(order.order_side) === 2
            ? formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price.replace(/,/g, ''))) * lotEquivalent))
            : formatWithPrecision(((parseFloat(current_price.replace(/,/g, '')) - parseFloat(order.rate)) * lotEquivalent));

        total_open_order_profit = parseFloat(total_open_order_profit) + parseFloat(total_price);
        total_amount = parseFloat(total_amount) + parseFloat(formatWithPrecision1(order.amount));
        
        let ll_size = parseFloat(document.querySelector('.ll-size-span').innerText);
        total_used_margin = parseFloat(total_used_margin) + (ll_size / parseFloat(order.pair.percent_charge_for_sell));
        
        let actionUrl = `{{ route('user.order.close', [ 'id' => ':id', 'order_side' => ':order_side', 'amount' => ':amount', 'closed_price' => ':closed_price', 'profit' => ':profit' ]) }}`;
    
        actionUrl = actionUrl
            .replace(':id', order.id)
            .replace(':order_side', order.order_side)
            .replace(':amount', total_price)
            .replace(':closed_price', parseFloat(current_price.replace(/,/g, '')))
            .replace(':profit', parseFloat(total_price));
            
        let button = order.status == 0 
            ? `
                <button 
                    type="button" 
                    style="font-size: 12px; border: transparent; color: white !important;"
                    class="btn btn-secondary px-4 py-2 confirmationBtn text-uppercase" 
                    data-question="@lang('Close the order now with current profit?')" 
                    data-orderid="${order.id}"
                    data-action="${actionUrl}"
                    data-title="@lang('Close Order') #${order.id}"
                    data-symbol="${order.pair.symbol.replace('_', '/')}"
                    data-open="${formatWithPrecision(order.rate)}"
                    data-curr="${current_price.replace(/,/g, '')}"
                    data-volume="${removeTrailingZeros(order.no_of_lot)}"
                    data-profit="${removeTrailingZeros(total_price)}"
                    title="Close Order"
                >@lang('Close')</button>
            ` : '';
            
        let slButtonLabel = order.stop_loss ? formatWithPrecision(order.stop_loss) : "{{ __('SL') }}";
        let tpButtonLabel = order.take_profit ? formatWithPrecision(order.take_profit) : "{{ __('TP') }}";

        let buttonStopLoss = `
            <button 
                type="button" 
                style="font-size: 12px; border: transparent; color: white !important;"
                class="btn btn-secondary px-4 py-2 stopLossModalBtn" 
                data-orderid="${order.id}"
                data-action="${actionUrl}"
                data-title="@lang('Stop Loss') #${order.id}"
                data-symbol="${order.pair.symbol.replace('_', '/')}"
                data-open="${formatWithPrecision(order.rate)}"
                data-curr="${current_price.replace(/,/g, '')}"
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
                data-open="${formatWithPrecision(order.rate)}"
                data-curr="${current_price.replace(/,/g, '')}"
                data-volume="${removeTrailingZeros(order.no_of_lot)}"
                data-profit="${removeTrailingZeros(total_price)}"
                data-equivalent="${lotEquivalent}"
                data-side="${order.order_side}"
                title="Take Profit"
            >${tpButtonLabel}</button>
        `;

        var run_time = parseFloat(document.title);
        
        let profitClass = total_price <= 0 ? 'text-danger' : 'text-success';
        
        if (window.innerWidth < 579) {
            return `
                <div class="card-header">
                    <span>#${order.id}</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Date: ${order.formatted_date}</li>
                        <li class="list-group-item">Symbol: ${order.pair.symbol.replace('_', '/')}</li>
                        <li class="list-group-item">Type: ${order.order_side_badge}</li>
                        <li class="list-group-item">Volume: ${removeTrailingZeros(order.no_of_lot)}</li>
                        <li class="list-group-item">Open Price: ${formatWithPrecision(order.rate)}</li>
                        <li class="list-group-item">Current Price: <span id="currentprice${i++}">${current_price}</span></li>
                        <li class="list-group-item">Required Margin: ${formatWithPrecision(order.required_margin)}</li>
                        <li class="list-group-item">${buttonStopLoss}</li>
                        <li class="list-group-item">${buttonTakeProfit}</li>
                        <li class="list-group-item">Profit: <span class="${profitClass}">${total_price}</span></li>
                        <li class="list-group-item">Status: ${order.status_badge}</li>
                        <li class="list-group-item">${button}</li>
                    </ul>
                </div>
            `;
        }
        
        return `
            @if (App::getLocale() != 'ar')
                <tr data-order-id="${order.id}">
                    <td class="text-center p-2">#${order.id}</td>
                    <td class="text-center p-2">${order.formatted_date}</td>
                    <td class="text-center p-2">${order.pair.symbol.replace('_', '/')}</td>
                    <td class="text-center p-2">${order.order_side_badge}</td>
                    <td class="text-center p-2">${removeTrailingZeros(order.no_of_lot)}</td>
                    <td class="text-center p-2">${formatWithPrecision(order.rate)}</td>
                    <td class="text-center p-2"><span id="currentprice${i++}">${current_price}</span></td>
                    <td class="text-center p-2">${formatWithPrecision(order.required_margin)}</td>
                    <td class="text-center p-2">${buttonStopLoss}</td>
                    <td class="text-center p-2">${buttonTakeProfit}</td>
                    <td class="text-center p-2"> <span class="${profitClass}">${total_price}</span></td>
                    <td class="text-center p-2">${order.status_badge}</td>
                    <td class="text-center p-2">${button}</td>
                </tr>
            @else
                <tr data-order-id="${order.id}">
                    <td class="text-center p-2">${button}</td>
                    <td class="text-center p-2">${order.status_badge}</td>
                    <td class="text-center p-2"> <span class="${profitClass}">${total_price}</span></td>
                    <td class="text-center p-2">${buttonTakeProfit}</td>
                    <td class="text-center p-2">${buttonStopLoss}</td>
                    <td class="text-center p-2">${formatWithPrecision(order.required_margin)}</td>
                    <td class="text-center p-2"><span id="currentprice${i++}">${current_price}</span></td>
                    <td class="text-center p-2">${formatWithPrecision(order.rate)}</td>
                    <td class="text-center p-2">${removeTrailingZeros(order.no_of_lot)}</td>
                    <td class="text-center p-2">${order.order_side_badge}</td>
                    <td class="text-center p-2">${order.pair.symbol.replace('_', '/')}</td>
                    <td class="text-center p-2">${order.formatted_date}</td>
                    <td class="text-center p-2">#${order.id}</td>
                </tr>
            @endif
        `;
    }
    
    let isClosingAllOrders = false;

    function fetchOrderHistory() {
        console.log('closing status: ' + isClosingAllOrders)
        if (isClosingAllOrders) return;

        let actionUrl = "{{ route('trade.order.list', ['pairSym' => @$pair->symbol ?? 'default_symbol', 'status' => 0 ]) }}";
        $.ajax({
            url: actionUrl,
            type: "GET",
            dataType: 'json',
            cache: false,
            data: {},
            success: function(resp) {
                let html = '';
                let initial_equity = Number(resp.wallet.balance) + Number(resp.wallet.bonus) + Number(resp.wallet.credit)

                equity = 0;
                pl = 0;
                total_open_order_profit = 0;
                total_amount = 0;
                total_used_margin = 0;

                let jsonMarketData = resp.marketData;
                
                if (resp.orders && resp.orders.length > 0) {
                    resp.orders.forEach(order => {
                        html += generateOrderRow(order, jsonMarketData[order.pair.type]);
                    });

                    pl = total_open_order_profit;
                    equity = initial_equity + pl;
                } else {
                    pl = 0;
                    equity = initial_equity;
                    
                    html = `<tr class="text-center" style="border-bottom: transparent !important;"><td colspan="13" class="text-center p-4">@lang('No order found')</td></tr>`;
                }

                if (resp.totalRequiredMargin === 0) {
                    margin_level = 0;
                } else {
                    margin_level = (equity / resp.totalRequiredMargin) * 100;
                }

                free_margin = equity - resp.totalRequiredMargin;
                let level = equity * level_percent;

                $('#used-margin-span').html(`${formatWithPrecision1(resp.totalRequiredMargin)} USD`);
                $('#free-margin-span').html(`${formatWithPrecision1(free_margin)} USD`);
                $('#equity-span').html(`${formatWithPrecision1(equity)} USD`);
                $('#pl-span').html(`${formatWithPrecision1(pl)} USD`);
                $('#level-span').html(`${formatWithPrecision1(level)} USD`);
                $('#margin_level_span').html(`${formatWithPrecision1(margin_level)} %`);

                if ((parseInt(margin_level) > 0) && (parseInt(margin_level) <= st_level_percentage)) { // if ST Level is equal to Margin Level, close all orders.
                    isClosingAllOrders = true;

                    closeAllOrders(resp)
                }

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
    }, 1500);

    function getRandomItem(arr) {
        const randomIndex = Math.floor(Math.random() * arr.length);
        const item = arr[randomIndex];
    
        return item;
    }
    
    function removeTrailingZeros(number) {
        var numberString = number.toString(); // Convert number to string to remove trailing zeros
        
        var trimmedNumberString = numberString.replace(/\.?0+$/, ''); // Remove trailing zeros
        
        var trimmedNumber = parseFloat(trimmedNumberString); // Parse back to number
        
        if (Number.isInteger(trimmedNumber)) {
            return (trimmedNumber - Math.floor(trimmedNumber)) !== 0 ? trimmedNumber.toFixed(2) : trimmedNumber.toFixed();
        }
        
        return trimmedNumber;
    }
    
    function closeAllOrders(response) {
        console.log('closing...')
        const token = "{{ csrf_token() }}";
    
        let jsonMarketData = response.marketData;
        let ajaxRequests = [];
    
        // Function to make an AJAX request for each order
        function makeAjaxRequest(order) {
            let jsonData = jsonMarketData[order.pair.type];
            let current_price = jsonData[order.pair.symbol];
            let lotValue = order.pair.percent_charge_for_buy;
            let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);
            let total_price = parseInt(order.order_side) === 2
                ? formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price.replace(/,/g, ''))) * lotEquivalent))
                : formatWithPrecision(((parseFloat(current_price.replace(/,/g, '')) - parseFloat(order.rate)) * lotEquivalent));
    
            let actionUrl = `{{ route('user.order.close-all-orders') }}`;
    
            return $.ajax({
                headers: { 'X-CSRF-TOKEN': token },
                url: actionUrl,
                method: "POST",
                data: {id: order.id, closed_price: parseFloat(current_price.replace(/,/g, '')), profit: parseFloat(total_price)},
                success: function (resp) {
                    console.log('CLOSING ORDER ' + total_price, response.wallet.balance);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching total required margin: ", error);
                },
            });
        }
    
        // Initiate AJAX requests for each order with a delay
        response.orders.forEach((order, index) => {
            ajaxRequests.push(
                new Promise((resolve) => {
                    setTimeout(() => {
                        resolve(makeAjaxRequest(order));
                    }, index * 1000);
                })
            );
        });
    
        // Wait for all AJAX requests to complete
        Promise.all(ajaxRequests).then(() => {
            setTimeout(() => {
                isClosingAllOrders = false;
                console.log('All orders have been closed.');
            }, response.orders.length * 1000 + 2000); // Adjusted delay as needed
        });
    }

    function closeOrdersBasedOnSLTP(response) {
        const token = "{{ csrf_token() }}";
        let jsonMarketData = response.marketData;
    
        response.orders.forEach((order, index) => {
            let jsonData = jsonMarketData[order.pair.type];
            let current_price = jsonData[order.pair.symbol].replace(/,/g, '');
            let lotValue = order.pair.percent_charge_for_buy;
            let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);
            let total_price = parseInt(order.order_side) == 2
                ? formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price.replace(/,/g, ''))) * lotEquivalent))
                : formatWithPrecision(((parseFloat(current_price.replace(/,/g, '')) - parseFloat(order.rate)) * lotEquivalent));

            // Check if current price matches stop loss or take profit
            // if (Number(formatWithPrecision(current_price.replace(/,/g, ''))) <= Number(formatWithPrecision(parseFloat(order.stop_loss))) || Number(formatWithPrecision(current_price.replace(/,/g, ''))) >= Number(formatWithPrecision(parseFloat(order.take_profit)))) {
            if (Number(formatWithPrecision(parseFloat(order.stop_loss))) == Number(formatWithPrecision(current_price.replace(/,/g, ''))) ||
                Number(formatWithPrecision(parseFloat(order.take_profit))) == Number(formatWithPrecision(current_price.replace(/,/g, '')))) {
                
                let actionUrl = `{{ route('user.order.close-all-orders') }}`;

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: actionUrl,
                    method: "POST",
                    data: {
                        id: order.id,
                        closed_price: parseFloat(current_price.replace(/,/g, '')),
                        profit: parseFloat(total_price)
                    },
                    success: function(resp) {
                        console.log('Order closed successfully', resp);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error closing order: ", error);
                    }
                });
            }
        });
    }
});

</script>
@endpush

@push('style')
<style>
    .custom--modal .modal-content {
        background-color: var(--pane-bg) !important;
        border-radius: 10px !important;
    }

    .custom--modal .modal-title {
        color: hsl(var(--white));
    }

    .custom--modal .modal-header,
    .custom--modal .modal-footer {
        border-color: hsl(var(--white)/0.2) !important;
    }
    
    .custom--modal .question {
         color: hsl(var(--white)) !important;
    }

    .btn-dark,
    .btn-dark:hover,
    .btn-dark:focus {
        border-color: hsl(var(--white)/0.1) !important;
        color: #ffffff !important;
    }

    .my-order-list-table {
      border-collapse: collapse !important;
    }
    
    .order-list-body > tr {
        border-bottom: 1px solid hsl(var(--base-two)/0.09) !important;
    }
    
    .delete-icon {
        visibility: visible;
        opacity: 1;
    }
</style>
@endpush
