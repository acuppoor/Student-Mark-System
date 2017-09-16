<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function subCoursework(){
        return $this->belongsTo('SubCoursework');
    }
}
