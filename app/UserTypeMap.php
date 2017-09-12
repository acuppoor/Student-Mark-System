<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTypeMap extends Model
{
    protected $table = 'user_type_map';

    protected $fillable = [
        'user_id', 'type_id'
    ];
}
