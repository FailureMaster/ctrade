@php
 $meta   = (object) $meta;
 $pair   = $meta->pair;
 $widget = $general->trading_view_widget;

 $symbol = str_replace("_","",$pair->symbol);
 $widget = str_replace('{{pair}}',$symbol,$widget);
 $widget = str_replace('{{pairlistingmarket}}',$pair->listed_market_name,$widget);
@endphp
<div class="trading-chart  p-0 two">
    <iframe class="ichart chart-dark" src='https://www.tradingview-widget.com/embed-widget/advanced-chart/?login=user1&password=dfkjhoijogpoi&locale=en#%7B"symbol"%3A"{{$pair->listed_market_name}}%3A{{$symbol}}"%2C"frameElementId"%3A"tradingview_7abd4"%2C"interval"%3A"5"%2C"hide_side_toolbar"%3A"0"%2C"allow_symbol_change"%3A"8"%2C"save_image"%3A"1"%2C"studies"%3A"%5B%5D"%2C"theme"%3A"dark"%2C"style"%3A"1"%2C"timezone"%3A"Etc%2FUTC"%2C"studies_overrides"%3A"%7B%7D"%2C"utm_source"%3A"swf.centersooq.com"%2C"utm_medium"%3A"widget_new"%2C"utm_campaign"%3A"chart"%2C"utm_term"%3A"{{$pair->listed_market_name}}%3A{{$symbol}}"%2C"page-uri"%3A"swf.centersooq.com%2Ftrade%3Ftvwidgetsymbol%3D{{$pair->listed_market_name}}%253A{{$symbol}}"%7D' width="100%" height="550px" frameborder="0" target="_self"></iframe>
    <iframe class="ichart chart-light" src='https://www.tradingview-widget.com/embed-widget/advanced-chart/?login=user1&password=dfkjhoijogpoi&locale=en#%7B"symbol"%3A"{{$pair->listed_market_name}}%3A{{$symbol}}"%2C"frameElementId"%3A"tradingview_7abd4"%2C"interval"%3A"5"%2C"hide_side_toolbar"%3A"0"%2C"allow_symbol_change"%3A"8"%2C"save_image"%3A"1"%2C"studies"%3A"%5B%5D"%2C"theme"%3A"light"%2C"style"%3A"1"%2C"timezone"%3A"Etc%2FUTC"%2C"studies_overrides"%3A"%7B%7D"%2C"utm_source"%3A"swf.centersooq.com"%2C"utm_medium"%3A"widget_new"%2C"utm_campaign"%3A"chart"%2C"utm_term"%3A"{{$pair->listed_market_name}}%3A{{$symbol}}"%2C"page-uri"%3A"swf.centersooq.com%2Ftrade%3Ftvwidgetsymbol%3D{{$pair->listed_market_name}}%253A{{$symbol}}"%7D' width="100%" height="550px" frameborder="0" target="_self"></iframe>
</div>
@push('script')
<script>
    document.querySelector('.tv-header__link') && document.querySelector('.tv-header__link').remove();
</script>
@endpush
@push('style')
<style>
    [data-theme=light] .chart-dark {
        display: none;
    }
    [data-theme=dark] .chart-light {
        display: none;
    }
 
    .trading-chart iframe {
    width: 100%;
    height: 560px; /* Default height */
}

@media screen and (max-width: 575px) {
    .trading-chart iframe {
        height: 590px; /* Height for small screen width (mobile) */
    }
}

@media (max-height: 780px) {
    .trading-chart iframe {
        height: 540px; /* Height for 780px screen height */
    }
}

@media (min-height: 800px) and (max-height: 804px) {
    .trading-chart iframe {
        height: 555px; /* Height for screens between 800px and 804px */
    }
}

@media (max-height: 851px) {
    .trading-chart iframe {
        height: 670px; /* Height for 851px screen height */
    }
}

@media (max-height: 915px) {
    .trading-chart iframe {
        height: 668px; /* Height for 915px screen height */
    }
}

@media (max-height: 880px) {
    .trading-chart iframe {
        height: 635px; /* Height for 880px screen height */
    }
}

@media (max-height: 812px) {
    .trading-chart iframe {
        height: 490px; /* Height for 812px screen height */
    }
}

@media (max-height: 844px) {
    .trading-chart iframe {
        height: 515px; /* Height for 844px screen height */
    }
}

@media (max-height: 896px) {
    .trading-chart iframe {
        height: 490px; /* Height for 896px screen height */
    }
}

@media (max-height: 568px) {
    .trading-chart iframe {
        height: 291px; /* Height for 568px phone screen height */
    }
}


    
</style>
@endpush

