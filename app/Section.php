<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function subCoursework(){
        return $this->belongsTo('App\SubCoursework', 'subcoursework_id', 'id');
    }

    public function userMarkMap(){
        return $this->hasMany('App\SectionUserMarkMap');
    }
}
