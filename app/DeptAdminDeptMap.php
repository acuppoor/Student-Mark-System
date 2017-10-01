<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeptAdminDeptMap extends Model
{
    public function admin(){
        return $this->hasOne('App\User');
    }

    public function department(){
        return $this->hasOne('App\Department');
    }
}
