<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subminimum extends Model
{
    public function course(){
        return $this->belongsTo('Course');
    }

    public function subminimumRows(){
        return $this->hasMany('SubminimumColumnMap');
    }
}
