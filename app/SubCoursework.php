<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCoursework extends Model
{
    public function coursework(){
        return $this->belongsTo('App\Coursework');
    }

    public function sections(){
        return $this->hasMany('App\Section', 'subcoursework_id');
    }

    public function userMarkMap(){
        return $this->hasOne('App\SubCourseworkUserMarkMap', 'subcoursework_id', 'id');
    }
}
