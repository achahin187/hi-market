<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //

    protected $fillable = [
        'from','to','type','value','created_by','updated_by'
    ];
}
