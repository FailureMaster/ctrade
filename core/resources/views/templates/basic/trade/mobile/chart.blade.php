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
        /* Performance optimized styles */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: fixed;
            overscroll-behavior: none; /* Prevent pull-to-refresh */
        }

        .trading-chart-container {
            width: 100%;
            height: calc(var(--vh, 1vh) * 85);
            position: relative;
            background: #131722;
            touch-action: none;
            -webkit-backface-visibility: hidden; /* Prevent flickering */
            backface-visibility: hidden;
            transform: translateZ(0); /* Force GPU acceleration */
            will-change: transform; /* Hint for browser optimization */
        }

        #tradingview-widget {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            contain: strict; /* Optimize rendering */
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
            will-change: transform;
            transform: translateZ(0);
            contain: layout size;
        }
    </style>
@endpush

@push('script')
    <script>
        (function() {
            'use strict';

            let vh = window.innerHeight * 0.01;
            const doc = document.documentElement;
            const tvContainer = document.querySelector('.trading-chart-container');
            let tvWidget = null;
            let resizeTimeout = null;

            // Set viewport height
            function setViewportHeight() {
                vh = window.innerHeight * 0.01;
                doc.style.setProperty('--vh', `${vh}px`);
            }

            // Debounced resize handler
            function handleResize() {
                if (resizeTimeout) {
                    cancelAnimationFrame(resizeTimeout);
                }
                resizeTimeout = requestAnimationFrame(setViewportHeight);
            }

            // Initialize TradingView widget
            function initializeTradingViewWidget() {
                const config = {
                    "container_id": "tradingview-widget",
                    "symbol": "{{ $listedMarket }}:{{ $symbol }}",
                    "interval": "5",
                    "timezone": "Etc/UTC",
                    "theme": "{{ $theme }}",
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
                    "studies": [{
                        "id": "RSI@tv-basicstudies",
                        "inputs": {
                            "length": 14
                        }
                    }],
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
                };
                tvWidget = new TradingView.widget(config);
            }

            // Initialize the application
            function init() {
                // Set initial viewport height
                setViewportHeight();

                // Preconnect to TradingView CDN
                const link = document.createElement('link');
                link.rel = 'preconnect';
                link.href = 'https://s3.tradingview.com';
                document.head.appendChild(link);

                // Load TradingView script asynchronously
                const script = document.createElement('script');
                script.src = 'https://s3.tradingview.com/tv.js';
                script.async = true;

                // Initialize widget after script loads
                script.onload = initializeTradingViewWidget;
                document.body.appendChild(script);

                // Add passive event listeners for resize and orientation change
                const passiveOpts = { passive: true };
                window.addEventListener('resize', handleResize, passiveOpts);
                window.addEventListener('orientationchange', handleResize, passiveOpts);

                if (window.visualViewport) {
                    window.visualViewport.addEventListener('resize', handleResize, passiveOpts);
                }
            }

            // Start initialization
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>
@endpush