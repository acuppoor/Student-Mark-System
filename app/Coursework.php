<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursework extends Model
{
    public function course(){
        return $this->belongsTo('Course');
    }

    public function subCourseworks(){
        return $this->hasMany('SubCoursework');
    }

    public function courseworkType(){
        return $this->hasOne('CourseworkType');
    }
}
