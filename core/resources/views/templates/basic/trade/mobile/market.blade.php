@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <div class="mobile-container">
        <div class="trading-right m-0" style="height: 99%;">
            <div class="trading-right__top pb-0">
                <div class="summary-container c-summary pt-0">
                    <h2 class="border-0 p-0 mb-2 h-title @if(App::getLocale() == 'ar') text-end @endif">@lang('Markets')</h2>
                </div>
                <div class="w-100">
                    <form id="search-market" onsubmit="searchMarket(event)">
                        <div class="input--group">
                            <button class="search-btn" type="submit"><i class="las la-search"></i></button>
                            <input type="text"
                                class="form--control style-two pjsInput market-search @if (App::getLocale() == 'ar') text-end @endif"
                                placeholder="{{ __('Search') }}" name="search" id="searchInput">
                        </div>
                        <div class="coin-search-list-body">

                        </div>
                    </form>
                </div>
            </div>
            <h2 class="p-0 ch5"></h2>
            <nav id="market-nav" class="pt-0">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="dropdown-btn" id="nav-favorites-tab" onclick="toggleDropdown('favorites')"
                        data-bs-toggle="tab" data-bs-target="#nav-favorites" role="tab" aria-controls="nav-favorites"
                        aria-selected="false">
                        <div class="d-flex justify-content-between" style="align-items: center">
                            <div class="coin-label">
                                <span class="arrow-indicator">&#9654;</span>
                                <span class="title-text text-uppercase">@lang('Favorites')</span>
                            </div>
                            <span class="price-text toggle-col">@lang('Sell')</span>
                            <span class="daily-change-text toggle-col">@lang('Buy')</span>
                        </div>
                    </button>
                    <div class="dropdown-container" id="dropdown-container-favorites" style="display: none;">
                        <div class="tab-pane fade" id="nav-favorites" role="tabpanel" aria-labelledby="nav-favorites-tab">
                            <div class="market-favorites-body"></div>
                        </div>
                    </div>

                    <button class="dropdown-btn" id="nav-arabic-tab" onclick="toggleDropdown('arabic')" data-bs-toggle="tab"
                        data-bs-target="#nav-arabic" role="tab" aria-controls="nav-arabic" aria-selected="false">
                        <div class="d-flex justify-content-between" style="align-items: center">
                            <div class="coin-label">
                                <span class="arrow-indicator">&#9654;</span>
                                <span class="title-text text-uppercase">@lang('GCC Stocks')</span>
                            </div>
                            <span class="price-text toggle-col">@lang('Sell')</span>
                            <span class="daily-change-text toggle-col">@lang('Buy')</span>
                        </div>
                    </button>
                    <div class="dropdown-container" id="dropdown-container-arabic" style="display: none;">
                        <div class="tab-pane fade" id="nav-arabic" role="tabpanel" aria-labelledby="nav-arabic-tab">
                            <div class="market-arabic-body"></div>
                        </div>
                    </div>

                    <button class="dropdown-btn" id="nav-stocks-tab" onclick="toggleDropdown('stocks')" data-bs-toggle="tab"
                        data-bs-target="#nav-stocks" role="tab" aria-controls="nav-stocks" aria-selected="false">
                        <div class="d-flex justify-content-between" style="align-items: center">
                            <div class="coin-label">
                                <span class="arrow-indicator">&#9654;</span>
                                <span class="title-text text-uppercase">@lang('Stocks')</span>
                            </div>
                            <span class="price-text toggle-col">@lang('Sell')</span>
                            <span class="daily-change-text toggle-col">@lang('Buy')</span>
                        </div>
                    </button>
                    <div class="dropdown-container" id="dropdown-container-stocks" style="display: none;">
                        <div class="tab-pane fade" id="nav-stocks" role="tabpanel" aria-labelledby="nav-stocks-tab">
                            <div class="market-stocks-body"></div>
                        </div>
                    </div>
                    <button class="dropdown-btn" id="nav-forex-tab" onclick="toggleDropdown('forex')" data-bs-toggle="tab"
                        data-bs-target="#nav-forex" role="tab" aria-controls="nav-forex" aria-selected="false">
                        <div class="d-flex justify-content-between" style="align-items: center">
                            <div class="coin-label">
                                <span class="arrow-indicator">&#9654;</span>
                                <span class="title-text text-uppercase">@lang('Forex')</span>
                            </div>
                            <span class="price-text toggle-col">@lang('Sell')</span>
                            <span class="daily-change-text toggle-col">@lang('Buy')</span>
                        </div>

                    </button>
                    <div class="dropdown-container" id="dropdown-container-forex" style="display: none;">
                        <div class="tab-pane fade show active" id="nav-forex" role="tabpanel"
                            aria-labelledby="nav-forex-tab">
                            <div class="market-forex-body"></div>
                        </div>
                    </div>
                    <button class="dropdown-btn" id="nav-index-tab" data-bs-toggle="tab" data-bs-target="#nav-index"
                        onclick="toggleDropdown('index')" role="tab" aria-controls="nav-index" aria-selected="false">
                        <div class="d-flex justify-content-between" style="align-items: center">
                            <div class="coin-label">
                                <span class="arrow-indicator">&#9654;</span>
                                <span class="title-text text-uppercase">@lang('Index')</span>
                            </div>
                            <span class="price-text toggle-col">@lang('Sell')</span>
                            <span class="daily-change-text toggle-col">@lang('Buy')</span>
                        </div>

                    </button>
                    <div class="dropdown-container" id="dropdown-container-index" style="display: none;">
                        <div class="tab-pane fade" id="nav-index" role="tabpanel" aria-labelledby="nav-index-tab">
                            <div class="market-index-body"></div>
                        </div>
                    </div>
                    <button class="dropdown-btn" id="nav-crypto-tab" data-bs-toggle="tab" data-bs-target="#nav-crypto"
                        onclick="toggleDropdown('crypto')" role="tab" aria-controls="nav-crypto" aria-selected="true">
                        <div class="d-flex justify-content-between" style="align-items: center">
                            <div class="coin-label" style="flex: 1">
                                <span class="arrow-indicator">&#9654;</span>
                                <span class="title-text text-uppercase">@lang('Crypto')</span>
                            </div>
                            <span class="price-text toggle-col">@lang('Sell')</span>
                            <span class="daily-change-text toggle-col">@lang('Buy')</span>
                        </div>
                    </button>

                    <div class="dropdown-container" id="dropdown-container-crypto" style="display: none;">
                        <div class="tab-pane fade" id="nav-crypto" role="tabpanel" aria-labelledby="nav-crypto-tab">
                            <div class="market-crypto-body"></div>
                        </div>
                    </div>

                    <button class="dropdown-btn" id="nav-commodity-tab" data-bs-toggle="tab" data-bs-target="#nav-commodity"
                        onclick="toggleDropdown('commodity')" role="tab" aria-controls="nav-commodity"
                        aria-selected="false">
                        <div class="d-flex justify-content-between" style="align-items: center">
                            <div class="coin-label">
                                <span class="arrow-indicator">&#9654;</span>
                                <span class="title-text text-uppercase">@lang('Commodity')</span>
                            </div>
                            <span class="price-text toggle-col">@lang('Sell')</span>
                            <span class="daily-change-text toggle-col">@lang('Buy')</span>
                        </div>

                    </button>
                    <div class="dropdown-container" id="dropdown-container-commodity" style="display: none;">
                        <div class="tab-pane fade" id="nav-commodity" role="tabpanel" aria-labelledby="nav-commodity-tab">
                            <div class="market-commodity-body"></div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="market-tab-content tab-content" id="nav-tabContent">

            </div>
        </div>
    </div>

    {{-- Canva --}}
    <div class="offcanvas offcanvas-bottom custom-offcanvas p-4 rounded-top" tabindex="-1" id="market-canvas" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h4 class="mb-0 fs-18 offcanvas-title text-white">
            </h4>
            <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa fa-times-circle fa-lg"></i>
            </button>
        </div>
        <div class="offcanvas-body text-center">
           <p>
                <a href="#" class="new-order-link text-themed btn border border-0">
                    @lang('New Order')
                </a>
            </p>
           <p class="my-2">
                <a href="#" class="link-to-chart text-themed btn border border-0">
                    @lang('Chart')
                </a>
            </p>
        </div>
    </div>

    {{-- Menu --}}
    @include($activeTemplate . 'partials.mobile.menu')
@endsection

@push('script')
    <script>
        "use strict";
        
        window.addEventListener('DOMContentLoaded', (event) => {
            $('.market-search').on('input', searchMarket);

            fetchHistory();

            setTimeout(() => {
                const urlParams = new URLSearchParams(window.location.search);
                const categoryParam = urlParams.get('category');

                if (categoryParam) {
                    toggleDropdown(categoryParam);
                    showDropdownContents(categoryParam);
                } else {
                    toggleDropdown('forex');
                    showDropdownContents('forex');
                }
            }, 500);
        });

        function showDropdownContents(type) {
            const tabPane = document.getElementById(`nav-${type}`);
            tabPane.classList.add('show');
        }

        let coinMarketId = '';
        let coinDataDb = {};

        function fetchHistory() {
            $.ajax({
                url: "{{ route('trade.fetch.favorite') }}",
                type: "GET",
                dataType: 'json',
                cache: false,
                success: function(response) {
                    let favorites = response.favorites; 
                    let favorited = favorites.map(favorite => favorite.symbol);
             
                    $.ajax({
                        url: "{{ route('trade.pairs') }}",
                        type: "GET",
                        dataType: 'json',
                        cache: false,
                        data: {
                            coinMarketId
                        },
                        success: function(resp) {
                            coinDataDb = {
                                pairs: resp.pairs.reverse() // Reverse the pairs
                            };

                            $.ajax({
                                url: "https://tradehousecrm.com/trade/fetch-coin",
                                type: "GET",
                                dataType: 'json',
                                cache: false,
                                success: function(resp) {
                                    let api_res = resp;

                                    // Initialize an object to hold categorized data
                                    let categorizedData = {};

                                    $.each(coinDataDb.pairs, function(i, pair) {
                                        // Find the matching pair in api_res based on symbol
                                        let matchingPair = api_res[pair.symbol
                                            .replace('_', '')];

                                        if (matchingPair) {
                                            // If it exists, get the type and create a key if it doesn't exist
                                            let type = pair.type;

                                            if (!categorizedData[type]) {
                                                categorizedData[
                                                type] = {}; // Initialize the object for this type
                                            }
                                            // console.log(matchingPair.symbol);
                                            // Add the pair to the categorized data
                                            categorizedData[type][pair
                                            .symbol] = {
                                                symbol: matchingPair.symbol,
                                                price: matchingPair.price,
                                                percent: matchingPair
                                                    .percent,
                                                current: matchingPair
                                                    .current,
                                                logo_url: matchingPair
                                                    .logo_url,
                                                logo_url2: matchingPair
                                                    .logo_url2,
                                                company: matchingPair
                                                    .company,
                                                dataSymbol: matchingPair
                                                    .dataSymbol,
                                                spread: ( response.symbols[matchingPair.symbol].length ? parseFloat(response.symbols[matchingPair.symbol]) : 0 )
                                            };
                                        }
                                    });

                                    // console.log(categorizedData); // This will have the structure you need

                                    let arabicSymbols = ["ADNOCGAS", "FAB", "JAZEERA",
                                        "STC", "BOUBYAN", "NBK", "ZAIN", "NOOR",
                                        "MASAKEN", "ALDAR", "DANA", "ADIB",
                                        "BAYANAT", "ADCB", "SIB", "CBI", "ADNIC",
                                        "ABK", "WARBABANK", "OOREDOO", "KFH", "KIB",
                                        "IFA", "BPCC", "ABAR"
                                    ];
                                    let arabicObj = [];
                                    let stocksObj = []

                                    let stocksData = categorizedData.Stocks;
                                    if (stocksData) {
                                        for (let symbol in stocksData) {
                                            if (stocksData.hasOwnProperty(symbol)) {
                                                let stock = stocksData[symbol];
                                                if (arabicSymbols.includes(symbol)) {
                                                    arabicObj[symbol] = stock;
                                                } else {
                                                    stocksObj[symbol] = stock;
                                                }
                                            }
                                        }
                                    } else {
                                        console.error("resp.Stocks is not an object:",
                                            resp.Stocks);
                                    }

                                    generateCoinssHTML(arabicObj, '.market-arabic-body',
                                        'arabic', 'Stocks', favorited)

                                    generateCoinssHTML(stocksObj, '.market-stocks-body',
                                        'stocks', 'Stocks', favorited)

                                    let forexData = categorizedData.FOREX;
                                    generateCoinssHTML(forexData, '.market-forex-body',
                                        'forex', 'FOREX', favorited)

                                    let indexData = categorizedData.INDEX;
                                    generateCoinssHTML(indexData, '.market-index-body',
                                        'index', 'INDEX', favorited)

                                    let cryptoData = categorizedData.Crypto;
                                    generateCoinssHTML(cryptoData,
                                        '.market-crypto-body', 'crypto', 'Crypto',
                                        favorited)

                                    let commodityData = categorizedData.COMMODITY;
                                    generateCoinssHTML(commodityData,
                                        '.market-commodity-body', 'commodity',
                                        'COMMODITY', favorited)

                                    // fetchFavorites(resp);
                                    fetchFavorites(categorizedData);

                                    updateElementValue();
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error fetching history: ", error);
                                }
                            });
                        }
                    });

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching favorites: ", error);
                }
            });


        }

        fetchHistory();

        setInterval(fetchHistory, 1000);

        function updateElementValue() {

            let usoil = document.getElementById('name-USOIL');
            if (usoil) {
                usoil.innerText = 'Oil';
            }

            let XPDUSD = document.getElementById('name-XPDUSD');
            if (XPDUSD) {
                XPDUSD.innerText = 'PALLADIUM';
            }

            let SOYBNUSD = document.getElementById('name-SOYBNUSD');
            if (SOYBNUSD) {
                SOYBNUSD.innerText = 'SOYABEAN';
            }

            let RYCEY = document.getElementById('name-RYCEY');
            if (RYCEY) {
                RYCEY.innerText = 'ROLLS R.';
            }


            let dowusd = document.getElementById('name-DOWUSD');
            if (dowusd) {
                dowusd.innerText = 'Dow Jones';
            }

            let ndx = document.getElementById('name-NDX');
            if (ndx) {
                ndx.innerText = 'NASDAQ 100';
            }

            let spx500usd = document.getElementById('name-SPX500USD');
            if (spx500usd) {
                spx500usd.innerText = 'S&P 500';
            }

            let jp225usd = document.getElementById('name-JP225USD');
            if (jp225usd) {
                jp225usd.innerText = 'Nikkei 225';
            }

            let fra40 = document.getElementById('name-FRA40');
            if (fra40) {
                fra40.innerText = 'CAC 40';
            }

            let us2000 = document.getElementById('name-US2000');
            if (us2000) {
                us2000.innerText = 'Russell 2000';
            }

            let V = document.getElementById('name-V');
            if (V) {
                V.innerText = 'VISA';
            }

            let MA = document.getElementById('name-MA');
            if (MA) {
                MA.innerText = 'MASTER';
            }

            let BABA = document.getElementById('name-BABA');
            if (BABA) {
                BABA.innerText = 'ALI BABA';
            }

            let BLK = document.getElementById('name-BLK');
            if (BLK) {
                BLK.innerText = 'BLACK ROCK';
            }

            let BA = document.getElementById('name-BA');
            if (BA) {
                BA.innerText = 'BOEING';
            }

        }

        $(document).on('click', '.open-symbol', function (e) {
            e.preventDefault();

            let link = $(this); // jQuery object
            let url = link.attr('href');
            let name = link.attr('data-coin_name');
            let company = link.attr('data-company').replace('/', 'vs');
            let orderParam = link.attr('data-order_param');

            let parentLink = $(this).parents('.m-item');

            let offcanvas = $('#market-canvas'); // jQuery object
            let offcanvasElement = document.getElementById("market-canvas"); // Plain JS element

            // Update offcanvas content
            offcanvas.find('.link-to-chart').attr('href', url);
            offcanvas.find('.new-order-link').attr('href', orderParam);
            offcanvas.find('.offcanvas-title').text(name+': '+company);

            // Get the clicked element's position
            let rect = parentLink[0].getBoundingClientRect();
            let windowHeight = window.innerHeight;
            let offcanvasHeight = offcanvas.outerHeight();

            // Set the offcanvas position
            offcanvas.css({
                display: 'block'
            });

            // Show Bootstrap Offcanvas properly
            let bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
            bsOffcanvas.show();
        });

        function generateCoinssHTML(coinsData, className, category, belongsTo, favoriteCoins = []) {
            let html = '';
            for (let coin in coinsData) {
                let percentValue = parseFloat(coinsData[coin].percent.replace('%', ''));

                let colorClass = percentValue >= 0 ? 'text-success' : 'text-danger';

                let symbol = encodeURIComponent(coinsData[coin].dataSymbol);
                let encodedCoin = encodeURIComponent(coin);
                let param =
                    `chart?category=${category ? category : coinsData[coin].category}&symbolHIFHSRbBIKR1pDOisb7nMDFp6JsuVZv=${symbol}%3A${encodedCoin}%3A%3A`;

                let orderParam =
                `new_order?category=${category ? category : coinsData[coin].category}&symbolHIFHSRbBIKR1pDOisb7nMDFp6JsuVZv=${symbol}%3A${encodedCoin}%3A%3A`;

                // Encode the parameter using Base64
                let encodedParam = btoa(param);

                let href = `?${encodedParam}`;

                let isFavorite = favoriteCoins.includes(coin);

                let newPrice = coinsData[coin].price;

                newPrice = newPrice.replace(/,/g, '');

                let decCount = countDecimalPlaces(newPrice);

                newPrice = parseFloat(newPrice);

                let buyPrice  = newPrice + coinsData[coin].spread;
                let sellPrice = newPrice - coinsData[coin].spread;

                buyPrice = parseFloat(buyPrice).toFixed(decCount);
                sellPrice = parseFloat(sellPrice).toFixed(decCount);

                // Change Buy/Sell Text Color
                let priceSellElement = $(`.coin-sell-price-${coin}`);
                let previousSellPrice = parseFloat(priceSellElement.first().text()) || 0;

                let priceBuyElement = $(`.coin-buy-price-${coin}`);
                let previousBuyPrice = parseFloat(priceBuyElement.first().text()) || 0;

                let sellPriceClass = 'nochange';
                let buyPriceClass = 'nochange';

                if (parseFloat(sellPrice) < previousSellPrice) {
                    sellPriceClass = 'num-increase';
                } else if (parseFloat(sellPrice) > previousSellPrice) {
                    sellPriceClass = 'num-decrease';
                }

                if (parseFloat(buyPrice) > previousBuyPrice) {
                    buyPriceClass = 'num-increase';
                } else if (parseFloat(buyPrice) < previousBuyPrice) {
                    buyPriceClass = 'num-decrease';
                }

                html += `
                    <div class="d-flex market-coin-item my-2 py-2">
                        <div class="m-item">
                            <div class="coin-icon">
                                <img src="${coinsData[coin].logo_url}" alt="${coin}" style="height: 100%; width: auto; border-radius: 50%;">
                            </div>
                            <div class="position-relative text-right mx-1">
                                <a href="${param}" class="open-symbol" data-order_param="${orderParam}" data-company="${coinsData[coin].company}" data-coin_name="${coin}" id="">${coin.slice(0, 6)}</a>
                            </div>
                        </div>
                        <div class="position-relative price-text">
                            <a href="${param}" class="coin-link coin-sell-price-${coin} ${sellPriceClass}" data-param="${param}">
                                ${sellPrice}
                            </a>
                        </div>
                        <div class="d-flex position-relative text-end daily-change-text">
                            <div class="d-flex justify-content-between w-100">
                                <a href="#" class="d-block coin-buy-price-${coin} ${buyPriceClass}">
                                    ${buyPrice}
                                </a>
                                <div class="icon-favorite" style="margin-right: 1.2rem; cursor: pointer" data-coin="${coin}" data-category="${category ? category : coinsData[coin].category}" onclick="addToFavorites('${coin}', '${belongsTo ? belongsTo : coinsData[coin].category}', '${coinsData[coin].dataSymbol}')">
                                    <i class="${isFavorite ? 'fas' : 'far'} fa-star" aria-hidden="true" style="color: ${isFavorite ? 'yellow' : ''}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            $(className).html(html);

            $(className).on('click', '.coin-link', function(event) {
                event.preventDefault(); // Prevent default link behavior
                let param = $(this).data('param');
                navigateToPage(param);
            });
        }

        function fetchFavorites(resp) {
            let marketData = resp
            let url = "{{ route('trade.fetch.favorite') }}";

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                cache: false,
                success: function(response) {
                    let favorites = response.favorites; 
                    const favoriteData = {};
                    const favoriteCoins = favorites.map(favorite => favorite.symbol);

                    favorites.forEach(favorite => {
                        const category = favorite.category;
                        const symbol = favorite.symbol;
                        if (category in marketData && symbol in marketData[category]) {
                            let symbolData = marketData[category][symbol];
                            symbolData['symbol'] = symbol;
                            symbolData['category'] = category;
                            favoriteData[symbol] = symbolData;
                        }
                    });

                    generateCoinssHTML(favoriteData, '.market-favorites-body', '', '', favoriteCoins)
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching favorites: ", error);
                }
            });
        }


        function navigateToPage(param) {
            let decodedParam = atob(param);
            window.location.href = decodedParam;
        }

        function toggleDropdown(type) {
            const container = document.getElementById(`dropdown-container-${type}`);
            const button = document.getElementById(`nav-${type}-tab`);
            const isVisible = container.style.display === "block";
            hideAllDropdowns();
            container.style.display = isVisible ? "none" : "block";

            const arrowIndicator = document.querySelector(`#nav-${type}-tab .arrow-indicator`);
            arrowIndicator.classList.toggle('down', !isVisible);

            button.classList.toggle('active', !isVisible);
        }

        function hideAllDropdowns() {
            const containers = document.querySelectorAll('.dropdown-container');
            containers.forEach(container => {
                container.style.display = "none";
            });

            const arrowIndicators = document.querySelectorAll('.arrow-indicator');
            arrowIndicators.forEach(indicator => {
                indicator.classList.remove('down');
            });

            const buttons = document.querySelectorAll('.dropdown-btn');
            buttons.forEach(button => {
                button.classList.remove('active');
            });
        }

        function searchMarket(event) {
            event.preventDefault();
            const searchInput = $('.market-search').val().toUpperCase();

            if (!searchInput) {
                $('.coin-search-list-body').html('');
                $('.coin-search-list-body').css('display', 'none');
                return;
            } else {
                $('.coin-search-list-body').css('display', 'block');
            }

            $.ajax({
                url: "https://tradehousecrm.com/trade/fetch-coin",
                type: "GET",
                dataType: 'json',
                cache: false,
                success: function(resp) {

                    let api_res = resp;

                    let categorizedData = {};

                    $.each(coinDataDb.pairs, function(i, pair) {
                        // Find the matching pair in api_res based on symbol
                        let matchingPair = api_res[pair.symbol.replace('_', '')];

                        if (matchingPair) {
                            // If it exists, get the type and create a key if it doesn't exist
                            let type = pair.type;

                            if (!categorizedData[type]) {
                                categorizedData[type] = {}; // Initialize the object for this type
                            }

                            // Add the pair to the categorized data
                            categorizedData[type][pair.symbol] = {
                                symbol: matchingPair.symbol,
                                price: matchingPair.price,
                                percent: matchingPair.percent,
                                current: matchingPair.current,
                                logo_url: matchingPair.logo_url,
                                logo_url2: matchingPair.logo_url2,
                                company: matchingPair.company,
                                dataSymbol: matchingPair.dataSymbol,
                            };
                        }
                    });

                    const filteredData = {};

                    for (const category in categorizedData) {
                        for (const symbol in categorizedData[category]) {
                            if (symbol.toUpperCase().includes(searchInput)) {
                                let symbolData = categorizedData[category][symbol];
                                symbolData['symbol'] = symbol;
                                symbolData['category'] = category;

                                filteredData[symbol] = symbolData;
                            }
                        }
                    }

                    generateCoinssHTML(filteredData, '.coin-search-list-body', '', '');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching history: ", error);
                }
            });
        }

        function addToFavorites(coin, category, dataSymbol) {
            let url = "{{ route('trade.favorite.add') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    coin: coin,
                    category: category,
                    dataSymbol: dataSymbol,
                    _token: "{{ csrf_token() }}"
                },
                success: function(resp) {
                    $(`div[data-coin='${coin}'][data-category='${category}'] i`).removeClass('far').addClass(
                        'fas');
                },
                error: function(xhr, status, error) {
                    console.error("Error adding to favorites: ", error);
                }
            });
        }
    </script>
@endpush
@push('style')
    <style>
        #market-nav {
            padding-top: 1rem;
            margin-bottom: 80px;
        }

        #market-nav .nav-tabs {
            display: flex;
            justify-content: space-between;
            border-bottom: 0;
        }

        #market-nav .nav-link {
            padding: .2rem .5rem;
            border-radius: .2rem;
            cursor: pointer;
            color: white;
            border: none;
        }

        #market-nav .nav-link.active {
            background-color: #2a2e39;
            font-weight: 600;
        }

        .market-coin-item {
            border-bottom: 1px solid hsl(var(--white));
            border-left: 4px solid #0d1e23;
        }

        .market-coin-item:hover {
            border-left: 4px solid #f4ae23;
        }

        .market-coin-item a {
            color: hsl(var(--white));
            font-size: 16px;
        }

        .market-coin-item .coin-icon {
            height: 22px;
            width: 22px;
            background-color: red;
            margin-left: 5px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .dropdown-container>.tab-pane>div {
            max-height: 613px;
            overflow-y: scroll;
        }

        .dropdown-btn {
            padding: 8px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: block;
            border-bottom: 1px solid hsl(var(--white));
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
        }

        /* On mouse-over */
        .dropdown-btn:hover {
            color: #f1f1f1;
        }

        /* Main content */
        .main {
            margin-left: 300px;
            /* Same as the width of the sidenav */
            font-size: 20px;
            /* Increased text to enable scrolling */
            padding: 0px 10px;
        }

        /* Add an active class to the active dropdown button */
        .active {
            color: white;
        }

        /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
        .dropdown-container {
            display: none;
            /* padding-left: 8px; */
            width: 100%;
            text-align: left;
            /* Adjust the maximum width as needed */
        }

        /* Optional: Style the caret down icon */
        .fa-caret-down {
            float: right;
            padding-right: 8px;
        }

        .arrow-indicator {
            margin-right: 5px;
            /* Adjust margin as needed */
            transition: transform 0.3s ease;
            /* Smooth transition for arrow rotation */
            color: hsl(var(--white));
            /* Default arrow color */
        }

        .arrow-indicator.down {
            transform: rotate(90deg);
            /* Rotate the arrow when button is clicked */
        }

        .dropdown-btn.active .arrow-indicator {
            color: hsl(var(--white));
            /* Active arrow color */
        }

        .title-text {
            font-size: 16px;
            color: hsl(var(--white));
        }

        .price-text {
            width: 80px;
            text-align: left;
            font-size: 16px;
            color: hsl(var(--white));
        }

        .daily-change-text {
            width: 100px;
            text-align: left;
            font-size: 16px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: hsl(var(--white));
        }

        .toggle-col {
            display: none;
        }

        .dropdown-btn.active .toggle-col {
            display: inline;
        }

        .market-search {
            padding-top: 12px !important;
            padding-bottom: 12px !important;
            color: hsl(var(--white)) !important;
        }

        ::placeholder {
            color: hsl(var(--white)) !important;
            opacity: 1;
        }

        ::-ms-input-placeholder {
            color: hsl(var(--white)) !important;
        }

        .search-btn {
            color: hsl(var(--white)) !important;
        }

        .ch5 {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
        }

        .c-summary {
            padding-right: 0 !important;
            padding-left: 0 !important;
            padding-bottom: 0 !important;
        }

        
        .coin-label{
            flex:1;
        }

        .m-item{
            display:flex;
            white-space:nowrap; 
            flex:1;
        }

        @media only screen and (max-width: 440px) {
            .coin-label{
                flex:unset;
                width:140px;
            }

            .m-item{
                flex:unset;
                width:140px;
            }
        }

        .price-text{
            text-align:center;
            flex:1;
        }

        .daily-change-text{
            flex:1;
        }

        /* .custom-offcanvas {
            width: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 12px 12px 0 0; 
            height: 70vh; 
            max-height: 500px; 
        } */

        .custom-offcanvas {
            position: absolute; /* Allow dynamic positioning */
            width: 100%; /* Adjust width as needed */
            /* max-width: 400px;  */
            border-radius: 12px 12px 0 0; /* Rounded corners for smooth look */
            height: auto; /* Adjust dynamically */
            max-height: 400px; /* Set a limit */
            /* background: white;  */
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2); /* Soft shadow */
            display: none; /* Initially hidden */
        }

        [data-theme=light] .nochange {
            color: black !important;
        }
        .num-increase {
            color: #198754 !important;
        }
        .num-decrease {
            color: #dc3545 !important
        }
    </style>
@endpush