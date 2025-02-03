@extends($activeTemplate . 'layouts.frontend')

@section('content')
<div class="closed-container">
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

{{-- Menu --}}
@include($activeTemplate . 'partials.mobile.menu')
@endsection

@push('style')
    <style>
        .history-table thead tr th {
            font-size: 0.875rem !important;
        }
        .history-body>tr>td {
            border-bottom: 1px solid #3c4a54 !important;
        }
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

        
        .dots {
            flex-grow: 1;
            height: 8px;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.2) 1px, transparent 4px);
            background-size: 10px;
            opacity: 0.2;
            margin: 0 20px;
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

        .dropdown-container>.tab-pane>div {
            max-height: 613px;
            overflow-y: scroll;
        }

        .closed-container{
            overflow-y:scroll;
        }

        .negative, .text-danger {
            color: #c2424b !important;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function(){

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
                                        <label class="${ order.profit < 0 ? 'negative' : 'text-primary'}">${parseFloat(order.profit).toFixed(decimalCount) || 0}</label>
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
                                    <strong>@lang('Profit'):</strong> <label class="${profitClass}">${parseFloat(order.profit).toFixed(decimalCount) || 0}</label><br>
                                    @else
                                        <label class="${profitClass}">${parseFloat(order.profit).toFixed(decimalCount) || 0}</label>:<strong>@lang('Profit')</strong><br>
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

                function formatWithPrecision(value, precision = 5) {
                    // Formats numbers with a specified precision
                    return Number(value).toFixed(precision);
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

                $(document).off('click', '#mobileDateFilterDropdown .dropdown-item').on('click', '#mobileDateFilterDropdown .dropdown-item', function(e) {
                
                    $('.dropdown-item').removeClass('active');
                    
                    $(this).addClass('active');

                    let loadhistory = 0;

                    if( loadhistory == 0 ){
                        fetchHistory();
                        loadhistory = 1;
                    }
                })
        })
    </script>
@endpush
