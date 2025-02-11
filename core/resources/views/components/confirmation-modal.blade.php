@props([
    'isCustom' => false
])
<div id="confirmationModal" class="modal fade @if($isCustom) custom--modal  @endif" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-2">
                <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="color: hsl(var(--white))">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body pt-0">
                    <table class="table table-close-order">
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
                        <tbody>
                            @if (App::getLocale() != 'ar')
                                <tr>
                                    <td class="symbol-modal text-center"></td>
                                    <td class="open-price-modal text-center"></td>
                                    <td class="close-current-price-modal text-center"></td>
                                    <td class="volume-modal text-center"></td>
                                </tr>
                            @else
                                <tr>
                                    <td class="volume-modal text-center"></td>
                                    <td class="close-current-price-modal text-center"></td>
                                    <td class="open-price-modal text-center"></td>
                                    <td class="symbol-modal text-center"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    
                    <div class="mb-3"></div>
                    
                    <p class="question text-center"></p>
                    
                    <div class="mb-1"></div>
                    
                    <h3 class="profit-modal text-center"></h3>
                    
                    <div class="mb-3"></div>
                    <input type="hidden" id="orderId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn {{ $isCustom ? 'btn-dark btn--dark btn--sm' :  'btn--dark' }}" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn {{ $isCustom ? 'btn--base btn--sm' :  'btn--primary' }}  ">@lang('Yes')</button>
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
        var intervalId; // Define intervalId globally
    
        function updateModalContent(order, jsonData) {
            var modal = $('#confirmationModal');
    
            let current_price = jsonData[order.pair.symbol].replace(/,/g, '');

            let decimalCount    = countDecimalPlaces(current_price);
            
            current_price = parseFloat(current_price);
            
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

            let lotValue = order.pair.percent_charge_for_buy;

            if( order.lot_value != null ){
                lotValue = order.lot_value;
            }
    
            let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);
            // let total_price = parseInt(order.order_side) === 2
            //     ? formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price.replace(/,/g, ''))) * lotEquivalent))
            //     : formatWithPrecision(((parseFloat(current_price.replace(/,/g, '')) - parseFloat(order.rate)) * lotEquivalent));

            let total_price = parseInt(order.order_side) === 2 ?
                formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price)) * lotEquivalent)) :
                formatWithPrecision(((parseFloat(current_price) - parseFloat(order.rate)) * lotEquivalent));
    
            let profitModal = modal.find('.profit-modal');
            // let profitValue = formatWithPrecision1(total_price);
            let profitValue = parseFloat(total_price).toFixed(decimalCount);

            profitModal.text(`\$ ${profitValue}`);
    
            if (parseFloat(profitValue) <= 0) {
                profitModal.removeClass('text-success').addClass('text-danger'); // Add red class for negative profit
            } else if (profitValue > 0) {
                profitModal.removeClass('text-danger').addClass('text-success'); // Add green class for positive profit
            }
            $('#confirmationModal .close-current-price-modal').text(`${current_price}`);
        }
    
        $(document).on('click','.confirmationBtn', function () {
            var modal = $('#confirmationModal');
            let data = $(this).data();
    
            // Clear previous interval if exists
            clearInterval(intervalId);
    
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            modal.find('.modal-title').text(`${data.title}`);
            modal.find('.symbol-modal').text(`${data.symbol}`);
            modal.find('.open-price-modal').text(`${data.open}`);
            modal.find('.close-current-price-modal').text(`${data.curr}`);
            modal.find('.volume-modal').text(`${data.volume}`);
    
            let profitModal = modal.find('.profit-modal');
            let profitValue = formatWithPrecision1(data.profit);
            profitModal.text(`\$ ${profitValue}`);
    
            if (parseFloat(profitValue) <= 0) {
                profitModal.removeClass('text-success').addClass('text-danger'); // Add red class for negative profit
            } else if (profitValue > 0) {
                profitModal.removeClass('text-danger').addClass('text-success'); // Add green class for positive profit
            }
    
            // Start interval to update modal content
            intervalId = setInterval(function () {
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
    
        $('#confirmationModal form').on('submit', function (e) {
            var form = $(this);
            var submitBtn = form.find('[type="submit"]');
            submitBtn.prop('disabled', true); 
    
            submitBtn.append(' <i class="fa fa-spinner fa-spin"></i>');

            sessionStorage.setItem("confirmClose", "true");
    
            setTimeout(function () {
                submitBtn.prop('disabled', false);
                submitBtn.html('@lang("Yes")');
            }, 2000);
        });
    
        $('.close').on('click', function (e) {
            var modal = $('#confirmationModal');
    
            // Clear all text content
            modal.find('.question').text('');
            modal.find('.modal-title').text('');
            modal.find('.symbol-modal').text('');
            modal.find('.open-price-modal').text('');
            modal.find('.close-current-price-modal').text('');
            modal.find('.volume-modal').text('');
            modal.find('.profit-modal').text('');
    
            // Reset profit modal class
            modal.find('.profit-modal').removeClass('text-success text-danger');
    
            // Stop the interval if it's running
            clearInterval(intervalId);
        });

        function formatWithPrecision1(value, precision = 2) {
            return Number(value).toFixed(precision);
        }
    
    })(jQuery);
</script>
@endpush
