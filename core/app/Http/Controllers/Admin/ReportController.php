<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ReportController extends Controller
{
    public function transaction(Request $request)
    {
        $pageTitle    = 'Transaction Logs';
        $remarks      = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $perPage = $request->get('per_page', 25);
        $excludeOderType = ['order_sell', 'order_buy'];
        $transactions = Transaction::with([
            'wallet.currency',
            'user'
        ])
        ->whereHas('user')
        // ->whereNull('hid_at')
        ->whereNotIn('remark', $excludeOderType)
        ->when($request->get('lead_code'), function ($query) use ($request) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('lead_code', $request->lead_code);
            });
        })
        ->when(request()->get('name'), function ($query) use ($request) {
            $names = explode(' ', $request->get('name'));
            $query->whereHas('user', function ($query) use ($names) {
                foreach ($names as $name) {
                    $query->where(function ($query) use ($name) {
                        $query->where('firstname', 'LIKE', "%{$name}%")
                              ->orWhere('lastname', 'LIKE', "%{$name}%");
                    });
                }
            });
        })
        ->searchable(['trx', 'user:username', 'user:email'])
        ->filter([
            'user:email',
            'user:mobile',
            'trx_type',
            'trx',
            'remark',
            'wallet.currency:symbol',
        ])
        // ->dateFilter()
        ->dateFilterNew()
        ->orderBy('id', 'desc')
        ->with('user');

        $transactions = (clone $transactions)->paginate($perPage);

        $currencies   = Currency::active()->rankOrdering()->get();

        $totalTransactions = new stdClass();

        $totalTransactions->deposits = Deposit::with(['user', 'gateway', 'currency','wallet.currency'])
                            ->whereHas('user')
                            ->join('currencies', 'deposits.currency_id', 'currencies.id')
                            ->where('deposits.status', Status::PAYMENT_SUCCESS)
                            ->dateFilterNew()
                            ->sum(DB::raw('currencies.rate * deposits.amount'));

        $totalTransactions->withdraws =  Withdrawal::with(['user','method'])
                        ->whereIn('withdrawals.status',[Status::PAYMENT_SUCCESS,Status::PAYMENT_PENDING])
                        ->join('currencies', 'withdrawals.currency', 'currencies.symbol')
                        ->whereHas('user')
                        ->dateFilterNew()
                        ->sum(DB::raw('currencies.rate * withdrawals.amount'));

        $totalTransactions->balance = Transaction::whereHas('user')
                                        ->where('remark', 'balance_add')
                                        ->dateFilterNew()
                                        ->sum('amount');

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks', 'currencies', 'perPage', 'totalTransactions'));
    }

    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';

        $perPage = $request->get('per_page', 25);

        $loginLogs = UserLogin::with('user');

        if ($request->filled('ip')) {
            $loginLogs = $loginLogs->where('user_ip', $request->get('ip'));
        }

        if ($request->filled('browser')) {
            $loginLogs = $loginLogs->where('browser', $request->get('browser'));
        }

        if ($request->filled('lead_code')) {
            $loginLogs = $loginLogs->whereHas('user', function ($query) use ($request) {
                $query->where('lead_code', $request->get('lead_code'));
            });
        }

        if ($request->filled('user_name')) {
            $userName = $request->get('user_name');
            $loginLogs = $loginLogs->whereHas('user', function ($query) use ($userName) {
                $query->where('firstname', 'LIKE', "%$userName%");
                $query->orWhere('lastname', 'LIKE', "%$userName%");
            });
        }else{
            $loginLogs = $loginLogs->whereHas('user');
        }

        $loginLogs = $loginLogs->orderBy('id', 'desc')->paginate($perPage);
    
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs', 'perPage'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs', 'ip'));
    }

    public function notificationHistory(Request $request)
    {
        $pageTitle = 'Notification History';
        $logs      = NotificationLog::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email     = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }
    
    public function hideTransaction(Transaction $transaction)
    {
        DB::transaction(
            function () use ($transaction) {
                $transaction->hid_at = now();
                $transaction->save();
            }
        );

        return returnBack('Transaction hide successfully', 'success');
    }
}
