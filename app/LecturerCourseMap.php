<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LecturerCourseMap extends Model
{
    public function lecturer(){
        return $this->hasOne('App\User');
    }

    public function course(){
        return $this->hasOne('App\Course', 'id', 'course_id');
    }
}
