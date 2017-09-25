<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubminimumColumnMap extends Model
{
    public function subminimum(){
        return $this->belongsTo('App\Subminimum');
    }

    public function coursework(){
        return $this->hasOne('App\Coursework');
    }

    public function subcoursework(){
        return $this->hasOne('App\SubCoursework');
    }
}
