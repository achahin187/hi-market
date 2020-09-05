<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'from','to','type','value'
    ];
}
