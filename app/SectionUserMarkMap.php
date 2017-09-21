<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionUserMarkMap extends Model
{
    public function section(){
        return $this->belongsTo('Section');
    }

    public function user(){
        return $this->belongsTo('User');
    }
}
