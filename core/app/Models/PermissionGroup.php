<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
  use HasFactory;

  public function permissions()
  {
    return collect(json_decode($this->permission, true));
  }
}
