<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGroups extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function groupUsers() {
        return $this->hasMany(ClientGroupUser::class, 'client_group_id');
    }
    
    

    public function settings() {
        return $this->hasMany(ClientGroupSetting::class, 'client_group_id');
    }

}
