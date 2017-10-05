<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function courseworks(){
        return $this->hasMany('App\Coursework');
    }

    public function type(){
        return $this->hasOne('App\CourseType', 'id', 'type_id');
    }

    public function department(){
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function students(){
        return $this->hasMany('App\UserCourseMap');
    }

    public function teachingAssistants(){
        return $this->hasMany('App\TACourseMap');
    }

    public function lecturer(){
        return $this->hasMany('App\LecturerCourseMap');
    }

    public function convenors(){
        return $this->hasMany('App\ConvenorCourseMap');
    }

    public function subminimums(){
        return $this->hasMany('App\Subminimum');
    }

    public function finalGrades(){
        return $this->hasMany('App\UserCourseFinalGrade');
    }
}
