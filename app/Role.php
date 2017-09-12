<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function UserRoleMap(){
        return $this->hasMany("App\UserRoleMap");
    }
}
