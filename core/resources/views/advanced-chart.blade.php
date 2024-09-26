<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> {{ $general->siteName(__($pageTitle)) }}</title>
        @include('partials.seo')
    
        <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}" />
    
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'dashboard/css/icomoon.css') }}">
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'dashboard/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    
        @stack('style-lib')
        @stack('style')
    
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}">
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/auth_color.php') }}?color={{ $general->auth_color }}">
    </head>
    
    <body>
        <div>
            <div id="tv_chart_container"></div>
        </div>
    
        <script src="{{ asset('assets/global/js/charting_library/charting_library.standalone.js') }}"></script>
    	<script src="{{ asset('assets/global/js/datafeeds/udf/dist/bundle.js') }}"></script>
        <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset($activeTemplateTrue . 'dashboard/js/main.js') }}"></script>
        
        <script type="text/javascript">
            function getParameterByName(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            function initOnReady() {
                var datafeedUrl = "https://tvc4.investing.com/bdfdf8db4d6f941718a1dcf57b6c72e0/1721446376/1/1/8";
                // var datafeedUrl = "https://api.polygon.io/v2/aggs/ticker/AAPL/range/1/day/2023-01-09/2023-01-09?apiKey=tiQ3OMFSQCcSpA7qY3YGIIG7TonaIsW3"
                var customDataUrl = getParameterByName('dataUrl');
                if (customDataUrl !== "") {
                    datafeedUrl = customDataUrl.startsWith('https://') ? customDataUrl : `https://${customDataUrl}`;
                }

                var widget = window.tvWidget = new TradingView.widget({
                    debug: true, // uncomment this line to see Library errors and warnings in the console
                    fullscreen: true,
                    symbol: 'AAPL',
                    interval: '1D',
                    container: "tv_chart_container",

                    //	BEWARE: no trailing slash is expected in feed URL
                    datafeed: new Datafeeds.UDFCompatibleDatafeed(datafeedUrl, undefined, {
                        maxResponseLength: 1000,
                        expectedOrder: 'latestFirst',
                    }),
                    library_path: "https://trade.daimondrock.com/assets/global/js/charting_library/",
                    locale: getParameterByName('lang') || "en",

                    disabled_features: ["use_localstorage_for_settings", "study_market_minimized", "link_to_tradingview", "volume_force_overlay", "header_saveload"],
                    enabled_features: ["study_templates"],
                    charts_storage_url: 'https://saveload.tradingview.com',
                    charts_storage_api_version: "1.1",
                    client_id: 'tradingview.com',
                    user_id: 'public_user_id',
                    theme: getParameterByName('theme'),
                });
                
                widget.onResolveSymbol = resolveSymbol;
                
                window.frames[0].focus();
            };
            
            function resolveSymbol(symbolName, onResolve, onReject) {
				if (symbolName === "Tadawul_All_Shares_Index") {
				    alert('xxx');
					// Assuming your data source uses "Tadawul_All_Shares_Index" as the symbol name
					const symbolInfo = {
					name: symbolName,
					// ... (add other relevant symbol information based on your data source)
					exchange: "Tadawul", // Assuming the exchange is Tadawul
					currency: "SAR", // Assuming the currency is Saudi Arabian Riyal (SAR)
					};
					onResolve(symbolInfo);
				} else {
					// Call onReject if symbol not found (optional, handle it in your data source)
					onReject("Symbol not found");
				}
			}

            window.addEventListener('DOMContentLoaded', initOnReady, false);
        </script>
    </body>

</html>