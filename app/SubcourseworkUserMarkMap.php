<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubcourseworkUserMarkMap extends Model
{
    public function subcoursework(){
        return $this->belongsTo('SubCoursework');
    }

    public function user(){
        return $this->belongsTo('User');
    }
}
