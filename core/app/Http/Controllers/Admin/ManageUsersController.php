<?php

namespace App\Http\Controllers\Admin;

use Users;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Trade;
use App\Models\Wallet;
use App\Models\Comment;
use App\Models\Deposit;
use App\Models\Currency;
use App\Constants\Status;
use App\Constants\Defaults;
use App\Models\SalesStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\StoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\User\SalesStatus\StoreRequest as SalesStatusStoreRequest;
use App\Models\UserDetailsHistory;
use Exception;
use Illuminate\Validation\Rule;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ManageUsersController extends Controller
{
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

        if ($request->query('orderby') == 'created_at') {
            $columnName = 'created_at';
        } elseif ($request->query('orderby') == 'updated_at') {
            $columnName = 'updated_at';
        } else {
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
        } elseif ($orderDirection == 'desc') {
            // dd('desc');
            $orderDirection = 'asc';
        } else {
            // dd('asc');
            $orderDirection = 'desc';
        }


        // Return the 'admin.users.list' view with the provided data
        return view('admin.users.list', compact('pageTitle', 'users', 'admins', 'salesStatuses', 'filteredCountries', 'history', 'totalRecords', 'perPage', 'leadSources', 'orderDirection', 'columnName'));
    }

    public function allUsers(Request $request)
    {
        $pageTitle = 'All Leads';
        return $this->userList($request, $pageTitle, 'inactive', 'leads', 'lead_source');
    }

    public function activeUsers(Request $request)
    {
        $pageTitle = 'Active Users';
        return $this->userList($request, $pageTitle, 'active');
    }

    public function bannedUsers(Request $request)
    {
        $pageTitle = 'Banned Users';
        return $this->userList($request, $pageTitle, 'banned');
    }

    public function emailUnverifiedUsers(Request $request)
    {
        $pageTitle = 'Email Unverified Users';
        return $this->userList($request, $pageTitle, 'emailUnverified');
    }

    public function kycUnverifiedUsers(Request $request)
    {
        $pageTitle = 'KYC Unverified Users';
        return $this->userList($request, $pageTitle, 'kycUnverified');
    }

    public function kycPendingUsers(Request $request)
    {
        $pageTitle = 'KYC Pending Users';
        return $this->userList($request, $pageTitle, 'kycPending');
    }

    public function emailVerifiedUsers(Request $request)
    {
        $pageTitle = 'Email Verified Users';
        return $this->userList($request, $pageTitle, 'emailVerified');
    }

    public function mobileUnverifiedUsers(Request $request)
    {
        $pageTitle = 'Mobile Unverified Users';
        return $this->userList($request, $pageTitle, 'mobileUnverified');
    }

    public function mobileVerifiedUsers(Request $request)
    {
        $pageTitle = 'Mobile Verified Users';
        return $this->userList($request, $pageTitle, 'mobileVerified');
    }

    protected function userData($columnName, $orderDirection, $scope = null, $startDate = null, $endDate = null, $is_online = 0)
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
            if (request()->get('comments') <> null && request()->comments == "has_comment") {
                if (request()->comments == "has_comment") {
                    $users->whereHas('comments', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('comments.created_at', [$startDate, $endDate]);
                    });
                }
            } else
                $users->whereBetween('users.created_at', [$startDate, $endDate]);
        }

        // check teh order
        // dd($orderDirection);
        // $orderDirection = ($orderDirection == 'desc') ? 'asc' : 'desc';


        if ($orderDirection == null) {
            $orderDirection = 'desc';
        } elseif ($orderDirection == 'desc') {
            $orderDirection = 'desc';
        } else {
            $orderDirection = 'asc';
        }

        if ($is_online) {
            // Get current time
            $currentTime = Carbon::now();

            // Calculate the time 2 minutes ago
            $timeThreshold = $currentTime->subMinutes(5);

            $users = $users->where('users.last_request', '>=', $timeThreshold);
        }

        // $users = $users->join('comments', 'users.id', '=', 'comments.user_id');

        if ($columnName == 'id') {
            $tblName = 'users';
        } else {
            $tblName = ($columnName == 'created_at') ? 'users' : 'comments';
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

        if (request()->has('owner_id') && request()->owner_id <> "") {
            $users = $users->where('owner_id', request()->owner_id);
        }

        return $users->with('owner')
            // ->with('comments.commentor', 'loginLogs', 'userDetailHistory', 'comments')
            ->with('loginLogs', 'userDetailHistory')
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
            ->when(request()->get('comments'), function ($query, $email) {
                if (request()->comments <> "") {
                    if (request()->comments == "has_comment")
                        $query->whereHas('comments');
                    else
                        $query->whereDoesntHave('comments');
                }
            })

            ->when(request()->get('muliple_search'), function ($query) {
                if (request()->muliple_search <> "" && request()->search_by_value <> "") {
                    if (request()->muliple_search == "email")
                        $query->where('email', request()->search_by_value);
                    if (request()->muliple_search == "name") {
                        $query->where('firstname', 'LIKE', "%" . request()->search_by_value . "%")
                            ->orWhere('lastname', 'LIKE', "%" . request()->search_by_value . "%");
                    }
                    if (request()->muliple_search == "id") {
                        $query->where('users.lead_code', request()->search_by_value);
                    }
                    if (request()->muliple_search == "mobile") {
                        $query->where('mobile', request()->search_by_value);
                    }
                }
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
                // 'owner_id',
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
                'users.owner_id',
                'users.user_source',
                'users.last_request',
                'users.show_commentor_comments'
            ])
            ->orderBy($tblName . '.' . $columnName, $orderDirection);
        // ->paginate(getPaginate());
    }

    public function detail($id)
    {
        $user_data = Session::get('users_data');
        $user_data2 = $user_data->all();

        $index = 0;

        foreach ($user_data->where('id', $id) as $key => $value) {
            $index = $key;
        }

        $previousUser   = ($index != 0) ? $user_data2[($index - 1)] : 0;
        $nextUser       =  isset($user_data2[($index + 1)]) ? $user_data2[($index + 1)] : null;

        $user = User::findOrFail($id);

        $pageTitle = 'User Detail - ' . $user->fullname;

        if ($user->account_type == "demo") $pageTitle = "";

        $widget = [];
        $widget['total_trade'] = Trade::where('trader_id', $user->id)->count();
        $widget['total_order'] = Trade::where('order_id', $user->id)->count();
        // $widget['total_deposit'] = Deposit::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->count();
        $widget['total_deposit'] = Deposit::where('user_id', $user->id)->count();
        $widget['total_transaction'] = Transaction::where('user_id', $user->id)->count();

        $order = Order::where('user_id', $user->id);
        $widget['open_order']      = (clone $order)->open()->count();
        $widget['canceled_order']  = (clone $order)->canceled()->count();

        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $currencies = Currency::active()->get();

        $marketCurrencyWallet = Wallet::where('user_id', $user->id)->where('currency_id', Defaults::DEF_WALLET_CURRENCY_ID /* $pair->market->currency->id */)->spot()->first();
        $requiredMarginTotal = Order::where('user_id', $user->id)->open()->sum('required_margin');

        // Get the list of admins
        $admins = $this->getAdmins();

        // Get all sales statuses
        $salesStatuses = SalesStatus::all();

        return view('admin.users.detail', compact('pageTitle', 'user', 'previousUser', 'nextUser', 'widget', 'countries', 'currencies', 'marketCurrencyWallet', 'requiredMarginTotal', 'admins', 'salesStatuses'));
    }


    public function kycDetails($id)
    {
        $pageTitle = 'KYC Details';
        $user = User::findOrFail($id);
        return view('admin.users.kyc_detail', compact('pageTitle', 'user'));
    }

    public function kycApprove($id)
    {
        $user = User::findOrFail($id);
        $user->kv = 1;
        $user->save();

        notify($user, 'KYC_APPROVE', []);

        $notify[] = ['success', 'KYC approved successfully'];
        return to_route('admin.users.kyc.pending')->withNotify($notify);
    }

    public function kycReject($id)
    {
        $user = User::findOrFail($id);
        foreach ($user->kyc_data as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $user->kv = 0;
        $user->kyc_data = null;
        $user->save();

        notify($user, 'KYC_REJECT', []);

        $notify[] = ['success', 'KYC rejected successfully'];
        return to_route('admin.users.kyc.pending')->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray = (array) $countryData;
        $countries = implode(',', array_keys($countryArray));

        $countryCode = $request->country;
        $country = $countryData->$countryCode->country;
        $dialCode = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname' => 'required|string|max:40',
            // 'age' => 'required|integer',
            // 'email' => 'required|email|string|max:40|unique:users,email,' . $user->id,
            'email' => [
                'required',
                'email',
                'string',
                'max:40',
                Rule::unique('users', 'email')
                    ->ignore($user->id)
                    ->whereNull('deleted_at'), // Ignores soft-deleted records
            ],
            // 'mobile' => 'required|string|max:40|unique:users,mobile,' . $user->id,
            'mobile' => [
                'required',
                'string',
                'max:40',
                Rule::unique('users', 'mobile')
                    ->ignore($user->id)
                    ->whereNull('deleted_at'),
            ],
            'country' => 'required|in:' . $countries,
            'comment' => 'nullable|string|max:1024',
            'password' => 'sometimes',
        ]);

        if ($request->comment <> null) {
            Comment::create([
                'user_id' => $id,
                'comment' => $request->comment,
                'commented_by' => auth()->guard('admin')->user()->id,
            ]);
        }

        // $user->comment = $request->comment;
        $user->sales_status = $request->status;
        $user->mobile = $request->mobile;
        $user->country_code = $countryCode;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        
        $user->age = $request->age;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = [
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$country,
        ];
        $user->ev = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $user->sv = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        $user->ts = $request->ts ? Status::ENABLE : Status::DISABLE;

        if ($request->has('owner_id'))  $user->owner_id = $request->owner_id;

        if (!$request->kv) {
            $user->kv = 0;
            if ($user->kyc_data) {
                foreach ($user->kyc_data as $kycData) {
                    if ($kycData->type == 'file') {
                        fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
                    }
                }
            }
            $user->kyc_data = null;
        } else {
            $user->kv = 1;
        }

        // lead type
        if ($request->has('lead_type')) {
            $user->account_type = $request->lead_type;
        }

        $user->save();

        $notify[] = ['success', 'User details updated successfully'];
        return back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'amount' => 'nullable|numeric|gt:0',
            'bonus' => 'nullable|numeric|gt:0',
            'credit' => 'nullable|numeric|gt:0',
            'wallet' => 'required|integer',
            'act' => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
            'wallet_type' => 'required|in:' . implode(',', array_keys((array) gs('wallet_types')))
        ]);

        $user = User::findOrFail($id);
        $walletScope = $request->wallet_type;
        $wallet = Wallet::where('user_id', $user->id)->$walletScope()->where('currency_id', $request->wallet)->first();

        $amount = isset($request->amount) ? $request->amount : 0;
        $bonus  = isset($request->bonus) ? $request->bonus : 0;
        $credit = isset($request->credit) ? $request->credit : 0;
        $totalTransactionAmount = $amount + $bonus + $credit;
        $trx = getTrx();


        $transaction = new Transaction();

        // Empty array
        $addType = [];

        if ($request->act == 'add') {
            if (!$wallet) {

                $walletType = $request->wallet_type == 'spot' ? Status::WALLET_TYPE_SPOT : Status::WALLET_TYPE_FUNDING;

                $walletNew = new Wallet();
                $walletNew->currency_id = $request->wallet;
                $walletNew->wallet_type = $walletType;

                $walletNew->user_id = $user->id;
                $walletNew->balance = $amount;
                $walletNew->bonus = $bonus;
                $walletNew->credit = $credit;
                $walletNew->save();

                $wallet = $walletNew->fresh();
            } else {
                $wallet->balance += $amount;
                $wallet->bonus += $bonus;
                $wallet->credit += $credit;
                $wallet->save();
            }

            $transaction->trx_type = '+';
            $transaction->remark = 'balance_add';
            $notifyTemplate = 'BAL_ADD';

            if ($amount) {
                array_push($addType, ['balance_add' => $amount]);
            }
            if ($bonus) {
                array_push($addType, ['bonus_add' => $bonus]);
            }
            if ($credit) {
                array_push($addType, ['credit_add' => $credit]);
            }

            $notify[] = ['success', gs('cur_sym') . $amount . ' added successfully'];
        } else {
            if ($amount > $wallet->balance) {
                $notify[] = ['error', $user->fullname . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $wallet->balance -= $amount;
            $wallet->bonus = max(0, $wallet->bonus - $bonus);
            $wallet->credit = max(0, $wallet->credit - $credit);
            $wallet->save();

            $transaction->trx_type = '-';
            $transaction->remark = 'balance_subtract';

            $notifyTemplate = 'BAL_SUB';
            $notify[] = ['success', gs('cur_sym') . $amount . ' subtracted successfully'];
        }

        $user->save();



        //check 
        if (!empty($addType)) {
            foreach ($addType as $at) {
                foreach ($at as $key => $a) {
                    $transaction = new Transaction();
                    $transaction->trx_type = '+';
                    $transaction->remark = $key;
                    $transaction->user_id = $user->id;
                    $transaction->wallet_id = $wallet->id;
                    $transaction->amount = $a;
                    $transaction->post_balance = $wallet->balance;
                    $transaction->charge = 0;
                    $transaction->trx = $trx;
                    $transaction->details = $request->remark;
                    $transaction->made_by = Auth::guard('admin')->user()->id;
                    $transaction->save();
                }
            }
        } else {
            $transaction->user_id = $user->id;
            $transaction->wallet_id = $wallet->id;
            $transaction->amount = $totalTransactionAmount;
            $transaction->post_balance = $wallet->balance;
            $transaction->charge = 0;
            $transaction->trx = $trx;
            $transaction->details = $request->remark;
            $transaction->made_by = Auth::guard('admin')->user()->id;
            $transaction->save();
        }

        notify($user, $notifyTemplate, [
            'trx' => $trx,
            'amount' => showAmount($amount),
            'remark' => $request->remark,
            'post_balance' => showAmount($user->balance),
            'wallet_currency' => @$wallet->currency->symbol,
        ]);

        $estimatedBalance   = Wallet::where([
            'user_id' => $id,
            'currency_id' => Defaults::DEF_WALLET_CURRENCY_ID
        ])->join('currencies', 'wallets.currency_id', 'currencies.id')->spot()->sum(DB::raw('currencies.rate * wallets.balance'));

        // dd($estimatedBalance);
        // Set up Pusher
        $pusher = new Pusher(
            'c5afd2b879ff37c4a429',
            'bc91ce796e70e0861721',
            '1688847',
            [
                'cluster' => 'ap2',
                'useTLS' => true,
            ]
        );

        // Data to send to Pusher
        $data = [
            'balance' => $estimatedBalance
        ];

        // Trigger the event on Pusher
        $pusher->trigger("user-balance-channel-$id", 'user-balance-change', $data);
        return back()->withNotify($notify);
    }
    public function login($id)
    {
        Auth::loginUsingId($id);
        return to_route('user.home');
    }

    public function status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $user->status = Status::USER_BAN;
            $user->ban_reason = $request->reason;
            $notify[] = ['success', 'User banned successfully'];
        } else {
            $user->status = Status::USER_ACTIVE;
            $user->ban_reason = null;
            $notify[] = ['success', 'User unbanned successfully'];
        }
        $user->save();
        return back()->withNotify($notify);
    }


    public function showNotificationSingleForm($id)
    {
        $user = User::findOrFail($id);
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.users.detail', $user->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $user->fullname;
        return view('admin.users.notification_single', compact('pageTitle', 'user'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {

        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        notify($user, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }
        $notifyToUser = User::notifyToUser();
        $users = User::active()->count();
        $pageTitle = 'Notification to Verified Users';
        return view('admin.users.notification_all', compact('pageTitle', 'users', 'notifyToUser'));
    }

    public function sendNotificationAll(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'subject' => 'required',
            'start' => 'required',
            'batch' => 'required',
            'being_sent_to' => 'required',
            'user' => 'required_if:being_sent_to,selectedUsers',
            'number_of_top_deposited_user' => 'required_if:being_sent_to,topDepositedUsers|integer|gte:0',
            'number_of_days' => 'required_if:being_sent_to,notLoginUsers|integer|gte:0',
        ], [
            'number_of_days.required_if' => "Number of days field is required",
            'number_of_top_deposited_user.required_if' => "Number of top deposited user field is required",
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->all()]);

        $scope = $request->being_sent_to;
        $users = User::oldest()->active()->$scope()->skip($request->start)->limit($request->batch)->get();
        foreach ($users as $user) {
            notify($user, 'DEFAULT', [
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
        }
        return response()->json([
            'total_sent' => $users->count(),
        ]);
    }

    public function notificationLog($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $user->fullname;
        $logs = NotificationLog::where('user_id', $id)->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'user'));
    }

    public function list()
    {
        $query = User::active();

        if (request()->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . request()->search . '%');
            });
        }
        $users = $query->orderBy('id', 'desc')->paginate(getPaginate());
        return response()->json([
            'success' => true,
            'users' => $users,
            'more' => $users->hasMorePages()
        ]);
    }
    public function toggleFavorite($id)
    {
        $user = User::findOrFail($id);
        $user->favorite = !$user->favorite;
        $user->save();
        return back();
    }
    public function toggleType($id)
    {
        $user = User::findOrFail($id);

        if ($user->account_type == 'demo') {
            $user->balance = 0;
            $user->save();

            Wallet::where('user_id', $user->id)->update(['balance' => $user->balance]);
        }

        $user->account_type = $user->account_type == 'demo' ? 'real' : 'demo';
        $user->save();
        return back();
    }
    public function updateComment(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            // 'comment' => 'required|string|max:1024',
            'hide_comments' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = User::find($id);
        if (!$user) {
            $notify[] = ['error', 'User not found'];
            return back()->withNotify($notify);
        }

        // Update the user's comment
        // $user->comment = $request->comment;
        $user->show_commentor_comments = $request->hide_comments;
        $user->save();

        $notify[] = ['success', 'Comment updated successfully'];
        return back()->withNotify($notify);
    }

    public function updateOwner(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'owner' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != 0 && !Admin::where('id', $value)->exists()) {
                        $fail('Selected owner not found');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $owner = Admin::find($request->owner);
        if (!$owner && $request->owner != 0) {
            $notify[] = ['error', 'Selected owner not found'];
            return back()->withNotify($notify);
        }
        $user = User::find($id);
        $old_owner = $user->owner <> null ? $user->owner->name : "No Owner";
        if (!$user) {
            $notify[] = ['error', 'User not found'];
            return back()->withNotify($notify);
        }

        // Update the user's comment
        $user->owner_id = $request->owner == 0 ? null : $owner->id;

        if ($user->save()) {
            // Save to history table
            $userDetails = new UserDetailsHistory();
            $userDetails->user_id = $user->id;
            $userDetails->remarks = "Changed owner from $old_owner to " . ($request->owner == 0 ? "No Owner" : $owner->name);
            $userDetails->updated_by = Auth::guard('admin')->user()->id;
            $userDetails->save();
        }

        $notify[] = ['success', 'User assigned to owner' . ($owner ? (' ' . $owner->name) : '')];
        return back()->withNotify($notify);
    }

    public function updateSalesStatus(Request $request, $id)
    {

        $salesStatuses = SalesStatus::all()
            ->pluck('name')
            ->toArray();

        $statusList = implode(',', $salesStatuses);

        // 2. Validation
        $validatorSettings = [
            'status' => 'required|in:' . $statusList
        ];
        $validator = Validator::make($request->all(), $validatorSettings);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validatedData = $request->validate($validatorSettings);
        $user = User::find($id);

        $oldStatus = $user->sales_status;

        if (!$user) {
            $notify[] = ['error', 'User not found'];
            return back()->withNotify($notify);
        }

        $user->sales_status = $validatedData['status'];

        if ($user->save()) {
            // Save to history table
            $userDetails = new UserDetailsHistory();
            $userDetails->user_id = $user->id;
            $userDetails->remarks = "Changed status from $oldStatus to " . $validatedData['status'];
            $userDetails->updated_by = Auth::guard('admin')->user()->id;
            $userDetails->save();
        }

        $notify[] = ['success', 'Sales status updated successfully!'];
        return back()->withNotify($notify);
    }

    public function create()
    {
        $pageTitle = 'New Lead';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('admin.users.create', compact('pageTitle', 'mobileCode', 'countries'));
    }

    public function store(StoreRequest $request)
    {
        $user = DB::transaction(
            function () use ($request) {
                $user = User::create(
                    array_merge(
                        [
                            'password' => Hash::make('123456'),
                            'mobile' => $request->get('mobile_code') . $request->get('mobile'),
                            'address' => [
                                'address' => '',
                                'state' => '',
                                'zip' => '',
                                'country' => $request->get('country') ?? null,
                                'city' => ''
                            ],
                            'ev' => 1,
                            'sv' => 1,
                            'kv' => 1,
                            'profile_complete' => 1,
                            'account_type' => $request->account_type,
                            'user_source' => 'manual',
                            'added_by' => auth()->guard('admin')->user()->id
                        ],
                        $request->safe()->except(['mobile_code', 'country'])
                    )
                );

                return $user;
            }
        );

        if ($user->wasRecentlyCreated) {
            $currencies = Currency::active()
                ->leftJoin('wallets', function ($q) use ($user) {
                    $q->on('currencies.id', '=', 'wallets.currency_id')->where('user_id', $user->id);
                })
                ->whereNull('wallets.currency_id')
                ->select('currencies.*')
                ->get();

            $wallets = [];
            $now = now();
            $walletTypes = gs('wallet_types');

            foreach ($currencies as $currency) {
                foreach ($walletTypes as $walletType) {
                    $wallets[] = [
                        'user_id' => $user->id,
                        'currency_id' => $currency->id,
                        'balance' => allowsDemoAccount() ? 1000 : 0,
                        'wallet_type' => $walletType->type_value,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
            }

            if (count($wallets)) {
                DB::table('wallets')->insert($wallets);
            }
        }

        return returnBack('Lead created successfully!', 'success');
    }

    public function destroy(User $user)
    {
        DB::transaction(
            function () use ($user) {
                $user->delete();
            }
        );

        return returnBack('User delete successfully', 'success');
    }

    public function importView()
    {
        $pageTitle = 'Import Leads';

        return view('admin.users.import_view', compact('pageTitle'));
    }


    public function import(Request $request)
    {

        Log::info('Import method accessed');
        $request->validate([
            'filepond' => 'required|mimes:csv,txt|max:2048'  // max:2048 means the file size should not be greater than 2MB (2048KB)
        ]);

        Log::info('File validated');


        $path = $request->file('filepond')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Skip the first row (headers)
        $data = array_slice($data, 1);

        // Load country data from JSON
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')), true);

        $columnNames = ['First Name', 'Last Name', 'Email', 'Mobile', 'Country Code', 'Account Type', 'Lead Source'];
        $errors = [];
        $rowNumber = 2; // Start from 2 because we skipped the header row
        $insertedCount = 0;

        foreach ($data as $row) {
            if (count($row) < 6) { // Adjusted count to match new column count
                $errors[] = "Row $rowNumber: Missing data in one or more columns.";
            } else {
                $missingColumns = [];
                foreach ($row as $key => $value) {
                    if (empty($value)) {
                        $missingColumns[] = $columnNames[$key];
                    }
                }
                if (!empty($missingColumns)) {
                    $errors[] = "Row $rowNumber: Missing data in columns: " . implode(', ', $missingColumns) . ".";
                } else {
                    // Check for duplicates (e.g., using email as a unique identifier)
                    $existingUser = User::where('email', $row[2])->first();

                    if ($existingUser) {
                        $errors[] = "Row $rowNumber: Duplicate entry found for email '{$row[2]}'.";
                    } else {
                        // Get the country code from the row and look up the country and dial code
                        $countryCode = $row[4];
                        $country     = null;
                        $dialCode    = null;

                        if (isset($countryData[$countryCode])) {
                            $country     = $countryData[$countryCode]['country'] ?? null;
                            $dialCode    = $countryData[$countryCode]['dial_code'] ?? null;
                        } else {
                            foreach ($countryData as $code => $c) {
                                if (strtolower($c['country']) == strtolower($countryCode)) {
                                    $countryCode = $code;
                                    $country  = $c['country'];
                                    $dialCode = $code;
                                }
                            }
                        }

                        if (!$country || !$dialCode) {
                            $errors[] = "Row $rowNumber: Invalid country code '{$countryCode}'.";
                        } else {
                            $user = DB::transaction(function () use ($row, $country, $dialCode, $countryCode) {
                                return User::create([
                                    'firstname' => $row[0],
                                    'lastname' => $row[1],
                                    'email' => $row[2],
                                    'mobile' => preg_replace('/\D/', '', $row[3]),
                                    'address' => [
                                        'address' => '',
                                        'state' => '',
                                        'zip' => '',
                                        'country' => $country,
                                        'city' => ''
                                    ],
                                    'country_code' => $countryCode,
                                    'account_type' => $row[5],
                                    'lead_source' => $row[6],
                                    'password' => Hash::make('123456'),
                                    'ev' => 1,
                                    'sv' => 1,
                                    'kv' => 1,
                                    'profile_complete' => 1,
                                    'user_source' => 'import',
                                    'added_by' => auth()->guard('admin')->user()->id
                                ]);
                            });

                            if ($user->wasRecentlyCreated) {
                                $currencies = Currency::active()
                                    ->leftJoin('wallets', function ($q) use ($user) {
                                        $q->on('currencies.id', '=', 'wallets.currency_id')->where('user_id', $user->id);
                                    })
                                    ->whereNull('wallets.currency_id')
                                    ->select('currencies.*')
                                    ->get();

                                $wallets = [];
                                $now = now();
                                $walletTypes = gs('wallet_types');

                                foreach ($currencies as $currency) {
                                    foreach ($walletTypes as $walletType) {
                                        $wallets[] = [
                                            'user_id' => $user->id,
                                            'currency_id' => $currency->id,
                                            'balance' => allowsDemoAccount() ? 1000 : 0,
                                            'wallet_type' => $walletType->type_value,
                                            'created_at' => $now,
                                            'updated_at' => $now
                                        ];
                                    }
                                }

                                if (count($wallets)) {
                                    DB::table('wallets')->insert($wallets);
                                }
                            }

                            $insertedCount++;
                        }
                    }
                }
            }
            $rowNumber++;
        }

        if (!empty($errors)) {
            Log::info('Errors found', $errors);
            return response()->json(['Success' => false, 'errors' => $errors, 'rowCount' => $insertedCount]);
        }

        Log::info('Import successful');
        return response()->json(['Success' => true, 'rowCount' => $insertedCount]);
    }


    public function export()
    {
        $filename = 'leads-template.csv';

        if (!Storage::disk('public')->exists($filename)) {
            abort(404);
        }

        return response()->download(storage_path('app/public/' . $filename), $filename);
    }

    public function salesStatus(Request $request)
    {
        $pageTitle = 'Sales Statutes';
        $perPage    = $request->get('per_page', 25);
        $salesStatuses = SalesStatus::paginate($perPage);

        return view('admin.users.sales_status.index', compact('pageTitle', 'salesStatuses', 'perPage'));
    }

    public function salesStatusCreateView()
    {
        $pageTitle = 'Create Sales Status';

        return view('admin.users.sales_status.create', compact('pageTitle'));
    }

    public function salesStatusStore(SalesStatusStoreRequest $request)
    {
        DB::transaction(
            function () use ($request) {
                SalesStatus::create($request->validated());
            }
        );

        return returnBack('Sales status created successfully!', 'success');
    }

    public function salesStatusDelete(SalesStatus $status)
    {
        DB::transaction(
            function () use ($status) {
                $status->delete();
            }
        );

        return returnBack('Sales status deleted successfully', 'success');
    }

    public function bulkRecordUpdate(Request $request)
    {
        // Retrieve the validated data
        $data = $request->only('owner_id', 'sales_status', 'account_type', 'selected_ids', 'hide_comments');

        // Prepare the update data
        $updateData = [];
        if ($data['owner_id'] !== null) {
            $updateData['owner_id'] = $data['owner_id'];
        }
        if ($data['sales_status'] !== null) {
            $updateData['sales_status'] = $data['sales_status'];
        }
        if ($data['account_type'] !== null) {
            $updateData['account_type'] = $data['account_type'];
        }
        if ($request->has('hide_comments') && $data['hide_comments'] !== null) {
            $updateData['show_commentor_comments'] = $data['hide_comments'];
        }

        // Perform the bulk update
        User::whereIn('id', $data['selected_ids'])->update($updateData);

        return response()->json(['success' => 1, 'message' => 'Successfully updated!'], 200);

        // Return a success response
        // return returnBack('Bulk update finished', 'success');
    }

    public function bulkRecordDelete(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->validate([
                'ids' => ['required']
            ]);

            $result = User::whereIn('id', $data['ids'])->delete();

            if ($result) {
                return response()->json(['message' => 'Bulk delete finished'], 200);
            }

            return response()->json(['message' => 'Bulk delete failed'], 500);
        }


        abort(403, 'Unauthorized');
    }

    public function onlineLeads(Request $request)
    {
        $perPage = 25;

        $pageTitle = "Online Leads";

        $users = $this->userData('id', 'desc', $scope = null, $startDate = null, $endDate = null, 1)->paginate($perPage);

        return view('admin.reports.all_leads.index', compact('users', 'perPage', 'pageTitle'));
    }

    public function bulkRecordExport(Request $request)
    {

        if ($request->ajax()) {

            $data = $request->validate([
                'ids' => ['required']
            ]);

            try {
                $users = User::whereIn('id', $data['ids'])->get();

                $fileName = 'users_' . now()->format('Y_m_d_H_i_s') . '.csv'; // Dynamic file name

                $filePath = storage_path("app/public/{$fileName}");

                $writer = SimpleExcelWriter::create($filePath, 'csv');

                $users->each(function ($user) use ($writer) {
                    $writer->addRow([
                        'ID'            => $user->lead_code,
                        'Type'          => $user->account_type,
                        'First Name'    => $user->firstname,
                        'last Name'     => $user->lastname,
                        'Email'         => $user->email,
                        'Mobile'        => $user->mobile,
                        'Country'       => $user->country_code,
                        'Registered'    => $user->created_at->format('Y-m-d H:i:s'),
                        'lead_source'   => $user->lead_source
                    ]);
                });

                return response()->download($filePath)->deleteFileAfterSend();
            } catch (Exception $e) {
                return response()->json(['message' => 'Bulk export failed'], 500);
            }
        }

        abort(403, 'Unauthorized');
    }

    public function fetchHistory(Request $request)
    {

        if ($request->ajax()) {

            $data = $request->validate([
                'id' => ['required']
            ]);

            try {
                $data = UserDetailsHistory::with('updatedBy')->where('user_id', $request->id)->orderByDesc('id')->get();

                $html = view('admin.users.modal_blade.user-details-history', compact('data'))->render();

                return response()->json(['success' => 1, 'html' => $html], 200);
            } catch (Exception $e) {
                dd($e->getMessage());
                return response()->json(['message' => 'Failed'], 500);
            }
        }

        abort(403, 'Unauthorized');
    }
}
