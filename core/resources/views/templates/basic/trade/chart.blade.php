@php
    $meta = (object) $meta;
    $pair = $meta->pair;

    $symbol = str_replace("_", "", $pair->symbol);
    $listedMarket = $pair->listed_market_name;

    // Base URL parameters
    $baseUrl = 'https://www.tradingview-widget.com/embed-widget/advanced-chart/';
    $queryParams = [
        'login' => 'user1',
        'password' => 'dfkjhoijogpoi',
        'locale' => 'en'
    ];

    // Common fragment parameters
    $commonFragment = [
        "symbol" => "$listedMarket:$symbol",
        "frameElementId" => "tradingview_7abd4",
        "interval" => "5",
        "hide_side_toolbar" => "0",
        "allow_symbol_change" => "8",
        "save_image" => "1",
        "studies" => "[]",
        "style" => "1",
        "timezone" => "Etc/UTC",
        "studies_overrides" => "{}",
        "hide_volume" => "1",
        "utm_source" => "swf.centersooq.com",
        "utm_medium" => "widget_new",
        "utm_campaign" => "chart",
        "utm_term" => "$listedMarket:$symbol",
        "page-uri" => urlencode("swf.centersooq.com/trade?tvwidgetsymbol=$listedMarket%3A$symbol")
    ];

    // Generate URLs for both themes
    $themes = [];
    foreach (['dark', 'light'] as $theme) {
        $fragment = array_merge($commonFragment, ['theme' => $theme]);
        $encodedFragment = urlencode(json_encode($fragment));
        $themes[$theme] = $baseUrl . '?' . http_build_query($queryParams) . '#' . $encodedFragment;
    }
@endphp

<div class="trading-chart p-0 two">
    @foreach ($themes as $themeType => $url)
        <iframe 
            class="ichart chart-{{ $themeType }}" 
            src="{{ $url }}" 
            width="100%" 
            height="530"
            frameborder="0"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allow="autoplay; fullscreen"
            style="touch-action: manipulation; -webkit-tap-highlight-color: transparent;{{ $loop->first ? '' : 'display: none;' }}"
            title="Trading Chart {{ $themeType }}"
        ></iframe>
    @endforeach
</div>

@push('script')
<script>
    // Instant theme switcher
    function handleThemeChange() {
        const theme = document.documentElement.getAttribute('data-theme') || 'light';
        document.querySelectorAll('.trading-chart iframe').forEach(iframe => {
            iframe.style.display = iframe.classList.contains(`chart-${theme}`) ? 'block' : 'none';
        });
    }

    // Theme change observer
    const themeObserver = new MutationObserver(handleThemeChange);

    // Initial setup
    window.addEventListener('DOMContentLoaded', () => {
        handleThemeChange();
        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-theme']
        });

        // Remove TradingView branding
        const removeBranding = () => {
            document.querySelector('.tv-header__link')?.remove();
            document.querySelector('.tv-embed-widget__title')?.remove();
        };
        removeBranding();
        setTimeout(removeBranding, 2000);
    });
</script>
@endpush

@push('style')
<style>
    .trading-chart {
        position: relative;
        overflow: hidden;
        min-height: 430px;
        background-color: transparent;
    }

    .trading-chart iframe {
        width: 100%;
        height: 530px;
        border: 0;
    }

    @media (max-width: 768px) {
        .trading-chart {
            min-height: 58vh;
        }
        
        .trading-chart iframe {
            height: 58vh !important;
        }
    }

    @media (max-width: 480px) {
        .trading-chart iframe {
            height: 53vh !important;
        }
    }

    [data-theme="dark"] .trading-chart {
        background-color: #0f1821;
    }
</style>
@endpush