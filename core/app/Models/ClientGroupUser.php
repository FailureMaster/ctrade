<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGroupUser extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function group(){
        return $this->hasOne(ClientGroups::class, 'id', 'client_group_id');
    }
}
