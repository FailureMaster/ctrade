<?php

namespace App\Models;

use App\Scopes\ExcludeUserScope;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ExcludeUserScope('admin_notifications.user_id'));
    }
}
