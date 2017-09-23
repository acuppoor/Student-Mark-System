<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConvenorCourseMap extends Model
{
    public function course(){
        return $this->belongsTo('App\Course');
    }
}
