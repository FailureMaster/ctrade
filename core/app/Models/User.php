<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Wallet;
use App\Scopes\ExcludeUserScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, Searchable, UserNotify, SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'ver_code',
        'balance',
        'kyc_data'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'kyc_data' => 'object',
        'ver_code_send_at' => 'datetime'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::created(function (User $user) {
            $user->generateLeadCode();
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new ExcludeUserScope('users.id'));
    }

    public function generateLeadCode()
    {
        do {
            $leadCode = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (User::where('lead_code', $leadCode)->exists());

        $this->lead_code = $leadCode;
        $this->save();
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }
    public function comments()
    {
        // Check if the user is a super admin (id = 1)
        if (Auth::guard('admin')->user()->id == 1 || Auth::guard('admin')->user()->permission_group_id == 1 ) {
            return $this->hasMany(Comment::class);
        }

        // Check the show_commentor_comments column
        if ( $this->show_commentor_comments == 0) {
            // If show_commentor_comments is 0, only allow the user to see their own comments
            return $this->hasMany(Comment::class)
                        ->where('commented_by', Auth::guard('admin')->user()->id); // Assuming 'comment_by' is the user who made the comment
        }

        // If show_commentor_comments is 1, return all comments
        return $this->hasMany(Comment::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function custom_wallets()
    {
        return $this->hasOne(Wallet::class)->where('currency_id', 4)
        ->where('wallet_type', 1);
    }

    public function openOrders()
    {
        return $this->hasMany(Order::class)->where('status', Status::ORDER_OPEN);
        
    }

    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }
    public function owner()
    {
        return $this->belongsTo(Admin::class, 'owner_id', 'id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }
    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn(mixed $value, array $attributes) => $attributes['firstname'] . ' ' . $attributes['lastname'],
        );
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'ref_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_by');
    }

    public function activeReferrals()
    {
        return $this->hasMany(User::class, 'ref_by');
    }

    public function allReferrals()
    {
        return $this->referrals()->with('referrer');
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)
            ->where('account_type', 'real');
        
        // ->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED)
    }

    public function scopeInactive($query)
    {
        return $query->where('status', '!=', Status::USER_ACTIVE)
            ->orWhere('account_type', '!=', 'real');

            // ->orWhere('ev', '!=', Status::VERIFIED)
            // ->orWhere('sv', '!=', Status::VERIFIED)
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending($query)
    {
        return $query->where('kv', Status::KYC_PENDING);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function userGroups()
    {
        return $this->hasOne(ClientGroupUser::class, 'user_id');
    }

    public function approvedWithdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', Status::PAYMENT_SUCCESS);
    }

    public function approvedDeposits()
    {
        return $this->hasMany(Deposit::class)->where('status', Status::PAYMENT_SUCCESS);
    }

    public function userDetailHistory()
    {
        return $this->hasMany(UserDetailsHistory::class, 'user_id');
    }
}
