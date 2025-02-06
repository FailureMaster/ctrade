@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <form class="buy-sell-form buy-sell buy--form" id="frmNewOrder" method="POST">
        <div class="order-container">
            @csrf
            <input type="hidden" name="order_side" value="{{ Status::BUY_SIDE_ORDER }}">
            <input type="hidden" name="order_type" value="{{ Status::ORDER_TYPE_LIMIT }}">
        
            <input type="hidden" name="order_volume_1" value="" id="order_volume_1">
            <input type="hidden" name="order_volume_2" value="" id="order_volume_2">
          
            <div class="order-header d-flex align-items-center justify-content-between">
                {{ $pair->symbol }}
                <a href="/trade/markets"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
            </div>

            <div class="order-body p-3">
                <div class="form-group">
                    <span class="text-themed mb-1" style="margin-right: 4px">
                        @lang('Volume in Lots')
                    </span>
                    <select id="lot-size-select" class="form--control style-three lot-size-select" name="amount" onchange="updateLotValues(this)" data-fee-status="{{ $fee_status }}">
                        @if ($lots && $lots->isNotEmpty())
                            @foreach ($lots as $lot)
                                @php
                                    $lot_volume_display = $lot->lot_volume;
                                    if (floor($lot->lot_volume) == $lot->lot_volume) {
                                        // No decimal places for whole numbers between 1 and 10
                                        $lot_volume_display = number_format($lot->lot_volume, 0);
                                    } else {
                                        // Keep the decimal for allowed specific values if needed
                                        $lot_volume_display = rtrim(rtrim($lot->lot_volume, '0'), '.');
                                    }
                                @endphp
                                <option value="{{ $lot->lot_value }}" {{ $lot->selected == 1 ? 'selected' : '' }}> {{ $lot_volume_display }}</option>
                            @endforeach
                        @else
                            <p>No lots available</p>
                        @endif
                    </select>
                </div>

                <small class="text-themed d-block mb-1 d-none">
                    <span class="lot-label">USD</span>:
                    <span class="lot-value">0</span>
                </small>

                <div class="d-flex align-items-center justify-content-between">
                    <div id="lot-eq-fetch">
                        <span class="lot-eq-span">{{ $pair ? $pair->percent_charge_for_buy : '0' }}</span>
                        <span class="lot-currency ms-2">{{ @$pair->coin_name }}</span>
                    </div>
                    <div id="lot-eq2-fetch">
                        <span class="ll-size-span">0</span>
                        <span>{{ @$pair->market_name }}</span>
                    </div>
                </div>
        
                <div class="mb-3">
                    <ul class="p-0 m-0">
                        <li class="mt-1 pt-1 d-flex flex-column gap-2">
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

                <div class="sl-tp-section my-3">
                    {{-- <div class="text-center">
                        <span class="sl-price">1.0396<sup>4</sup></span>
                        <span class="mx-3 tp-price">1.0396<sup>8</sup></span>
                    </div> --}}
            
                    <div class="mt-2 d-flex">
                        <div class="input-group">
                            <button class="btn btn-update btn-outline-secondary" type="button" data-type="decrement" data-trigger="0">-</button>
                            <input type="number" name="sl" class="form-control text-center tp-sl" value="" placeholder="SL">
                            <button class="btn btn-update btn-outline-secondary" type="button" data-type="increment" data-trigger="0">+</button>
                        </div>
                        <div class="input-group mx-2">
                            <button class="btn btn-update btn-outline-secondary" type="button" data-type="decrement" data-trigger="0">-</button>
                            <input type="number" name="tp" class="form-control text-center tp-sl" placeholder="TP">
                            <button class="btn btn-update btn-outline-secondary" type="button" data-type="increment" data-trigger="0">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex btn-container">
                <button class="btn-modal-sell btn btn--danger w-100 btn--sm sell-btn btn-submit" type="button" id="sellButton" data-orderside="2">
                    <span class="action-btn">@lang('SELL')</span>
                    <input type="number" step="any" class="form--control style-three sell-rate"
                        name="sell_rate" id="sell-rate" style="display: none;">
                    <span id="sellSpan" style="color:white;display: block"></span>
                </button>
                <div style="margin: 0 2px;"></div>
                <button class="btn-modal-buy btn btn--base-two w-100 btn--sm buy-btn btn-submit" type="button" id="buyButton" data-orderside="1">
                    <span class="action-btn">@lang('BUY')</span>
                    <input type="number" step="any" class="form--control style-three buy-rate" name="buy_rate" id="buy-rate" style="display: none;">
                    <span id="buySpan" style="color:white;display: block"></span>
                </button>
            </div>
            <span id="level-span" class="d-none"></span>
            <span id="equity-span" class="d-none"></span>
            <span id="used-margin-span" class="d-none"></span>
            <span id="free-margin-span" class="d-none"></span>
        </div>
    </form>
@endsection

@push('style')
    <style>
        .price { font-size: 24px; font-weight: bold; color: red; }
        .btn-order { width: 100%; padding: 15px; font-size: 18px; font-weight: bold; }
        .input-group-text { width: 50px; text-align: center; }

        .order-header{
            height:40px;
            background-color: #ffffff;
            color: #000000;
            padding: 1rem;
            margin-bottom:1rem;
        }

        .order-container{
            background-color:#0d1e23;
            position:relative;
            height:100vh;
        }

        [data-theme=light] .order-container {
            background-color: #ffffff;
        }

        .lot-size-select{
            height: 40px; 
            width: 50px;
            min-width: 70% !important;
        }

        .input-group > button{
            padding: .6rem;
            color:#ffffff !important;
            border-color: hsl(var(--white) / 0.2);
        }

        .btn-container{
            position:absolute;
            bottom:100px;
            right:0;
            left:0;
        }

        [data-theme=dark] .order-container{
            color:#ffffff;
        }

        .input-group input {
            background-color: transparent;
            color: hsl(var(--white));
            border-color: hsl(var(--white) / 0.2);
        }

        .btn-outline-secondary:active{
            color: hsl(var(--white));
            border-color: hsl(var(--white) / 0.2);
        }

        [data-theme=light] .btn-outline-secondary {
            color: #000000 !important;
        }

        [data-theme=light] .action-btn{
            color: #ffffff;
        }
    </style>

    @if(App::getLocale() == "ar")
        <style>
            .btn-modal-sell,
            .btn-modal-buy {
                padding: 5px 10px !important
            }

            .action-btn{
                font-size: 1.4rem !important;
                margin-top: -5px;
                margin-bottom: 5px;
            }
        </style>
    @endif
@endpush

@push('script')
    <script>
        let global_current_price = 0;
        let updateCurrentPrice = false;

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
        
        // Formats numbers with a specified precision
        function formatWithPrecision(value, precision = 5) {
            return Number(value).toFixed(precision);
        }

        // Formats numbers with a specified precision
        function formatWithPrecision1(value, precision = 2) {
            return Number(value).toFixed(precision);
        }

        function calculateBuyValue(buyPrice) {
            // return (buyPrice * `{{ @$pair->spread }}`) + buyPrice; // old formula
            let spread = {{ @$pair->spread }}; // Get spread from Laravel
            return buyPrice + spread; // Spread as fixed amount
        }

        function calculateSellValue(sellPrice) {
            let spread = {{ @$pair->spread }}; // Get spread from Laravel
            return sellPrice - spread; // Subtract the spread from the sell price
        }

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

            if( sellSpan == null || buySpan == null ){
                return false;
            }

            let sellRate = document.querySelector(".sell-rate");
            let buyRate = document.querySelector(".buy-rate");

            // let buyDecimal = countDecimalPlaces(sellValue);
            let buyDecimal = countDecimalPlaces(currentPrice);

            let adjustedBuyValue = buyValue;

            if (coin_symbol === 'GOLD') {
                if (buyDecimal == 0) {
                    sellSpan.innerText = sellValue;
                    buySpan.innerText = buyValue;
                    adjustedBuyValue = removeTrailingZeros(buyValue);
                } else {
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
                    global_current_price = current_price;
                    updateSpanValues(current_price);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching order history: ", error);
                }
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

                    closeOrdersBasedOnSLTP(resp)

                    $('.order-list-body').html(html);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching order history: ', error);
                }
            });
        }

        function loadCurrentPrice(){
            if( updateCurrentPrice ){
                let checkPrice = global_current_price;

                if( checkPrice != null && global_current_price != 0 ){
                    global_current_price = parseFloat(global_current_price.replace(/,/g, ''));
                    $('input[data-run="1"]').val(global_current_price);
                }
            }
        }

        $(document).ready(function(){

            updateLotValues(document.querySelector(".lot-size-select"));

            $(document).on('input', '.tp-sl', function(){
                updateCurrentPrice = false;
                $(this).attr('data-run', 0);
            })

            $(document).on('click', '.tp-sl', function(){
                updateCurrentPrice = true;
                $(this).attr('data-run', 1);
            })

            setInterval(function func() {
                fetchSymbolCurrentPrice();
                updateLLSize();

                loadCurrentPrice();

                return func;
            }(), 1000);

            $(document).on('click', '.btn-update', function(){
                let type = $(this).attr('data-type');
                let val = $(this).parent().find('input').val();

                let isTrigger = $(this).attr('data-trigger');

                if( isTrigger != 1 ){
                    updateCurrentPrice = true;
                    $(this).parent().find('input').attr('data-run', 1);
                    $(this).parent().find('.btn-update').attr('data-trigger', 1);

                    loadCurrentPrice();
                }

                updateCurrentPrice = false;
                $(this).parent().find('input').attr('data-run', 0);

                val = ( val == "" ? 0 : val );
                
                if( val > 0 ){
                    if( type == "decrement" ){
                        let value = parseFloat(val) - 0.0001;
                        $(this).parent().find('input').val(Number(value).toFixed(5));
                    }
                    else if( type == "increment" ){
                        let value = parseFloat(val) + 0.0001;
                        $(this).parent().find('input').val(Number(value).toFixed(5));
                    }
                }
            })

            $(document).on('click', '.btn-submit', function() {
                let formData      = new FormData($('#frmNewOrder')[0]);
                let action        = "{{ route('user.order.save', ':symbol') }}";
                let symbol        = "{{ @$pair->symbol }}";
                let token         = $('#frmNewOrder').find('input[name=_token]');
                let orderSide     = $(this).attr('data-orderside');

                let cancelMessage = "@lang('Are you sure to Close this order?')";
                let actionCancel  = "{{ route('user.order.cancel',':id') }}";
                formData.set("order_side", orderSide); 
                $('input[name="orderside"]').remove();
                
                let select = document.querySelector(".lot-size-select");
                let selectedOption = select.options[select.selectedIndex];
                let selectedLotText = selectedOption.textContent;
                formData.set("no_of_lot", parseFloat(selectedLotText));
                
                let level = document.querySelector('#level-span').innerText.replace(/ USD/g, "");
                let equity = document.querySelector('#equity-span').innerText.replace(/ USD/g, "");
                let used_margin = document.querySelector('#used-margin-span').innerText.replace(/ USD/g, "");
                let free_margin = document.querySelector('#free-margin-span').innerText.replace(/ USD/g, "");
                let required_margin = document.querySelector(".required-margin-value").innerText.replace(/ USD/g, "");
                // let level_equity_threshold = parseFloat({{$level_equity_threshold}}) / 100;
                let used_margin_equity_threshold = parseFloat({{$used_margin_equity_threshold}}) / 100;

                // New computation
                let margin_level = ( parseFloat(equity) / parseFloat(used_margin) ) * 100;

                // New added for volumen display
                let l1 = $('#lot-eq-fetch').text().trim();
                let l2 = $('#lot-eq2-fetch').text().trim();
                formData.set("order_volume_1", l1); 
                formData.set("order_volume_2", l2); 

                if (parseFloat(level) >= parseFloat(equity)) {
                    toastr('error', 'Unable to open an order: Level is already below or equal to the 10% of the equity. Need to increase your balance.');
                    return;
                }

                if ( margin_level < 100 ) {
                    toastr('error', 'You do not have enough equity to open this order.');
                    return;
                }
                
                if (parseFloat(free_margin) <= parseFloat(required_margin)) {
                    toastr('error', 'You do not have enough margin to open this order.');
                    return;
                }
                
                formData.set("required_margin", required_margin);
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: action.replace(':symbol', symbol),
                    method: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        if (parseInt(orderSide) === 1) {
                            $('.buy-btn').append(` <i class="fa fa-spinner fa-spin"></i>`);
                            $('.buy-btn').attr('disabled', true);
                        } 
                        if (parseInt(orderSide) === 2) {
                            $('.sell-btn').append(` <i class="fa fa-spinner fa-spin"></i>`);
                            $('.sell-btn').attr('disabled', true);
                        }
                    },
                    complete: function() {
                        if (parseInt(orderSide) === 1) {
                            $('.buy-btn').find(`.fa-spin`).remove();
                            $('.buy-btn').attr('disabled', false);
                        }
                        if (parseInt(orderSide) === 2) {
                            $('.sell-btn').find(`.fa-spin`).remove();
                            $('.sell-btn').attr('disabled', false);
                        }
                    },
                    success: function(resp) {
                        if (resp.success) {
                            $('.avl-market-cur-wallet').text(formatWithPrecision1(resp.data.wallet_balance));

                            notify('success', resp.message);

                            setTimeout(() => {
                                window.location.href = '/trade/open_orders'
                            }, 1000);
                        } else {
                            notify('error', resp.message);
                        }

                        // Redirect to trade page
                        $("#trade-btn-pill").trigger("click");
                    },
                    error: function(e) {
                        notify("@lang('Something went to wrong')")
                    }
                });
            });
        })
    </script>
@endpush