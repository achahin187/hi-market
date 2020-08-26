<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav_category extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'user_id','category_id'
    ];
}
