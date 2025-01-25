<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositPayment extends Model
{
    public $table = "deposit_payment";

    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'deposit_id');
    }
}
