<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subminimum extends Model
{
    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function subminimumRows(){
        return $this->hasMany('App\SubminimumColumnMap');
    }
}
