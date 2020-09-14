<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable = [
        'arab_name','eng_name','created_by','updated_by'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }
}
