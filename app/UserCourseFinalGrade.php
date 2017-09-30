<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCourseFinalGrade extends Model
{
    public function type(){
        return $this->hasOne('App\FinalGradeType');
    }

    public function course(){
        return $this->hasOne('App\Course');
    }

    public function user(){
        return $this->hasOne('App\User');
    }
}
