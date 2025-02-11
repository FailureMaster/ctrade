<div id="stopLossModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: var(--pane-bg) !important">
            <div class="modal-header pb-2">
                <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="stopLossModal-form">
                @csrf
                <div class="modal-body pt-0">
                    <table class="table table-sltp pb-2">
                        <thead>
                            @if (App::getLocale() != 'ar')
                                <tr>
                                    <th class="text-center">@lang('Symbol')</th>
                                    <th class="text-center">@lang('Open Price')</th>
                                    <th class="text-center">@lang('Current Price')</th>
                                    <th class="text-center">@lang('Volume')</th>
                                </tr>
                            @else
                                <tr>
                                    <th class="text-center">@lang('Volume')</th>
                                    <th class="text-center">@lang('Current Price')</th>
                                    <th class="text-center">@lang('Open Price')</th>
                                    <th class="text-center">@lang('Symbol')</th>
                                </tr>
                            @endif
                        </thead>
                        <tbody style="background-color: var(--pane-bg) !important">
                            @if (App::getLocale() != 'ar')
                                <tr>
                                    <td class="symbol-modal text-center" style="color: hsl(var(--white));"></td>
                                    <td class="open-price-modal text-center" style="color: hsl(var(--white));"></td>
                                    <td class="stop-loss-current-price-modal text-center" style="color: hsl(var(--white));"></td>
                                    <td class="volume-modal text-center" style="color: hsl(var(--white));"></td>
                                </tr>
                            @else
                                <tr>
                                    <td class="volume-modal text-center" style="color: hsl(var(--white));"></td>
                                    <td class="stop-loss-current-price-modal text-center" style="color: hsl(var(--white));"></td>
                                    <td class="open-price-modal text-center" style="color: hsl(var(--white));"></td>
                                    <td class="symbol-modal text-center" style="color: hsl(var(--white));"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    
                    <div class="container">
                        <div class="mb-3">
                            <div class="label mb-2 @if(App::getLocale() == 'ar') text-end @endif">@lang('Pips')</div>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center w-100">
                                    <div class="input-group" style="flex: 1">
                                        <input type="number" name="pips" value="10" class="form-control slpips">
                                        <span class="input-group-text" id="incrementslpips">+</span>
                                        <span class="input-group-text" id="decrementslpips">-</span>
                                    </div>
                                    <div style="margin: 0 10px; color: hsl(var(--white))">
                                        <span>@lang('Value')</span>
                                    </div>
                                    <div class="value-container" style="flex: 1">
                                        <span>-$</span>
                                        <span class="slpipsequivalent">
                                            100
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="label mb-2 @if(App::getLocale() == 'ar') text-end @endif">@lang('Price ')</div>
                            <div class="input-group">
                                <input type="text" name="price" class="form-control slprice">
                                <input type="hidden" class="sl-order-id-hidden-i">
                                <input type="hidden" class="sl-order-side-hidden-i">
                                <input type="hidden" class="sl-lot-equivalent-hidden-i">
                                <span class="input-group-text" id="incrementslprice">+</span>
                                <span class="input-group-text" id="decrementslprice">-</span>
                            </div>
                        </div>
                        <div>
                            <div class="label mb-2 @if(App::getLocale() == 'ar') text-end @endif">@lang('P&L Value')</div>
                            <div class="value-container w-100">
                                <span>-$</span>
                                <span class="plvalue" data-dcount=""></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block mx-auto saveStopLoss">@lang('Submit Changes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
    (function ($) {
        "use strict";
    
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
        var intervalIdSL; // Define intervalIdSL globally
    
        let isSLUpdateModalContent = true;
    
        $(document).ready(function() {
            $('#incrementslpips').on('click', incrementPips);
            $('#decrementslpips').on('click', decrementPips);
            $('.slpips').on('input', handlePipsInput);
    
            $('#incrementslprice').on('click', incrementPrice);
            $('#decrementslprice').on('click', decrementPrice);
            $('.slprice').on('input', handlePriceInput);
    
            function incrementPips() {
                isSLUpdateModalContent = true;
                let value = parseInt($('.slpips').val()) + 1;
                $('.slpips').val(value);
                $('.slpipsequivalent').text(value * 10);
    
                recalculatePLValue();
            }
    
            function decrementPips() {
                isSLUpdateModalContent = true;
                let value = parseInt($('.slpips').val()) - 1;
                if (value < 0) value = 0;
                $('.slpips').val(value);
                $('.slpipsequivalent').text(value * 10);
    
                recalculatePLValue();
            }
    
            function handlePipsInput() {
                let value = parseInt($('.slpips').val());
                if (isNaN(value) || value < 0) value = 0;
                $('.slpips').val(value);
                $('.slpipsequivalent').text(value * 10);
            }
    
            function incrementPrice() {
                isSLUpdateModalContent = false;
                let value = parseFloat($('.slprice').val()) + 0.0001;
                $('.slprice').val(Number(value).toFixed(5));
    
                recalculatePLValue();
            }
    
            function decrementPrice() {
                isSLUpdateModalContent = false;
                let value = parseFloat($('.slprice').val()) - 0.0001;
                if (value < 0) value = 0;
                $('.slprice').val(Number(value).toFixed(5));
    
                recalculatePLValue();
            }
    
            function handlePriceInput() {
                isSLUpdateModalContent  = false;
                let value               = $('.slprice').val();
                value                   = value.replace(/[^0-9.]/g, '');
                if (isNaN(parseFloat(value)) || parseFloat(value) < 0) value = 0;
                $('.slprice').val(value);
    
                recalculatePLValue();
            }
    
            function recalculatePLValue() {
                let order           = $('.sl-order-side-hidden-i').val();
                let lot_equivalent  = $('.sl-lot-equivalent-hidden-i').val();
                let open_price      = parseFloat($('.open-price-modal').text());
                let value           = parseFloat($('.slprice').val());
    
                let plValue         = Math.abs(calculatePLValue(order, lot_equivalent, open_price, value)) + parseInt($('.slpipsequivalent').text())

                let dcount          =  $('.plvalue').attr('data-dcount');
    
                $('.plvalue').text(`${plValue.toFixed(dcount)}`);
            }
    
            $('.saveStopLoss').on('click', function() {
                var submitBtn       = $(this);

                submitBtn.prop('disabled', true); 
                submitBtn.append(' <i class="fa fa-spinner fa-spin"></i>');
                
                let current_price   = parseFloat($('.stop-loss-current-price-modal').text());
                let price           = parseFloat($('.slprice').val());
                
                let stop_loss_close_at_high = current_price > price ? 0 : 1;

                $.ajax({
                    type:"POST",
                    url:"{{route('user.order.stop.loss')}}",
                    data:{
                        id : $('.sl-order-id-hidden-i').val(),
                        price: price,
                        stop_loss_close_at_high: stop_loss_close_at_high,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(data){
                        notify('success','Stop Loss Value Saved!');
                        submitBtn.prop('disabled', false);
                        submitBtn.html('Submit Changes');
                        $('#stopLossModal').modal('hide');
                    }
                });
            });
    
            $('#stopLossModal').on('hidden.bs.modal', function () {
                $(this).find('.current-price-modal').text('');
                clearInterval(intervalIdSL);
                $(this).find('form').trigger('reset');
                 isSLUpdateModalContent = true;
            });
        });
    
        function updateModalContent(order, jsonData) {
            var modal           = $('#stopLossModal');

            let current_price   = jsonData[order.pair.symbol].replace(/,/g, '');

            let decimalCount    = countDecimalPlaces(current_price);
            
            current_price       = parseFloat(current_price);

            // let decimalCount    = countDecimalPlaces(current_price);

            let spread = order.pair.spread;
                
            if( order.order_spread != null ){
                spread = order.order_spread;
            }

            // Current Price Formula
            if (parseInt(order.order_side) === 1) 
                current_price = (current_price - parseFloat(spread));
            else
                current_price = (current_price + parseFloat(spread));

            current_price = parseFloat(current_price).toFixed(decimalCount);
            
            let lotValue            = order.pair.percent_charge_for_buy;

            if( order.lot_value != null ){
                lotValue = order.lot_value;
            }
            
            let lotEquivalent       = parseFloat(lotValue) * parseFloat(order.no_of_lot);
            let total_price         = parseInt(order.order_side) === 2
                ? formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price)) * lotEquivalent))
                : formatWithPrecision(((parseFloat(current_price) - parseFloat(order.rate)) * lotEquivalent));
    
            if (isSLUpdateModalContent) {
                $('#stopLossModal .stop-loss-current-price-modal').text(`${current_price}`);
                $('.slprice').val(`${current_price}`);

                let plValue = parseInt($('.slpipsequivalent').text()) + Math.abs(total_price);
                let dcount  =  $('.plvalue').attr('data-dcount');
                $('.plvalue').text(`${plValue.toFixed(dcount)}`);
               
            }
        }
    
        $(document).on('click','.stopLossModalBtn', function () {
            var modal   = $('#stopLossModal');
            let data    = $(this).data();
            
            // Clear previous interval if exists
            clearInterval(intervalIdSL);
    
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            modal.find('.modal-title').text(`${data.title}`);
            
            modal.find('.symbol-modal').text(`${data.symbol}`);
            modal.find('.open-price-modal').text(`${data.open}`);
            modal.find('.stop-loss-current-price-modal').text(`${data.curr}`);
            modal.find('.volume-modal').text(`${data.volume}`);
    
            modal.find('.slprice').val(`${data.curr}`);
            modal.find('.sl-order-id-hidden-i').val(`${data.orderid}`);
            modal.find('.sl-order-side-hidden-i').val(`${data.side}`);
            modal.find('.sl-lot-equivalent-hidden-i').val(`${data.equivalent}`);
    
            let plValue = parseInt(100) + parseFloat(Math.abs(calculatePLValue(data.order, data.equivalent, data.open, data.curr)))
    
            modal.find('.plvalue').text(`${plValue}`);
            modal.find('.plvalue').attr('data-dcount', countDecimalPlaces(plValue));
            
    
            // Start interval to update modal content
            intervalIdSL = setInterval(function () {
                let actionUrl = `{{ route('trade.order.fetchModalProfit', ['id' => ':id']) }}`
                actionUrl = actionUrl.replace(':id', data.orderid)
    
                $.ajax({
                    url: actionUrl,
                    method: 'GET',
                    success: function(response) {
                        let jsonMarketData = response.marketData;
                        let order = response.order;
    
                        updateModalContent(order, jsonMarketData[order.pair.type]);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }, 1000);
            
            modal.modal('show');
        });
    
        function calculatePLValue(orderSide, lotEquivalent, rate, currentPrice) {
            let totalPrice = parseInt(orderSide) == 2
                ? formatWithPrecision(((parseFloat(rate) - parseFloat(currentPrice)) * lotEquivalent))
                : formatWithPrecision(((parseFloat(currentPrice) - parseFloat(rate)) * lotEquivalent));
    
            return totalPrice;
        }
    
        function formatWithPrecision(value, precision = 5) {
            return Number(value).toFixed(precision);
        }
    })(jQuery);
</script>
@endpush

@push('style')
<style>
    #stopLossModal .modal-title,
    #stopLossModal .close {
        color: hsl(var(--white));
    }

    #stopLossModal .table-sltp thead tr th {
        background-color: var(--pane-bg) !important;
        padding: 10px 3px;
    }

    .stopLossModal-form input,
    .stopLossModal-form .input-group-text {
        background-color: transparent;
        color: hsl(var(--white));
        border-color: hsl(var(--white) / 0.2);
    }

    .stopLossModal-form .label {
        color: hsl(var(--white));
    }

    .stopLossModal-form .value-container {
        display: flex;
        align-items: center;
        height: 2.8em;
        padding: 0 .7em;
        color: hsl(var(--white));
        background-color: var(--pane-bg-secondary);
        border-color: hsl(var(--white) / 0.2);
        border-radius: .25rem;
    }

    #incrementslpips,
    #decrementslpips,
    #incrementslprice,
    #decrementslprice {
        cursor: pointer;
    }
</style>
@endpush