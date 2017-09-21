<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursework extends Model
{
    public function subcourseworks(){
        return $this->hasMany('App\SubCoursework');
    }

    public function course(){
        return $this->belongsTo('App\Course');
    }


    /*
    public function courseworkType(){
        return $this->hasOne('CourseworkType');
    }*/
}
