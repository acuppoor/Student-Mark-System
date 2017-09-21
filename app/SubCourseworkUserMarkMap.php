<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCourseworkUserMarkMap extends Model
{
    public function subcoursework(){
        return $this->belongsTo('App\SubCoursework');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
