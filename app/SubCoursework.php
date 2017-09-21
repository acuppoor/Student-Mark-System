<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCoursework extends Model
{
    public function coursework(){
        return $this->belongsTo('Coursework');
    }

    public function sections(){
        return $this->hasMany('Section');
    }
}
