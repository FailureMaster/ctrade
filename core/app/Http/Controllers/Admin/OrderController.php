<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\User;
use App\Models\Admin;
use App\Models\Market;
use App\Models\Order;
use App\Models\Trade;
use App\Models\SalesStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function open(Request $request)
    {
        $pageTitle = "Open Order";
        $perPage    = $request->get('per_page', 25);
        $query     = $this->orderData($request, 'open');
        
        $orders = $query->paginate($perPage);

        $this->loadUserList($request, $pageTitle, 'active', $history = 'clients');

        return view('admin.order.list', compact('pageTitle', 'orders', 'perPage'));
    }

    public function close(Request $request)
    {
        $perPage    = $request->get('per_page', 25);
        $pageTitle = "Close Order";
        $query    = $this->orderData($request, 'canceled');

        $orders = $query->paginate($perPage);

        $this->loadUserList($request, $pageTitle, 'active', $history = 'clients');
        
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

    protected function getAdmins()
    {
        return Admin::whereNot('permission_group_id', 1)->whereNot('id', 2)->get();
    }

    public function userList(Request $request, $pageTitle, $userType, $history = 'clients')
    {
        // Get the 'filter' parameter from the request
        $filter = $request->get('filter');
    
        // If 'customfilter' is present in the request, set the filter to 'custom'
        if ($request->get('customfilter')) {
            $filter = 'custom';
        }
    
        // Initialize start and end dates to null
        $startDate = null;
        $endDate = null;
    
        // Determine the date range based on the filter
        switch ($filter) {
            case 'today':
                // Set the date range to today
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'yesterday':
                // Set the date range to yesterday
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday()->endOfDay();
                break;
            case 'this_week':
                // Set the date range to the current week
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'last_week':
                // Set the date range to the previous week
                $startDate = Carbon::now()->subWeek()->startOfWeek();
                $endDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                // Set the date range to the current month
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                // Set the date range to the previous month
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'all_time':
                // Set the date range to all time (no filtering)
                $startDate = null;
                $endDate = null;
                break;
            case 'custom':
                // Set the date range based on a custom filter
                $date = explode('-', $request->get('customfilter'));
                $startDate = Carbon::parse(trim($date[0]))->format('Y-m-d');
                $endDate = @$date[1] ? Carbon::parse(trim(@$date[1]))->format('Y-m-d') : $startDate;
                break;
        }
    
        // Get the 'per_page' parameter from the request, defaulting to 25
        $perPage = $request->get('per_page', 25);
    
        // Fetch the user data based on the user type and date range, then paginate
        
        $orderDirection = $request->query('direction');
        // dd($orderDirection);
        
        if( $request->query('orderby')=='created_at') {
            $columnName = 'created_at';
        }elseif($request->query('orderby') == 'updated_at'){
            $columnName = 'updated_at';
        }else{
            $columnName = 'id';
        }

        $users = $this->userData($columnName, $orderDirection, $userType, $startDate, $endDate)->paginate($perPage);

        Session::put('users_data', $users);

        // Get the list of admins
        $admins = $this->getAdmins();
        
        // Get all sales statuses
        $salesStatuses = SalesStatus::all();
        
        // Load and decode the countries from a JSON file
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')), true);
    
        // Get the total number of user records
        $totalRecords = $users->total();
    
        // Determine country codes and lead sources based on the user type
        if ($userType == 'active') {
            $countryCodes = User::where('account_type', 'real')->distinct()->pluck('country_code')->toArray();
            $leadSources = User::where('account_type', 'real')->whereNotNull('lead_source')->distinct()->pluck('lead_source');
        } else {
            $countryCodes = User::where('account_type', 'demo')->distinct()->pluck('country_code')->toArray();
            $leadSources = User::where('account_type', 'demo')->whereNotNull('lead_source')->distinct()->pluck('lead_source');
        }
    
        // Filter the countries based on the country codes
        $filteredCountries = array_filter($countries, function ($key) use ($countryCodes) {
            return in_array($key, $countryCodes);
        }, ARRAY_FILTER_USE_KEY);
    
        // Get the total number of user records again (if needed)
        $totalRecords = $users->total();

        if ($orderDirection == null) {
            $orderDirection = 'desc';
            // dd('desc sa null');
        }elseif($orderDirection == 'desc') {
            // dd('desc');
            $orderDirection = 'asc';
        }else{
            // dd('asc');
            $orderDirection = 'desc';
        }
    

        // Return the 'admin.users.list' view with the provided data
        return view('admin.order.marginlevel', compact('pageTitle', 'users', 'admins', 'salesStatuses', 'filteredCountries', 'history', 'totalRecords', 'perPage', 'leadSources', 'orderDirection', 'columnName'));
    }

    protected function userData($columnName, $orderDirection, $scope = null, $startDate = null, $endDate = null)
    {
        if ($scope) {
            $users = User::$scope();
        } else {
            $users = User::query();
        }
        if (!can_access('access-all-users')) {
            if (can_access('manage-sales-leads')) {
                $users->whereDoesntHave('wallets', function ($query) {
                    $query->where('balance', '!=', 0);
                });
            } else if (can_access('manage-retention-leads')) {
                $users->whereHas('wallets', function ($query) {
                    $query->where('balance', '!=', 0);
                });
            } else {
                $users->where(['owner_id' => auth()->guard('admin')->user()->id]);
            }
        }

        if ($startDate && $endDate) {
            $users->whereBetween('users.created_at', [$startDate, $endDate]);
        }
        

        if ($orderDirection == null) {
            $orderDirection = 'desc';
        }elseif($orderDirection == 'desc') {
            $orderDirection = 'desc';
        }else{
            $orderDirection = 'asc';
        }
        
        if ($columnName == 'id') {
            $tblName = 'users';
        }else{
            $tblName = ($columnName == 'created_at' ) ? 'users' : 'comments';
        }
       // Optimized query for joining latest comments
        $users = $users->leftJoinSub(
            DB::table('comments')
                ->select('user_id', DB::raw('MAX(id) as latest_comment_id'))
                ->groupBy('user_id'),
            'latest_comments',
            function ($join) {
                $join->on('users.id', '=', 'latest_comments.user_id');
            }
        )
        ->leftJoin('comments', 'latest_comments.latest_comment_id', '=', 'comments.id');

        return $users->with('owner')
            ->with('comments.commentor')->whereHas('wallets', function ($query) {
                $query->where('balance', '!=', 0);
                   
            })
            ->when(request()->get('name'), function ($query, $name) {
                $query->where('firstname', 'LIKE', "%{$name}%")
                    ->orWhere('lastname', 'LIKE', "%{$name}%");
            })
            ->when(request()->get('mobile'), function ($query, $mobile) {
                $query->where('mobile', 'LIKE', "%{$mobile}%");
            })
             ->when(request()->get('email'), function ($query, $email) {
                $query->where('email', 'LIKE', "%{$email}%");
            })
            ->searchable([
                'id',
                'email',
                'firstname',
                'lastname',
                'mobile',
                'country_code',
                'account_type',
            ])
            ->filter([
                'lead_code',
                'sales_status',
                'owner_id',
                'country_code',
                'lead_source'
            ])
            ->select([
                'users.id',
                'lead_code',
                'account_type',
                'firstname',
                'lastname',
                'mobile',
                'email',
                'country_code',
                'sales_status',
                'users.created_at',
                'comments.updated_at',
                'lead_source',
                'users.owner_id'
            ])
            ->orderBy($tblName.'.'.$columnName, $orderDirection);
        
        // ->paginate(getPaginate());
    }

    public function manageLevel(Request $request)
    {
        $pageTitle = 'Margin Levels';
        return $this->userList($request, $pageTitle, 'active');
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

    private function loadUserList(Request $request, $pageTitle, $userType)
    {
        // Get the 'filter' parameter from the request
        $filter = $request->get('filter');
            
        // If 'customfilter' is present in the request, set the filter to 'custom'
        if ($request->get('customfilter')) {
            $filter = 'custom';
        }

        // Initialize start and end dates to null
        $startDate = null;
        $endDate = null;

        // Determine the date range based on the filter
        switch ($filter) {
            case 'today':
                // Set the date range to today
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'yesterday':
                // Set the date range to yesterday
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday()->endOfDay();
                break;
            case 'this_week':
                // Set the date range to the current week
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'last_week':
                // Set the date range to the previous week
                $startDate = Carbon::now()->subWeek()->startOfWeek();
                $endDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                // Set the date range to the current month
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                // Set the date range to the previous month
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'all_time':
                // Set the date range to all time (no filtering)
                $startDate = null;
                $endDate = null;
                break;
            case 'custom':
                // Set the date range based on a custom filter
                $date = explode('-', $request->get('customfilter'));
                $startDate = Carbon::parse(trim($date[0]))->format('Y-m-d');
                $endDate = @$date[1] ? Carbon::parse(trim(@$date[1]))->format('Y-m-d') : $startDate;
                break;
        }

        // Get the 'per_page' parameter from the request, defaulting to 25
        $perPage = $request->get('per_page', 25);

        // Fetch the user data based on the user type and date range, then paginate

        $orderDirection = $request->query('direction');
        // dd($orderDirection);

        if( $request->query('orderby')=='created_at') {
            $columnName = 'created_at';
        }elseif($request->query('orderby') == 'updated_at'){
            $columnName = 'updated_at';
        }else{
            $columnName = 'id';
        }

        $users = $this->userData($columnName, $orderDirection, $userType, $startDate, $endDate)->paginate($perPage);

        Session::put('users_data', $users);
    }
}
