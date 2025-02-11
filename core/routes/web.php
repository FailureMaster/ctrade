<?php

use App\Http\Controllers\AdvancedChartController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

// Route::get('/show-ini', function(){
//      phpinfo();
// });
Route::get('/advanced-chart', [AdvancedChartController::class, 'index']);
Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('/user', function () {
    return redirect('/user/dashboard');
});

Route::get('proxy', 'SiteController@proxyMethod')->name('proxy');
Route::get('cron', 'CronController@cron')->name('cron');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('close/{ticket}', 'closeTicket')->name('close');
    Route::get('download/{ticket}', 'ticketDownload')->name('download');
});
Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');
Route::get('ws', 'WsContoller@ws');

Route::controller("TradeController")->prefix('trade')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('/order/book/{symbol}', 'orderBook')->name('trade.order.book');
        Route::get('pairs', 'pairs')->name('trade.pairs');
        Route::get('history/{symbol}', 'history')->name('trade.history');

      
        Route::get('/', 'trade')->name('trade');
        Route::get('current-price/{type}/{symbol}', 'getCurrentPrice')->name('trade.current-price');
        Route::post('close/all/open/trade/', 'closeAllOrders')->name('close-all-orders');

        Route::get('fetch-modal-profit/{id}', 'fetchOrderProfit')->name('trade.order.fetchModalProfit');
        Route::get('fetch-user-balance', 'fetchUserBalance')->name('trade.fetchUserBalance');
        Route::get('/fetch-coin', 'fetchCoin')->name('trade.fetch.coin');
        
        Route::post('/favorite/add', 'addToFavorite')->name('trade.favorite.add');
        Route::get('/favorite/fetch', 'fetchUserFavorites')->name('trade.fetch.favorite');

        // New for mobile
        Route::get('markets', 'markets')->name('trade.markets');
        Route::get('chart', 'chart')->name('trade.chart');
        Route::get('menu', 'menu')->name('trade.mobile');
        Route::get('dashboard', 'dashboard')->name('trade.dashboard');
        Route::get('closed_orders', 'closed_orders')->name('trade.closed_orders');
        Route::get('open_orders', 'open_orders')->name('trade.open_orders');
        Route::get('new_order', 'new_order')->name('trade.new_order');
    });
    
    Route::get('order/list/{pairSym}/{status}', 'orderList')->name('trade.order.list');
    Route::get('order/marginlevel/{pairSym}/{status}', 'marginlevel')->name('trade.order.marginlevel');
});

Route::namespace('P2P')->group(function () {
    Route::controller("HomeController")->prefix('p2p')->group(function () {
        Route::get("/advertiser/{username}", 'advertiser')->name('p2p.advertiser');
        Route::get("/{type?}/{coin?}/{currency?}/{paymentMethod?}/{region?}/{amount?}", 'p2p')->name('p2p');
    });
});

Route::controller('SiteController')->group(function () {
    // Route::get('/contact', 'contact')->name('contact');
    Route::get('/pwa/configuration', 'pwaConfiguration')->name('pwa.configuration');
    Route::get('/market/list', 'marketList')->name('market.list');
    Route::get('/crypto/list', 'cryptoCurrencyList')->name('crypto_currency.list');
    // Route::get('/market', 'market')->name('market');
    // Route::get('/about-us', 'about')->name('about');
    // Route::get('/blogs', 'blogs')->name('blogs');
    // Route::get('/crypto-currency', 'crypto')->name('crypto_currencies');
    Route::get('/crypto/currency/{symbol}', 'cryptoCurrencyDetails')->name('crypto.details');
    // Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::post('/subscribe', 'subscribe')->name('subscribe');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    // Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
    Route::post('pusher/auth/{socketId}/{channelName}', "pusherAuthentication");
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});




// routes/web.php
// app/Http/Controllers
// resources/views