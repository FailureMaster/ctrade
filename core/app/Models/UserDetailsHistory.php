<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetailsHistory extends Model
{
    public $table = 'user_details_history';

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
