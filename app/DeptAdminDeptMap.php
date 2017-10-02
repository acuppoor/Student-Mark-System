<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeptAdminDeptMap extends Model
{
    public function admin(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function department(){
        return $this->hasOne('App\Department', 'id', 'department_id');
    }
}
