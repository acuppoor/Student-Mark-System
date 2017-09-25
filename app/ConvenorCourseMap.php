<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConvenorCourseMap extends Model
{
    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
