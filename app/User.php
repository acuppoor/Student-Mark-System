<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'studentNumber', 'employeeID', 'email', 'password', 'approve', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->hasOne('App\Role');
    }

    public function subCourseworkMarks(){
        return $this->hasMany('App\SubCourseworkUserMarkMap', 'user_id', 'id');
    }

    public function courseMaps(){
        return $this->hasMany('App\UserCourseMap');
    }

    public function courseTAMaps(){
        return $this->hasMany('App\TACourseMap');
    }

    public function lecturerCourseMaps(){
        return $this->hasMany('App\LecturerCourseMap');
    }

    public function convenorCourseMaps(){
        return $this->hasMany('App\ConvenorCourseMap');
    }

    public function departmentMaps(){
        return $this->hasMany('App\UserDepartmentMap')  ;
    }

    public function departmentAdminMap(){
        return $this->hasOne('App\DeptAdminDeptMap', 'user_id', 'id');
    }
}
