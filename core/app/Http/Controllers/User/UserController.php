<?php

namespace App\Http\Controllers\User;

use App\Constants\Defaults;
use App\Constants\Status;
use App\Models\Form;
use App\Models\Wallet;
use App\Models\CoinPair;
use App\Models\Currency;
use App\Models\User;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\FavoritePair;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\Order;
use App\Models\Referral;
use App\Models\SupportTicket;
use App\Models\Trade;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function home()
    {

        $pageTitle = 'My Dashboard';
        $user      = auth()->user();

        $pairs = CoinPair::whereHas('marketData')
            ->select('id', 'market_id', 'coin_id')
            ->with('market:id,name,currency_id', 'coin:id,name,symbol', 'market.currency:id,name,symbol', 'marketData:id,pair_id,price,percent_change_1h,percent_change_24h,html_classes,market_cap')
            ->get();

        $wallets    = $this->wallet();
        $currencies = Currency::rankOrdering()->select('name', 'id', 'symbol');

        $order                     = Order::where('user_id', $user->id);

        $closed_orders             = $order->where('status', Status::ORDER_CANCELED)->get();

        $widget['open_order']      = Order::where('user_id', $user->id)->where('status', Status::ORDER_OPEN)->count();
        $widget['completed_order'] = (clone $order)->completed()->count();
        // $widget['canceled_order']  = (clone $order)->canceled()->count();
        $widget['total_trade']     = Trade::where('trader_id', $user->id)->count();

        $pl                        = 0;

        foreach($closed_orders as $co ){
            $pl = ( $pl + $co->profit );
        }

        $widget['pl'] = $pl;
        $widget['closed_orders']  = $closed_orders->count();
        $widget['total_deposit']  = Deposit::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_withdraw'] = Withdrawal::where('user_id', $user->id)->approved()->sum('amount');
        $widget['open_tickets']   = SupportTicket::where('user_id', $user->id)->where('status', Status::TICKET_OPEN)->count();

        $recentOrders       = $order->with('pair.coin')->orderBy('id', 'DESC')->get();
        $recentTransactions = Transaction::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        $estimatedBalance   = Wallet::where([
            'user_id' => $user->id,
            'currency_id' => Defaults::DEF_WALLET_CURRENCY_ID
        ])->join('currencies', 'wallets.currency_id', 'currencies.id')->spot()->sum(DB::raw('currencies.rate * wallets.balance'));

        $gateways = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method:id,code,crypto')->get();
        $withdrawMethods = WithdrawMethod::active()->get();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'user', 'pairs', 'wallets', 'currencies', 'widget', 'recentOrders', 'recentTransactions', 'estimatedBalance', 'gateways', 'withdrawMethods'));
    }
    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit Logs';

        $deposits  = auth()->user()->deposits()->searchable(['trx', 'currency:symbol'])->with(['gateway', 'wallet.currency'])->orderBy('id', 'desc');
        // Newly added
        $filter = $request->get('filter');

        if ($request->get('customfilter')) {
            $filter = 'custom';
        }

        $method_code_ids = (clone $deposits)->get()->pluck('method_code')->unique()->toArray();
        
        $gateway = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })
        ->whereIn('method_code', $method_code_ids)
        ->select('method_code', 'name')
        ->get();


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

        if ($startDate && $endDate) {
            $deposits->whereBetween('deposits.created_at', [$startDate, $endDate]);
        }

        if ($request->has('gateway') && $request->gateway <> "") {
            $deposits->where('deposits.method_code', $request->gateway);
        }

        if ($request->has('status') && $request->status <> "") {
            $deposits->where('deposits.status', $request->status);
        }

        $depositsData = ( clone $deposits)->get();

        $deposits = $deposits->paginate(getPaginate());

        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits', 'gateway', 'depositsData'));
    }

    public function show2faForm()
    {
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = 'Security';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts  = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user     = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle    = 'Transactions Logs';

        $excludedRemarks = [
            'balance_subtract',
            'charge_order_buy',
            'order_canceled',
            'trade_buy',
            'trade_sell',
            'transfer'
        ];
        
        $remarks = Transaction::distinct('remark')
            ->whereNotIn('remark', $excludedRemarks)
            ->orderBy('remark')
            ->get('remark');
        $replacevalue = ['wallet_type' => ['spot' => Status::WALLET_TYPE_SPOT, 'funding' => Status::WALLET_TYPE_FUNDING]];
   
        $currencies   = Currency::active()->rankOrdering()->get();

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

        $transactions = Order::with('pair')->where('user_id', auth()->id())
            ->where('status', Status::ORDER_CANCELED)
            ->orderBy('updated_at', 'desc');

        if ($startDate && $endDate) {
            $transactions->whereBetween('updated_at', [$startDate, $endDate]);
        }

        if ( $request->has('symbol') && $request->symbol <> "" ) {
            $transactions->where('pair_id', $request->symbol);
        }

        if ( $request->has('trx_type') && $request->trx_type <> "" ) {
            $transactions->where('order_side', $request->trx_type);
        }

        $transactions = $transactions->searchable(['id']);

        $closed_orders             = ( clone $transactions )->get();
        
        $pl                        = 0;
        $total_profit              = 0;
        $total_loss                = 0;

        foreach($closed_orders as $co ){

            if( $co->profit > 1 )  $total_profit =  $total_profit + $co->profit;
            if( $co->profit < 1 )  $total_loss =  $total_loss + $co->profit;

            $pl = ( $pl + $co->profit );
        }

        $currency = CoinPair::whereIn('id', $closed_orders->pluck('pair_id')->unique()->toArray())->select('id', 'symbol')->get();

        $transactions = $transactions->paginate(getPaginate());

        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks', 'currencies', 'pl', 'closed_orders', 'total_profit', 'total_loss', 'currency'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form      = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user      = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form           = Form::where('act', 'kyc')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData       = $formProcessor->processFormData($request, $formData);
        $user           = auth()->user();
        $user->kyc_data = $userData;
        $user->kv       = 2;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash)
    {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general   = gs();
        $title     = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype  = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        return to_route('user.home');

        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }

        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->address   = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];
        $user->profile_complete = Status::YES;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function wallet($skip = 0)
    {

        $wallets = Wallet::where('user_id', auth()->id())
            ->skip($skip)
            ->spot()
            ->take(3)
            ->with('currency:id,name,symbol,image')
            ->select('id', 'balance', 'currency_id')
            ->orderBy('balance', 'desc')
            ->get();

        if (!request()->ajax()) return  $wallets;

        return  response()->json([
            'success' => true,
            'wallets' => $wallets
        ]);
    }

    public function addToFavorite($symbol)
    {
        $pair = CoinPair::activeMarket()->activeCoin()->where('symbol', $symbol)->first();
        if (!$pair) {
            return response()->json([
                'success' => false,
                'message' => "Pair not found"
            ]);
        }
        $favoritePair = FavoritePair::where('user_id', auth()->id())->where('pair_id', $pair->id)->first();

        if ($favoritePair) {
            $favoritePair->delete();
            return response()->json([
                'success' => true,
                'deleted' => true,
                'message' => "This pair removed to your favorite list"
            ]);
        }

        $favoritePair          = new FavoritePair();
        $favoritePair->user_id = auth()->id();
        $favoritePair->pair_id = $pair->id;
        $favoritePair->save();

        return response()->json([
            'success' => true,
            'message' => "Pair added to favorite list"
        ]);
    }

    public function referrals()
    {
        $pageTitle = 'My Referrals';
        $user      = auth()->user();
        $maxLevel  = Referral::max('level');
        return view($this->activeTemplate . 'user.referrals', compact('pageTitle', 'user', 'maxLevel'));
    }

    public function allCurrency()
    {
        $query = Currency::active();

        if (request()->type == Status::CRYPTO_CURRENCY) $query->where('type', Status::CRYPTO_CURRENCY)->rankOrdering();
        if (request()->type == Status::FIAT_CURRENCY) $query->where('type', Status::FIAT_CURRENCY)->orderBy('id', 'desc');
        if (request()->search) $query->where(function ($q) {
            $q->where('name', 'like', '%' . request()->search . '%')->orWhere('symbol', 'like', '%' . request()->search . '%');
        });
        
        $query->where('symbol', 'USD');

        $currencies = $query->paginate(getPaginate());

        return response()->json([
            'success'    => true,
            'currencies' => $currencies,
            'more'       => $currencies->hasMorePages()
        ]);
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
}
