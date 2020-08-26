<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav_product extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'user_id','product_id'
    ];
}
