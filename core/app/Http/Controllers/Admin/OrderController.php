<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Market;
use App\Models\Order;
use App\Models\Trade;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function open(Request $request)
    {
        $pageTitle = "Open Order";
        $perPage    = $request->get('per_page', 25);
        $query     = $this->orderData($request, 'open');
        
        $orders = $query->paginate($perPage);

        return view('admin.order.list', compact('pageTitle', 'orders', 'perPage'));
    }

    public function close(Request $request)
    {
        $perPage    = $request->get('per_page', 25);
        $pageTitle = "Close Order";
        $query    = $this->orderData($request, 'canceled');

        $orders = $query->paginate($perPage);
        return view('admin.order.list', compact('pageTitle', 'orders', 'perPage'));
    }

    public function history(Request $request)
    {
        $perPage = $request->get('per_page', 25);
        $pageTitle = "Order History";
        
        // Get the base order query
        $query = $this->orderData($request);
        
        // Add an additional filter for 'status' to be 0
        $query->where('status', 0);
        
        // Paginate the results
        
        $orders = $query->paginate($perPage);

    return view('admin.order.list', compact('pageTitle', 'orders', 'perPage'));
    }

    protected function orderData(Request $request, $scope = null)
    {
        $filter = $request->get('filter');
    
        if ($request->get('customfilter')) {
            $filter = 'custom';
        }
    
        $startDate = null;
        $endDate = null;
    
        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday()->endOfDay();
                break;
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'last_week':
                $startDate = Carbon::now()->subWeek()->startOfWeek();
                $endDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'custom':
                $date = explode('-', $request->get('customfilter'));
                $startDate = Carbon::parse(trim($date[0]))->format('Y-m-d');
                $endDate = @$date[1] ? Carbon::parse(trim(@$date[1]))->format('Y-m-d') : $startDate;
                break;
        }
    
        $query = Order::filter(['order_side', 'user_id', 'status'])
            ->searchable(['id', 'pair:symbol', 'pair.coin:symbol', 'pair.market.currency:symbol'])
            ->with('pair', 'pair.coin', 'pair.market.currency', 'user')
            ->orderBy('id', 'desc');
    
        if ($scope) {
            $query->$scope();
        }
    
        if ($request->filled('id')) {
            $query->where('id', $request->get('id'));
        }
    
        if ($request->filled('name')) {
            $names = explode(' ', $request->get('name'));
            $query->whereHas('user', function ($query) use ($names) {
                foreach ($names as $name) {
                    $query->where(function ($query) use ($name) {
                        $query->where('firstname', 'LIKE', "%{$name}%")
                              ->orWhere('lastname', 'LIKE', "%{$name}%");
                    });
                }
            });
        }
    
        if ($request->filled('volume')) {
            $query->where('no_of_lot', $request->get('volume'));
        }
    
        if ($request->filled('order_type')) {
            $query->where('order_side', $request->get('order_type'));
        }
    
        if ($request->filled('symbol')) {
            $query->whereHas('pair', function ($query) use ($request) {
                $query->where('symbol', $request->get('symbol'));
            });
        }
    
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        $query->whereHas('user');
    
        // Return the query object, not paginated results
        return $query;
    }
    
    public function tradeHistory(Request $request)
    {
            
        $pageTitle = "Trade History";
        $perPage = $request->get('per_page', 25);
        
        $orders = Order::where('user_id', $request->trader_id)->canceled()->paginate($perPage);
        return view('admin.order.list', compact('pageTitle', 'orders', 'perPage'));
    }

    public function edit(Order $order): View
    {
        $pageTitle = "Edit Open Order";
        $markets = Market::with('currency')
            ->active()
            ->get();
    
        return view('admin.order.edit', compact('markets', 'order', 'pageTitle'));
    }

    public function update(UpdateRequest $request, Order $order)
    {
        DB::transaction(
            function () use ($request, $order) {
                $order->update($request->validated());
            }
        );

        return returnBack('Open price updated successfully', 'success');
    }

    public function destroy(Order $order)
    {
        DB::transaction(
            function () use ($order) {
                $order->delete();
            }
        );

        return returnBack('Open price delete successfully', 'success');
    }

    public function fetchMarketData() {
        // $marketDataJson = File::get(base_path('resources/data/data.json'));
        // $marketData = json_decode($marketDataJson);

        $marketDataJson = Http::get('https://tradehousecrm.com/trade/fetchcoinsprice');
        $marketData = json_decode($marketDataJson);

        return response()->json($marketData);
    }
}
