@php
    $widget = $general->trading_view_widget;
    $symbol = str_replace("_", "", $pair->symbol);
    $listedMarket = $pair->listed_market_name;
    $theme = session('theme') ?? 'dark';
@endphp

@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <div class="trading-chart-container">
        <div id="tradingview-widget"></div>
    </div>
    {{-- Mobile Menu --}}
    @include($activeTemplate . 'partials.mobile.menu')
@endsection

@push('styles')
    <style>
        /* Reset and base styles */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: fixed;
        }
        .trading-chart-container {
            width: 100%;
            height: calc(var(--vh, 1vh) * 90); /* Adjust height for mobile menu */
            position: relative;
            background: #131722;
            touch-action: none;
        }
        #tradingview-widget {
            width: 100%; /* Ensure full width */
            height: 100%; /* Ensure full height */
            position: absolute;
            top: 0;
            left: 0;
        }
        .mobile-menu {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: calc(var(--vh, 1vh) * 10);
            background: #131722;
            z-index: 1000;
            padding-bottom: env(safe-area-inset-bottom, 0px);
            will-change: transform; /* Optimize for animations */
        }
    </style>
@endpush

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Throttle function to limit how often setViewportHeight runs
            function throttle(func, limit) {
                let inThrottle;
                return function() {
                    const args = arguments;
                    const context = this;
                    if (!inThrottle) {
                        func.apply(context, args);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                };
            }

            // Set viewport height once and update on resize
            function setViewportHeight() {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }

            // Initialize TradingView widget only when it's in the viewport
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    // Load TradingView script dynamically
                    const script = document.createElement('script');
                    script.src = 'https://s3.tradingview.com/tv.js';
                    script.async = true; // Load script asynchronously
                    script.onload = initializeTradingViewWidget;
                    document.body.appendChild(script);

                    // Stop observing after loading
                    observer.disconnect();
                }
            }, { threshold: 0.5 });

            observer.observe(document.querySelector('.trading-chart-container'));

            // Initialize TradingView widget
            function initializeTradingViewWidget() {
                new TradingView.widget({
                    "container_id": "tradingview-widget",
                    "symbol": "{{ $listedMarket }}:{{ $symbol }}",
                    "interval": "5",
                    "timezone": "Etc/UTC",
                    "theme": "{{ $theme ?? 'dark' }}",
                    "style": "1",
                    "locale": "en",
                    "toolbar_bg": "#131722",
                    "hide_top_toolbar": false,
                    "hide_legend": true,
                    "hide_side_toolbar": true,
                    "hide_volume": true,
                    "enable_publishing": false,
                    "allow_symbol_change": false,
                    "save_image": false,
                    "autosize": true,
                    "height": "100%",
                    "width": "100%",
                    "studies": [
                        {
                            "id": "RSI@tv-basicstudies",
                            "inputs": {
                                "length": 14
                            }
                        }
                    ],
                    "overrides": {
                        "volumePaneSize": "0%",
                        "mainSeriesProperties.showVolume": false,
                        "paneProperties.legendProperties.showLegend": false,
                        "scalesProperties.showLeftScale": false,
                        "scalesProperties.showRightScale": true,
                        "paneProperties.background": "#131722",
                        "paneProperties.vertGridProperties.color": "#363c4e",
                        "paneProperties.horzGridProperties.color": "#363c4e",
                        "paneProperties.backgroundType": "solid",
                        "paneProperties.background": "#1e1e2d",
                        "RSI@tv-basicstudies.rsi.color": "#FF1493",
                        "RSI@tv-basicstudies.rsi.linewidth": 3,
                        "RSI@tv-basicstudies.rsi.transparency": 0,
                        "RSI@tv-basicstudies.overbought.color": "#FF0000",
                        "RSI@tv-basicstudies.oversold.color": "#00FF00",
                        "RSI@tv-basicstudies.overbought.value": 70,
                        "RSI@tv-basicstudies.oversold.value": 30,
                        "paneProperties.topMargin": 0,
                        "paneProperties.bottomMargin": 0,
                        "scalesProperties.textColor": "#FFFFFF"
                    }
                });
            }

            // Set initial viewport height
            setViewportHeight();

            // Throttle the resize handler to improve performance
            const throttledResize = throttle(setViewportHeight, 100);
            window.addEventListener('resize', throttledResize);
            window.addEventListener('orientationchange', throttledResize);
            window.visualViewport?.addEventListener('resize', throttledResize);
        });
    </script>
@endpush