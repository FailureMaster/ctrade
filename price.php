@php
    $meta = (object) $meta;
    $pair = @$meta->pair;

    $symbol = str_replace("_", "", $pair->symbol);
    $listed_market_name = $pair->listed_market_name;

<div class=" @if (@$meta->screen == 'small') col-sm-12 d-xl-none d-block @else d-xl-block d-none @endif ">
    <div class="trading-header skeleton selected-pair">
        <iframe id="priceIframe" src="https://crm.daimondrock.com/singleticker.html?locale=en&listed_market_name={{ $listed_market_name }}&symbol= EURUSD " frameborder="0" style="width: 100%; height: 60px;"></iframe>
    </div>
</div>


