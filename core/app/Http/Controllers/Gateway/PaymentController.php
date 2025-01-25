<?php

namespace App\Http\Controllers\Gateway;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\DepositPayment;
use App\Models\GatewayCurrency;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\PaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function depositInsert(Request $request)
    {
        $walletTypes = gs('wallet_types');

        $request->validate([
            'amount'      => 'required|numeric|gt:0',
            'gateway'     => 'required',
            'currency'    => 'required',
            'wallet_type' => 'required|in:' . implode(',', array_keys((array) $walletTypes)),
        ]);

        $currency   = Currency::active()->where('symbol', $request->currency)->first();

        if (!$currency) {
            return returnBack("The requested deposit currency not found.");
        }

        $walletType = $request->wallet_type;

        if (!checkWalletConfiguration($walletType, 'deposit', $walletTypes)) {
            return returnBack("Deposit to $walletType wallet currently disabled.");
        }

        $gate = GatewayCurrency::where('currency', $currency->symbol)->whereHas('method', function ($gate) {
            $gate->active();
        })->where('method_code', $request->gateway)->first();

        if (!$gate) {
            return returnBack("Invalid gateway");
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            return returnBack("Please follow deposit limit");
        }

        $charge    = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable   = $request->amount + $charge;
        $final_amo = $payable;
        $user      = auth()->user();
        $wallet    = Wallet::where('currency_id', $currency->id)->where('user_id', $user->id)->$walletType()->first();

        if (!$wallet) {
            $wallet              = new Wallet();
            $wallet->user_id     = $user->id;
            $wallet->currency_id = $currency->id;
            $wallet->wallet_type = $walletTypes->$walletType->type_value;
            $wallet->save();
        }

        $data                  = new Deposit();
        $data->wallet_id       = $wallet->id;
        $data->currency_id     = $wallet->currency_id;
        $data->user_id         = $user->id;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $request->amount;
        $data->charge          = $charge;
        $data->rate            = 1;
        $data->final_amo       = $final_amo;
        $data->btc_amo         = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->status          = Status::PAYMENT_PENDING;
        $data->save();

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }



    public function depositConfirm()
    {
        $track   = session()->get('Track');
        // $deposit = Deposit::where('trx', $track)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();
        $deposit =  Deposit::with('gateway')->where('trx', $track)->where(function($query){
            $query->where('status', Status::PAYMENT_INITIATE);
            $query->orWhere('status', Status::PAYMENT_PENDING);
        })
        ->orderBy('id', 'DESC')->with('gateway')
        ->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }

        $dirName = $deposit->gateway->alias;
        $new     = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';
        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {

        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {

            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            $wallet           = Wallet::find($deposit->wallet_id);
            $wallet->balance += $deposit->amount;
            $wallet->save();

            $user   = User::find($deposit->user_id);

            $transaction               = new Transaction();
            $transaction->user_id      = $deposit->user_id;
            $transaction->wallet_id    = $wallet->id;
            $transaction->amount       = $deposit->amount;
            $transaction->post_balance = $wallet->balance;
            $transaction->charge       = $deposit->charge;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
            $transaction->trx          = $deposit->trx;
            $transaction->remark       = 'deposit';
            $transaction->save();

            if (!$isManual) {
                $adminNotification            = new AdminNotification();
                $adminNotification->user_id   = $user->id;
                $adminNotification->title     = 'Deposit successful via ' . $deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name'     => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount'   => showAmount($deposit->final_amo),
                'amount'          => showAmount($deposit->amount),
                'charge'          => showAmount($deposit->charge),
                'rate'            => showAmount($deposit->rate),
                'trx'             => $deposit->trx,
                'post_balance'    => showAmount($wallet->balance),
                'wallet_name'     => @$wallet->currency->symbol
            ]);


            if (gs('deposit_commission')) {
                levelCommission($user, $deposit->amount, 'deposit_commission', $deposit->trx, $deposit->currency_id);
            }
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        // $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();

        $data =  Deposit::with('gateway')->where('trx', $track)->where(function($query){
            $query->where('status', Status::PAYMENT_INITIATE);
            $query->orWhere('status', Status::PAYMENT_PENDING);
        })
        ->first();

        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {
            $pageTitle = 'Deposit Confirm';
            $method    = $data->gatewayCurrency();
            $gateway   = $method->method;

            if( $data->gateway->alias === "payment369" ){
                $user = auth()->user();
                $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
                return view($this->activeTemplate . 'user.payment.payment_369', compact('data', 'pageTitle', 'method', 'gateway', 'countries', 'user', 'track'));
            }

            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        // $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();

        $data =  Deposit::with('gateway')->where('trx', $track)->where(function($query){
            $query->where('status', Status::PAYMENT_INITIATE);
            $query->orWhere('status', Status::PAYMENT_PENDING);
        })
        ->first();

        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }

        $gatewayCurrency = $data->gatewayCurrency();
        $gateway         = $gatewayCurrency->method;
        $formData        = $gateway->form->form_data;

        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = Status::PAYMENT_PENDING;
        $data->save();

        $walletName = @$data->wallet->currency->symbol;

        $filteredAmount = showAmount($data->amount);
        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $data->user->id;
        $adminNotification->title     = 'Deposit request from ' . $data->user->username . " to wallet name " . $walletName. " (Amount: $filteredAmount $data->method_currency)";
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name'     => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amo),
            'amount'          => showAmount($data->amount),
            'charge'          => showAmount($data->charge),
            'rate'            => showAmount($data->rate),
            'trx'             => $data->trx,
            'wallet_name'     => $walletName
        ]);

        $language = __('You have deposit request has been taken');

        $notify[] = ['success', $language];
        return to_route('user.deposit.history')->withNotify($notify);
    }

    public function newDepositInsert(Request $request)
    {
        if( $request->ajax() ){

            $walletTypes = gs('wallet_types');
        
            $request->validate([
                'amount'      => 'required|numeric|gt:0',
                'gateway'     => 'required',
                'currency'    => 'required',
                'wallet_type' => 'required|in:' . implode(',', array_keys((array) $walletTypes)),
            ]);

            $currency   = Currency::active()->where('symbol', $request->currency)->first();

            if (!$currency) {
                return response()->json(['success' => 0, 'message' => 'The requested deposit currency not found' ], 200);
            }

            $walletType = $request->wallet_type;

            if (!checkWalletConfiguration($walletType, 'deposit', $walletTypes)) {
                return response()->json(['success' => 0, 'message' => "Deposit to $walletType wallet currently disabled." ], 200);
            }

            $gate = GatewayCurrency::where('currency', $currency->symbol)->whereHas('method', function ($gate) {
                $gate->active();
            })->where('method_code', $request->gateway)->first();

            if (!$gate) {
                return response()->json(['success' => 0, 'message' => "Invalid gateway" ], 200);
            }

            if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
                return response()->json(['success' => 0, 'message' => "Please follow deposit limit" ], 200);
            }

            $charge    = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
            $payable   = $request->amount + $charge;
            $final_amo = $payable;
            $user      = auth()->user();
            $wallet    = Wallet::where('currency_id', $currency->id)->where('user_id', $user->id)->$walletType()->first();

            if (!$wallet) {
                $wallet              = new Wallet();
                $wallet->user_id     = $user->id;
                $wallet->currency_id = $currency->id;
                $wallet->wallet_type = $walletTypes->$walletType->type_value;
                $wallet->save();
            }

            $data                  = new Deposit();
            $data->wallet_id       = $wallet->id;
            $data->currency_id     = $wallet->currency_id;
            $data->user_id         = $user->id;
            $data->method_code     = $gate->method_code;
            $data->method_currency = strtoupper($gate->currency);
            $data->amount          = $request->amount;
            $data->charge          = $charge;
            $data->rate            = 1;
            $data->final_amo       = $final_amo;
            $data->btc_amo         = 0;
            $data->btc_wallet      = "";
            $data->trx             = getTrx();
            $data->status          = Status::PAYMENT_PENDING;

            if( $data->save() ) {

                $newDeposit = $data->fresh();

                session()->put('Track', $newDeposit->trx);
                session()->save();
                $trx = Crypt::encrypt($newDeposit->trx);
                
                // $deposit = Deposit::where('trx', $newDeposit->trx)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

                $deposit =  Deposit::with('gateway')->where('trx', $newDeposit->trx)->where(function($query){
                    $query->where('status', Status::PAYMENT_INITIATE);
                    $query->orWhere('status', Status::PAYMENT_PENDING);
                })
                ->firstOrFail();

                if ($deposit->method_code >= 1000) {

                    $method    = $data->gatewayCurrency();

                    $gateway   = $method->method;

                    $data      = $deposit;

                    $html = view('components.deposit-confirm', compact('data', 'gateway', 'method', 'trx'))->render();

                    return response()->json(['success' => 1, 'html' => $html ], 200);
                }
            }
        }

        return abort(403, 'Unauthorized.');
    }

    public function customManualDepositUpdate(Request $request)
    {
        // $track = session()->get('Track');
        $track = Crypt::decrypt($request->trx);
        
        // $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();

        $data =  Deposit::with('gateway')->where('trx', $track)->where(function($query){
            $query->where('status', Status::PAYMENT_INITIATE);
            $query->orWhere('status', Status::PAYMENT_PENDING);
        })
        ->first();
        
        if (!$data) {
            return response()->json(['success' => 0, 'message' => 'Failed! Transaction not found.', 'trx' => $track], 200);
        }

        $gatewayCurrency = $data->gatewayCurrency();
        $gateway         = $gatewayCurrency->method;
        $formData        = $gateway->form->form_data;

        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = Status::PAYMENT_PENDING;
        $data->save();

        $walletName = @$data->wallet->currency->symbol;

        $filteredAmount               = showAmount($data->amount);
        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $data->user->id;
        $adminNotification->title     = 'Deposit request from ' . $data->user->username . " to wallet name " . $walletName. " (Amount: $filteredAmount $data->method_currency)";
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        if( $request->ajax() ){

            $language = __('You have deposit request has been taken');

            return response()->json(['success' => 1, 'message' => $language ], 200);
        }

        return response()->json(['success' => 0, 'message' => 'Failed!' ], 200);
    }

    public function customDepositConfirm( Request $request )
    {
        $request->validate([
            'trx'           => 'required',
            'city'          => 'required',
            'zip_code'      => 'required',
            'address'       => 'required',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required',
            'mobile'        => 'required',
            'cvv2'          => 'required|digits_between:1,4|numeric',
            'expire_month'  => 'required|digits_between:1,2|numeric|max:12',
            'expire_year'   => 'required|digits_between:1,4|numeric',
            'card_printed_name' => 'required',
            'credit_card_number' => 'required|digits_between:16,20|numeric',
        ]);

        DB::beginTransaction();

        try{
            $paymentService = new PaymentService();

            $track = Crypt::decrypt($request->trx);
        
            $data =  Deposit::with('gateway')->where('trx', $track)->where(function($query){
                $query->where('status', Status::PAYMENT_INITIATE);
                $query->orWhere('status', Status::PAYMENT_PENDING);
            })
            ->first();
            $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));

            $user = auth()->user();

            $baseUrl = config('app.url');
            
            if (!$data) {
                $notify[] = ['error', 'Transaction Failed, Contact Administrator for more information.'];
                return back()->withNotify($notify);
            }

            $requestFields = [
                'client_orderid'     => $user->id,
                'order_desc'         => 'Trading Deposit',
                'first_name'         => $request->first_name,
                'last_name'          => $request->last_name,
                // 'ssn'                => $request->ssn,
                'address1'           => $request->address,
                'city'               => $request->city,
                // 'state'              => $request->state,
                'zip_code'           => $request->zip_code,
                'country'            => $request->country,
                'phone'              => "+".$countries->{$request->country}->dial_code.$request->mobile,
                'email'              => $request->email,
                'currency'           => 'USD',
                'ipaddress'          => $user->user_ip,
                'site_url'           => $baseUrl,
                'credit_card_number' => $request->credit_card_number,
                'card_printed_name'  => $request->card_printed_name,
                'expire_month'       => $request->expire_month,
                'expire_year'        => $request->expire_year,
                'cvv2'               => $request->cvv2,
                'amount'             => $data->final_amo,
            ];

            // Sign the request
            $requestFields['control'] = $paymentService->signPaymentRequest($requestFields);

            // Send the request
            $url = $paymentService->getUrl();

            $responseFields = $paymentService->sendRequest($url, $requestFields);

            if( $responseFields && trim($responseFields['type']) == "async-response" ){

                $data->status = Status::PAYMENT_PENDING;
                $data->save();

                $walletName                   = @$data->wallet->currency->symbol;

                $filteredAmount               = showAmount($data->amount);
                $adminNotification            = new AdminNotification();
                $adminNotification->user_id   = $data->user->id;
                $adminNotification->title     = 'Deposit request from ' . $data->user->username . " to wallet name " . $walletName. " (Amount: $filteredAmount $data->method_currency)";
                $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
                $adminNotification->save();

                $depositPayment = new DepositPayment();
                $depositPayment->deposit_id = $data->id;
                $depositPayment->payment_order_id = $responseFields['paynet-order-id'];
                $depositPayment->status     = 'pending';
                $depositPayment->created_at = Carbon::now();
                $depositPayment->save();

                DB::commit();
                $notify[] = ['success', 'You have deposit request has been taken.'];
                return to_route('user.deposit.history')->withNotify($notify);
            }

            Log::info( 'Payment369 Failed - '. json_encode($responseFields) );

            if( $responseFields && trim($responseFields['type']) == "validation-error" )
                $notify[] = ['error', trim($responseFields['error-message'])];
            else
                $notify[] = ['error', 'Transaction Failed, Contact Administrator for more information.'];

            DB::rollBack();
            return back()->withNotify($notify);
        }
        catch( Exception $e ){
            DB::rollBack();
            Log::info( 'Payment369 Failed - '. $e->getMessage() );
            $notify[] = ['error', 'Transaction Failed, Contact Administrator for more information.'];
            return back()->withNotify($notify);
        }
    }
}
