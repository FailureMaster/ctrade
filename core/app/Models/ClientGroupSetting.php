<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGroupSetting extends Model
{
    use HasFactory;

    protected $fillable = ['client_group_id', 'symbol', 'spread', 'lots', 'leverage', 'level'];

    public function group() {
        return $this->belongsTo(ClientGroups::class);
    }

    public function symbol(){
        return $this->hasOne(CoinPair::class, 'id', 'symbol');
    }
}
