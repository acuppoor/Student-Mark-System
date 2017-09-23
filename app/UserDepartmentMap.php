<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDepartmentMap extends Model
{
    public function user(){
        return $this->hasOne('App\User');
    }

    public function department(){
        return $this->hasOne('App\Department', 'id', 'department_id');
    }
}
