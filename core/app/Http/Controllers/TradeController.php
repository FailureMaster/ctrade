<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\User;
use App\Models\Order;
use App\Models\Trade;
use App\Models\Market;
use App\Models\Wallet;
use App\Models\CoinPair;
use App\Models\Currency;
use App\Constants\Status;
use App\Models\LotManager;
use App\Constants\Defaults;
use App\Models\ClientGroups;
use App\Models\FavoritePair;
use Illuminate\Http\Request;
use App\Models\FavoriteSymbol;
use App\Models\ClientGroupUser;
use App\Models\GatewayCurrency;
use App\Models\ClientGroupSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\SupportTicket;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    public function fetchCoin()
    {
        $disabledSymbol = CoinPair::query()
            ->where('status', Status::DISABLE)
            ->pluck('symbol')
            ->toArray();

        $jsonData = file_get_contents(resource_path('data/data1.json'));
        $data = json_decode($jsonData, true);

        $filterData = function ($items) use ($disabledSymbol) {
            return array_filter($items, function ($key) use ($disabledSymbol) {
                return !in_array($key, $disabledSymbol);
            }, ARRAY_FILTER_USE_KEY);
        };

        foreach ($data as $category => $items) {
            $data[$category] = $filterData($items);
        }

        return response()->json($data);
    }

    public function addToFavorite(Request $request)
    {
        $request->validate([
            'coin' => 'required|string',
            'category' => 'required|string',
        ]);

        $userId = auth()->id();

        $existingFavorite = FavoriteSymbol::where('user_id', $userId)
            ->where('symbol', $request->coin)
            ->where('category', $request->category)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();

            return returnBack('Favorite removed successfully', 'success');
        } else {
            $favorite = new FavoriteSymbol();
            $favorite->symbol = $request->coin;
            $favorite->category = $request->category;
            $favorite->user_id = $userId;
            $favorite->save();

            return returnBack('Favorite added successfully', 'success');
        }
    }

    public function fetchUserFavorites(Request $request)
    {
        $favorites = FavoriteSymbol::where('user_id', auth()->id())->get();

        return response()->json($favorites);
    }

    public function trade(Request $request)
    {
        $symbol = null;
        if ($request->has('symbolHIFHSRbBIKR1pDOisb7nMDFp6JsuVZv')) {
            $symbol = $request->input('symbolHIFHSRbBIKR1pDOisb7nMDFp6JsuVZv');
            $parts = explode(':', $symbol);
            $symbol = $parts[1];
        }

        $userId         = auth()->id() ?? 0;
        $usersInGroups  = ClientGroupUser::pluck('user_id')->toArray();



        $pair           = CoinPair::active()->activeMarket()->activeCoin()->with('market', 'coin', 'marketData');
        $isInGroup      = 0;

        if ($symbol) {
            $pair = $pair->where('symbol', $symbol)->first();
        } else {
            $pair = $pair->where('is_default', Status::YES)->first();
        }
        if (!$pair) {
            $notify[] = ['error', 'No pair found'];
            return back()->withNotify($notify);
        }
        // dd($symbol);
        //check if current user is in groups
        if (in_array($userId, $usersInGroups)) {
            $groups                 = ClientGroups::with(['settings', 'groupUsers', 'groupUsers.user'])->get();
            $clientGroupId          = ClientGroupUser::where('user_id', $userId)->first()->client_group_id;
            $clientGroupSettings    = ClientGroupSetting::where('client_group_id', $clientGroupId)->first();
            // $clientGroupSymbols    = ClientGroupSetting::where('client_group_id', $clientGroupId)->get();
            // // $symbolId               = ClientGroupSetting::with('symbol')->first()->symbol;
            // $symbolName             = CoinPair::find($clientGroupSettings->symbol);

            // dd($clientGroupSettings );

            $clientGroup = ClientGroups::whereHas('groupUsers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->first();

            $clientGroupSymbols = ClientGroupSetting::where('client_group_id', $clientGroupId)->select('symbol')->get()->pluck('symbol')->toArray();

            if ($clientGroup !== null && in_array($pair->id, $clientGroupSymbols)) {
                $pair->percent_charge_for_buy   = $clientGroupSettings->lots;

                //leverage
                $pair->percent_charge_for_sell  = $clientGroupSettings->leverage;

                //level
                $pair->level_percent            = $clientGroupSettings->level;

                //spread
                $pair->spread                   = $clientGroupSettings->spread;

                $isInGroup                      = $clientGroupSettings->lots;
            }
        }

        $markets = Market::with('currency:id,name,symbol')->active()->get();

        $coinWallet = Wallet::where('user_id', $userId)->where('currency_id', $pair->coin->id)->spot()->first();

        $order_count = Order::query()
            ->where('status', Status::ORDER_OPEN)
            ->where('user_id', auth()->id())
            ->count();

        $marketCurrencyWallet = Wallet::where('user_id', $userId)->where('currency_id', Defaults::DEF_WALLET_CURRENCY_ID /* $pair->market->currency->id */)->spot()->first();

        // $gateways = GatewayCurrency::where(function ($q) use ($pair) {
        //     $q->where('currency', @$pair->coin->symbol)->orWhere('currency', $pair->market->currency->symbol);
        // })->whereHas('method', function ($gate) {
        //     $gate->where('status', Status::ENABLE);
        // })->with('method:id,code,crypto')->get();

        $gateways = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method:id,code,crypto')->get();

        $pageTitle = $pair->symbol;

        $requiredMarginTotal = $this->requiredMarginTotal();

        $currency = Currency::where('id', 4)->first();

        $lots = LotManager::all();
        $fee_status = Fee::first()->status;

        $estimatedBalance   = Wallet::where([
            'user_id' => $userId,
            'currency_id' => Defaults::DEF_WALLET_CURRENCY_ID
        ])->join('currencies', 'wallets.currency_id', 'currencies.id')->spot()->sum(DB::raw('currencies.rate * wallets.balance'));

        // Order Log, Wallet
        $order         = Order::where('user_id', $userId);
        $closed_orders = $order->where('status', Status::ORDER_CANCELED)->get();
        $widget['open_order']      = Order::where('user_id', $userId)->where('status', Status::ORDER_OPEN)->count();
        $widget['completed_order'] = (clone $order)->completed()->count();
        $widget['total_trade']     = Trade::where('trader_id', $userId)->count();
        $pl                        = 0;
        $total_profit              = 0;
        $total_loss                = 0;

        foreach ($closed_orders as $co) {

            if ($co->profit > 1)  $total_profit =  $total_profit + $co->profit;
            if ($co->profit < 1)  $total_loss =  $total_loss + $co->profit;

            $pl = ($pl + $co->profit);
        }

        $widget['pl'] = $pl;
        $widget['closed_orders']  = $closed_orders->count();
        $widget['total_deposit']  = Deposit::where('user_id', $userId)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_withdraw'] = Withdrawal::where('user_id', $userId)->approved()->sum('amount');
        $widget['open_tickets']   = SupportTicket::where('status', Status::TICKET_OPEN)->count();

        // User
        $user = auth()->user();

        $clientGroupID = isset($user->userGroups->client_group_id) ? $user->userGroups->client_group_id : 0 ;

        $userGroup = ClientGroups::find($clientGroupID);

        $withdrawMethods = WithdrawMethod::active()->get();

        $deposits  = auth()->user()->deposits()->orderBy('id', 'desc');

        $withdraws = Withdrawal::where('user_id', auth()->id())->where('status', '!=', Status::PAYMENT_INITIATE)->orderBy('id', 'desc');

        $pendingWithdraw = (clone $withdraws)->where('status', 2)->get();

        return view($this->activeTemplate . 'trade.index', compact('pageTitle', 'pair', 'markets', 'coinWallet', 'marketCurrencyWallet', 'gateways', 'order_count', 'requiredMarginTotal', 'currency', 'lots', 'fee_status', 'estimatedBalance', 'widget', 'total_profit', 'total_loss', 'closed_orders', 'pl', 'user', 'userGroup', 'withdrawMethods', 'deposits', 'withdraws', 'pendingWithdraw', 'isInGroup'));
    }

    public function fetchUserBalance()
    {
        $userId = auth()->id() ?? 0;
        $marketCurrencyWallet = Wallet::where('user_id', $userId)->where('currency_id', Defaults::DEF_WALLET_CURRENCY_ID /* $pair->market->currency->id */)->spot()->first();

        return response()->json([
            'success'   => true,
            'balance'   => isset($marketCurrencyWallet->balance) ? $marketCurrencyWallet->balance : 0,
            'bonus'     => isset($marketCurrencyWallet->bonus) ? $marketCurrencyWallet->bonus : 0,
            'credit'    => isset($marketCurrencyWallet->credit) ? $marketCurrencyWallet->credit : 0,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function getCurrentPrice($type, $symbol)
    {
        // $marketDataJson = File::get(base_path('resources/data/data.json'));
        // $marketData = json_decode($marketDataJson);

        $marketDataJson = Http::get('https://tradehousecrm.com/trade/fetchcoinsprice');
        $marketData = json_decode($marketDataJson);

        return response()->json([
            'current_price' => $marketData->{$type}->{$symbol}
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function closeAllOrders(Request $request)
    {
        // dd([ $request->level, $request->equity ]);
        // if (empty($request->level) || empty($request->equity)) {
        //     return response()->json([
        //         'status' => 500,
        //         'message' => 'Invalid Payload!',
        //         'type' => 'INVALID_PAYLOAD'
        //     ], 500);
        // }

        // $orders = Order::query()
        //     ->where('status', Status::ORDER_OPEN)
        //     ->where('user_id', auth()->id());

        // if ($orders->count() == 0) {
        //     return response()->json([
        //         'status' => 200,
        //         'type' => 'NO_ORDERS',
        //         'message' => 'No orders'
        //     ], 200);
        // }

        // $order_closed = $orders->update([ 'status' => Status::ORDER_CANCELED ]);

        // return response()->json([
        //     'status' => 200,
        //     'type' => 'ALL_ORDERS_CLOSED',
        //     'message' => 'All open order(s) ('. $order_closed .' Orders) are now closed! Reason: Level is already below or equal to the 10% of the equity.'
        // ], 200);
    }

    public function history($symbol)
    {
        $pair = $this->findPair($symbol);

        if (!$pair) {
            return response()->json([
                'success' => false,
                'message' => "Coin Pair not found"
            ]);
        }
        $trades = Trade::where('pair_id', $pair->id)->orderBy('id', 'desc')->take(50)->get();
        return response()->json([
            'success' => true,
            'trades' => $trades
        ]);
    }

    public function orderList(Request $request, $symbol, $status)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:all,open,canceled,completed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $userId = ($request->input('user_data')) ? $request->input('user_data') : auth()->id();

        $query = Order::with('pair')->where('user_id', $userId);


        // if ($request->status && $request->status != 'all') {
        //     $scope = $request->status;
        //     $query->$scope();
        // }

        if ($status == Status::ORDER_OPEN) {
            $query->where('status', Status::ORDER_OPEN);
            $query->orderBy('created_at', 'desc');
        } else {
            $query->where('status', Status::ORDER_CANCELED);
            $query->orderBy('updated_at', 'desc');
        }

        $filter  = $request->get('filter');
        $history = $request->get('history');

        $startDate = null;
        $endDate = null;

        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'last_week':
                $startDate = Carbon::now()->subWeek()->startOfWeek();
                $endDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'last_3_month':
                $startDate = Carbon::now()->subMonth(3)->startOfMonth();
                $endDate = Carbon::now();
                break;
            case 'last_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'custom':
                $startDate = Carbon::parse($request->from_date);
                $endDate = Carbon::parse($request->to_date);
                break;
        }

        if ($startDate && $endDate) {
            $query->whereBetween('updated_at', [$startDate, $endDate]);
        }

        $orders = $query->orderBy('id', 'desc')->get();

        $html   = '';

        if( $history ){

            $pl                        = 0;
            $total_profit              = 0;
            $total_loss                = 0;
            
            foreach ($orders as $co) {
    
                if ($co->profit > 1)  $total_profit =  $total_profit + $co->profit;
                if ($co->profit < 1)  $total_loss =  $total_loss + $co->profit;
    
                $pl = ($pl + $co->profit);
            }
    
            $html = view('components.mobile-transaction-logs', [ 'closed_orders' => $orders, 'pl' => $pl, 'total_profit' => $total_profit, 'total_loss' => $total_loss])->render();
        }

        // $marketDataJson = File::get(base_path('resources/data/data.json'));
        // $marketData = json_decode($marketDataJson);

        // New we will be using to compute profit order of lot value
        $clientGroupId             = ClientGroupUser::where('user_id', $userId)->first();
        $cliID                     = $clientGroupId <> null ? $clientGroupId->client_group_id : 0;
        $clientGroupSymbols        = ClientGroupSetting::where('client_group_id', $cliID)->select('symbol')->get()->pluck('symbol')->toArray();
        $clientGroupSettings       = ClientGroupSetting::where('client_group_id', $cliID)->first();
        foreach ($orders as $key => $co) 
        {
            $orders[$key]->lot_value = null;
            $orders[$key]->order_spread = null;

            if( $clientGroupId <> null )
            {
                if( !empty($clientGroupSymbols) )
                {
                    if( in_array($co->pair->id, $clientGroupSymbols) ){
                        $orders[$key]->lot_value = $clientGroupSettings->lots;
                        $orders[$key]->order_spread = $clientGroupSettings->spread;
                    }
                }
            } 
        }

        $marketDataJson = Http::get('https://tradehousecrm.com/trade/fetchcoinsprice');
        $marketData = json_decode($marketDataJson);

        $wallet = Wallet::where('currency_id', 4)
            ->where('wallet_type', 1)
            ->where('user_id', $userId)
            ->first();

        return response()->json([
            'success' => true,
            'orders' => $orders,
            'marketData' => $marketData,
            'totalRequiredMargin' => $this->requiredMarginTotal($userId),
            'wallet' => $wallet,
            'html' => $html
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function marginlevel(Request $request, $symbol, $status)
    {
        // $exploded_id = explode(',', $request->user_ids);
        $exploded_id = json_decode($request->user_ids);

        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:all,open,canceled,completed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $users = User::with([
            'orders.pair',
            'custom_wallets',
            'orders' => function ($query) use ($status) {
                if ($status == Status::ORDER_OPEN) {
                    $query->where('status', Status::ORDER_OPEN);
                    $query->orderBy('created_at', 'desc');
                } else {
                    $query->where('status', Status::ORDER_CANCELED);
                    $query->orderBy('updated_at', 'desc');
                }
            }
        ])->whereIn('id', $exploded_id)->get();

        $marketDataJson = Http::get('https://tradehousecrm.com/trade/fetchcoinsprice');
        $marketData = json_decode($marketDataJson);

        $users = $users->map(function ($u) {

            foreach ($u->orders as $key => $co) 
            {
                // New we will be using to compute profit order of lot value
                $clientGroupId             = ClientGroupUser::where('user_id', $u->id)->first();
                $cliID                     = $clientGroupId <> null ? $clientGroupId->client_group_id : 0;
                $clientGroupSymbols        = ClientGroupSetting::where('client_group_id', $cliID)->select('symbol')->get()->pluck('symbol')->toArray();
                $clientGroupSettings       = ClientGroupSetting::where('client_group_id', $cliID)->first();
    
                $u->orders[$key]->lot_value = null;
                $u->orders[$key]->order_spread = null;

                if( $clientGroupId <> null )
                {
                    if( !empty($clientGroupSymbols) )
                    {
                        if( in_array($co->pair->id, $clientGroupSymbols) )
                        $u->orders[$key]->lot_value = $clientGroupSettings->lots;
                        $u->orders[$key]->order_spread = $clientGroupSettings->spread;
                    }
                } 
            }
          
            $u->totalRequiredMargin = $u->openOrders()->sum('required_margin');
            
            return $u;
        });

        return response()->json([
            'users' => $users,
            'success' => true,
            'marketData' => $marketData,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function fetchOrderProfit($id)
    {
        $order = Order::with('pair')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        // New we will be using to compute profit order of lot value
        $clientGroupId             = ClientGroupUser::where('user_id', auth()->user()->id)->first();
        $cliID                     = $clientGroupId <> null ? $clientGroupId->client_group_id : 0;
        $clientGroupSymbols        = ClientGroupSetting::where('client_group_id', $cliID)->select('symbol')->get()->pluck('symbol')->toArray();
        $clientGroupSettings       = ClientGroupSetting::where('client_group_id', $cliID)->first();

        $order->lot_value = null;
        $order->order_spread = null;

        if( $clientGroupId <> null )
        {
            if( !empty($clientGroupSymbols) )
            {
                if( in_array($order->pair->id, $clientGroupSymbols) )
                    $order->lot_value = $clientGroupSettings->lots;
                    $order->order_spread = $clientGroupSettings->spread;
            }
        } 

        // $marketDataJson = File::get(base_path('resources/data/data.json'));
        // $marketData = json_decode($marketDataJson);

        $marketDataJson = Http::get('https://tradehousecrm.com/trade/fetchcoinsprice');
        $marketData = json_decode($marketDataJson);

        return response()->json([
            'success' => true,
            'order' => $order,
            'marketData' => $marketData,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function orderBook($symbol = null)
    {
        $pair = $this->findPair($symbol);

        if (!$pair) {
            return response()->json([
                'success' => false,
                'message' => "Coin Pair not found"
            ]);
        }

        $orderType = request()->order_type;
        $query = Order::open()->where('orders.pair_id', $pair->id)
            ->select('orders.*')
            ->leftJoin('trades', 'orders.id', 'trades.order_id')
            ->selectRaw("SUM(orders.amount) as total_amount")
            ->selectRaw("COUNT(DISTINCT orders.id) as total_order")
            ->selectRaw("COUNT(DISTINCT trades.id) as total_trade")
            ->selectRaw('MAX(CASE WHEN orders.user_id = ? THEN 1 ELSE 0 END)  AS has_my_order', [auth()->id()])
            ->groupBy('orders.rate')
            ->orderBy('orders.rate', 'DESC');

        if ($orderType == 'all' || $orderType == 'sell') {
            $sellSideOrders = (clone $query)->sellSideOrder()->take(15)->get();
        }
        if ($orderType == 'all' || $orderType == 'buy') {
            $buySideOrders = (clone $query)->buySideOrder()->take(15)->get();
        }

        return response()->json([
            'success' => true,
            'sell_side_orders' => @$sellSideOrders ?? [],
            'buy_side_orders' => @$buySideOrders ?? [],
        ]);
    }

    private function findPair($symbol = null)
    {
        $pair = CoinPair::active()->activeMarket()->activeCoin();
        if ($symbol) {
            $pair = $pair->where('symbol', $symbol)->first();
        } else {
            $pair = $pair->where('is_default', Status::YES)->first();
        }
        return $pair;
    }

    public function pairs()
    {

        $query = CoinPair::activeMarket()->activeCoin()->with('coin:name,id,symbol', 'market:id,name,currency_id', 'market.currency:id,symbol', 'marketData:id,pair_id,price,html_classes,percent_change_1h');

        if (request()->marketId) {
            $marketId = request()->marketId;
            $query->where(
                ($marketId == 'Stocks' ||
                    $marketId == 'FOREX' ||
                    $marketId == 'COMMODITY' ||
                    $marketId == 'INDEX' ||
                    $marketId == 'Crypto')
                    ? 'type' : 'market_id',
                $marketId
            );
        }

        if (request()->search) {
            $query->where('symbol', 'Like', "%" . request()->search . "%");
        }

        $pairs = $query->orderBy('id', 'desc')->get();
        $favoritePairId = FavoritePair::where('user_id', auth()->id() ?? 0)->pluck('pair_id')->toArray();

        return response()->json([
            'success' => true,
            'pairs' => $pairs,
            'favoritePairId' => $favoritePairId
        ]);
    }

    public function requiredMarginTotal($id = null)
    {
        $uid = (!$id) ? auth()->id() : $id;
        return Order::where('user_id', $uid)->open()->sum('required_margin');
    }
}
