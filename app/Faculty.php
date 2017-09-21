<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public function departments(){
        return $this->hasMany('Department');
    }
}
