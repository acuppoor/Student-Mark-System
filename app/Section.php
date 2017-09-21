<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function subCoursework(){
        return $this->belongsTo('App\SubCoursework');
    }

    public function userMarkMap(){
        return $this->hasOne('App\SectionUserMarkMap');
    }
}
