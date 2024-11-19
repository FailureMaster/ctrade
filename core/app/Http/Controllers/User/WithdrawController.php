<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Currency;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class WithdrawController extends Controller
{

    public function withdrawStore(Request $request)
    {
        $walletTypes = gs('wallet_types');

        $request->validate([
            'method_code' => 'required',
            'amount'      => 'required|numeric|gt:0',
            'currency'    => 'required',
            'wallet_type' => 'required|in:' . implode(',', array_keys((array) $walletTypes)),
        ]);

        $currency = Currency::active()->where('symbol', $request->currency)->first();

        if (!$currency) {
            return returnBack('Requested withdraw currency not found');
        }

        $walletType = $request->wallet_type;

        if (!checkWalletConfiguration($walletType, 'withdraw', $walletTypes)) {
            return returnBack("Withdraw from $walletType wallet currently disabled.");
        }
        
        $user   = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->where('currency_id', $currency->id)->$walletType()->first();
        
        if (!$wallet) {
            return returnBack('Requested withdraw currency wallet not found');
        }
        
        $method   = WithdrawMethod::where('id', $request->method_code)->where('currency', $currency->symbol)->where('status', Status::ENABLE)->first();
        
        if (!$method) {
            return returnBack('Requested withdraw method not found');
        }
        
        if ($request->amount < $method->min_limit) {
            return returnBack('Your requested amount is smaller than minimum amount.');
        }
        if ($request->amount > $method->max_limit) {
            return returnBack('Your requested amount is larger than maximum amount.');
        }
        
        if ($request->amount > $wallet->balance) {
            return returnBack('You do not have sufficient wallet balance for withdraw.');
        }


        $charge      = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge;

        $withdraw               = new Withdrawal();
        $withdraw->method_id    = $method->id;
        $withdraw->user_id      = $user->id;
        $withdraw->amount       = $request->amount;
        $withdraw->currency     = $method->currency;
        $withdraw->rate         = $method->rate;
        $withdraw->charge       = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx          = getTrx();
        $withdraw->wallet_id    = $wallet->id;
        $withdraw->save();

        session()->put('wtrx', $withdraw->trx);
        return to_route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw  = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle', 'withdraw'));
    }

    public function withdrawSubmit(Request $request)
    {

        $withdraw = Withdrawal::with('method', 'user', 'wallet')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();
        $method   = $withdraw->method;
        $wallet   = $withdraw->wallet;

        if ($method->status == Status::DISABLE) {
            abort(404);
        }

        $formData       = $method->form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $user = auth()->user();

        // if ($user->ts) {
        //     $response = verifyG2fa($user, $request->authenticator_code);
        //     if (!$response) {
        //         $notify[] = ['error', 'Wrong verification code'];
        //         return back()->withNotify($notify);
        //     }
        // }

        if ($withdraw->amount > $wallet->balance) {
            $notify[] = ['error', 'You do not have sufficient wallet balance for withdraw.'];
            return back()->withNotify($notify)->withInput();
        }

        $withdraw->status               = Status::PAYMENT_PENDING;
        $withdraw->withdraw_information = $userData;
        $withdraw->save();

        $wallet->balance -= $withdraw->amount;
        $wallet->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $withdraw->user_id;
        $transaction->amount       = $withdraw->amount;
        $transaction->post_balance = $wallet->balance;
        $transaction->charge       = $withdraw->charge;
        $transaction->trx_type     = '-';
        $transaction->details      = showAmount($withdraw->amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx          = $withdraw->trx;
        $transaction->remark       = 'withdraw';
        $transaction->wallet_id    = $wallet->id;
        $transaction->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();


        notify($user, 'WITHDRAW_REQUEST', [
            'method_name'     => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount'   => showAmount($withdraw->final_amount),
            'amount'          => showAmount($withdraw->amount),
            'charge'          => showAmount($withdraw->charge),
            'rate'            => showAmount($withdraw->rate),
            'trx'             => $withdraw->trx,
            'post_balance'    => showAmount($user->balance),
            'wallet_name'     => $wallet->name
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return to_route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog(Request $request)
    {
        $pageTitle = "Withdraw Logs";

         // Newly added
         $filter = $request->get('filter');

         if ($request->get('customfilter')) {
             $filter = 'custom';
         }

        $withdraws = Withdrawal::searchable(['trx', 'withdrawCurrency:symbol'])->where('user_id', auth()->id())->where('status', '!=', Status::PAYMENT_INITIATE)->with('method', 'wallet.currency')->orderBy('id', 'desc');

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

        $method_ids = ( clone $withdraws )->select('method_id')->get()->pluck('method_id')->toArray();

        $methods = WithdrawMethod::whereIn('id', $method_ids)->get();

        
        if ($startDate && $endDate) {
            $withdraws->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Dont uncomment
        // Gateway filter
        if ($request->has('gateway') && $request->gateway <> "") {
            $withdraws->where('method_id', $request->gateway);
        }

        // Status filter
        if ($request->has('status') && $request->status <> "") {
            $withdraws->where('status', $request->status);
        }

        $withdrawsData = ( clone $withdraws)->get();

        $withdraws = $withdraws->paginate(getPaginate());

       
        return view($this->activeTemplate . 'user.withdraw.log', compact('pageTitle', 'withdraws', 'methods', 'withdrawsData'));
    }

    public function newWithdrawStore(Request $request)
    {

        if( $request->ajax() ){

            $walletTypes = gs('wallet_types');

            $request->validate([
                'method_code' => 'required',
                'amount'      => 'required|numeric|gt:0',
                'currency'    => 'required',
                'wallet_type' => 'required|in:' . implode(',', array_keys((array) $walletTypes)),
            ]);

            $currency = Currency::active()->where('symbol', $request->currency)->first();

            if (!$currency) {
                return returnBack('Requested withdraw currency not found');
            }

            $walletType = $request->wallet_type;

            if (!checkWalletConfiguration($walletType, 'withdraw', $walletTypes)) {
                return response()->json(['success' => 0, 'message' => "Withdraw from $walletType wallet currently disabled."],200);
            }
            
            $user   = auth()->user();
            $wallet = Wallet::where('user_id', $user->id)->where('currency_id', $currency->id)->$walletType()->first();
            
            if (!$wallet) {
                return response()->json(['success' => 0, 'message' => "Requested withdraw currency wallet not found."],200);
            }
            
            $method   = WithdrawMethod::where('id', $request->method_code)->where('currency', $currency->symbol)->where('status', Status::ENABLE)->first();
            
            if (!$method) {
                return response()->json(['success' => 0, 'message' => "Requested withdraw method not found."],200);
            }
            
            if ($request->amount < $method->min_limit) {
                return response()->json(['success' => 0, 'message' => "Your requested amount is smaller than minimum amount."],200);
            }
            if ($request->amount > $method->max_limit) {
                return response()->json(['success' => 0, 'message' => "Your requested amount is larger than maximum amount."],200);
            }
            
            if ($request->amount > $wallet->balance) {
                return response()->json(['success' => 0, 'message' => "You do not have sufficient wallet balance for withdraw."],200);
            }


            $charge      = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
            $afterCharge = $request->amount - $charge;
            $finalAmount = $afterCharge;

            $withdraw               = new Withdrawal();
            $withdraw->method_id    = $method->id;
            $withdraw->user_id      = $user->id;
            $withdraw->amount       = $request->amount;
            $withdraw->currency     = $method->currency;
            $withdraw->rate         = $method->rate;
            $withdraw->charge       = $charge;
            $withdraw->final_amount = $finalAmount;
            $withdraw->after_charge = $afterCharge;
            $withdraw->trx          = getTrx();
            $withdraw->wallet_id    = $wallet->id;

            if(  $withdraw->save() ) {
                $data = $withdraw->fresh();
                $trx  = Crypt::encrypt($data->trx);

                $withdraw  = Withdrawal::with('method', 'user')->where('trx', $data->trx)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();

                $html = view('components.withdraw-confirm', compact('trx', 'withdraw'))->render();

                return response()->json(['success' => 1 , 'html' => $html ], 200);
            }

            return response()->json(['message' => 'Failed!'], 500);
        }
        
        return abort(403, 'Unauthorized!');
    }

    public function newWithdrawSubmit(Request $request)
    {
        if( $request->ajax() ){
            try{
                $trx = Crypt::decrypt($request->trx);

                $withdraw = Withdrawal::with('method', 'user', 'wallet')->where('trx', $trx)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();
                $method   = $withdraw->method;
                $wallet   = $withdraw->wallet;

                if ($method->status == Status::DISABLE) {
                    abort(404);
                }

                $formData       = $method->form->form_data;
                $formProcessor  = new FormProcessor();
                $validationRule = $formProcessor->valueValidation($formData);
                $request->validate($validationRule);
                $userData = $formProcessor->processFormData($request, $formData);

                $user = auth()->user();

                if ($withdraw->amount > $wallet->balance) {
                    return response()->json(['success' => 0, 'message' => "You do not have sufficient wallet balance for withdraw."],200);
                }

                $withdraw->status               = Status::PAYMENT_PENDING;
                $withdraw->withdraw_information = $userData;
                $withdraw->save();

                $wallet->balance -= $withdraw->amount;
                $wallet->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $withdraw->user_id;
                $transaction->amount       = $withdraw->amount;
                $transaction->post_balance = $wallet->balance;
                $transaction->charge       = $withdraw->charge;
                $transaction->trx_type     = '-';
                $transaction->details      = showAmount($withdraw->amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
                $transaction->trx          = $withdraw->trx;
                $transaction->remark       = 'withdraw';
                $transaction->wallet_id    = $wallet->id;
                $transaction->save();

                $adminNotification            = new AdminNotification();
                $adminNotification->user_id   = $user->id;
                $adminNotification->title     = 'New withdraw request from ' . $user->username;
                $adminNotification->click_url = urlPath('admin.withdraw.details', $withdraw->id);
                
                if( $adminNotification->save() )
                    return response()->json(['success' => 1 , 'message' => 'Withdraw request sent successfully' ], 200);

                return response()->json(['success' => 0 , 'message' => 'Failed!' ], 200);
            }
            catch( Exception $e ){
                return response()->json(['success' => 0 , 'message' => 'Failed!' ], 200);
            }
            
        }

        return abort(403, 'Unauthorized!');
    }
}
