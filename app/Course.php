<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function courseType(){
        return $this->hasOne('CourseType');
    }
    public function department(){
        return $this->belongsTo('Department');
    }

    public function courseworks(){
        return $this->hasMany('Coursework');
    }
}
