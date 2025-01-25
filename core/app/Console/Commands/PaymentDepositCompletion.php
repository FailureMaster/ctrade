<?php

namespace App\Console\Commands;

use App\Constants\Status;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\Deposit;
use App\Models\DepositPayment;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PaymentDepositCompletion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:paymentdepositcompletion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for accepting and rejecting pending payment deposit by payment369';

    /**
     * The name of the payment service.
     *
     * @var string
     */
    protected $paymentService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pendingPaymentDeposits = DepositPayment::with('deposit')->where('status', 'pending')->where('is_complete', 0)->limit(5)->get();

        if( $pendingPaymentDeposits->count() > 0 ){
            
            $paymentService = new PaymentService();

            foreach( $pendingPaymentDeposits as $pd ){

                $requestFields = [
                    'login'            => 'Allsumou_Pay369',
                    'client_orderid'   => $pd->deposit->user_id,
                    'orderid'          => $pd->payment_order_id,
                ];

                $requestFields['control'] = $paymentService->signStatusRequest($requestFields);

                // Send the request
                $url = $paymentService->getStatusUrl();

                $responseFields = $paymentService->sendRequest($url, $requestFields);

                if( isset($responseFields['type']) && trim($responseFields['type']) == "status-response" ){

                    if( trim(strtolower($responseFields['status'])) == "declined" || trim(strtolower($responseFields['status'])) == "failed" || trim(strtolower($responseFields['status'])) == "error" )
                    {
                        $pd->deposit->admin_feedback = "Payment failed on the gateway, automatically Rejected by the system.";
                        $pd->deposit->status = Status::PAYMENT_REJECT;
                    }
                    else if( trim(strtolower($responseFields['status'])) == "approved" ){
                        PaymentController::userDataUpdate($pd->deposit, true);
                        $pd->deposit->admin_feedback = "Payment success on the gateway, automatically Accepted by the system.";
                    }

                    if( $pd->deposit->save() ){
                        $pd->status = trim(strtolower($responseFields['status']));
                        $pd->is_complete = 1;
                        $pd->save();
                    }
                }
                else{
                    var_dump('Failed fetching payment details '. json_encode($responseFields));
                }
            }

            var_dump('Done checking payment deposit pending today  '. Carbon::now());
        }

        var_dump('No available cron today  '. Carbon::now());
    }
}
