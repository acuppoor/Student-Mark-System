<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinalGradeType extends Model
{
    public function grade(){
        return $this->hasMany('App\UserCourseFinalGrade');
    }
}
