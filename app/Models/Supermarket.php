<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supermarket extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
        'arab_name','eng_name','image'
    ];
}
