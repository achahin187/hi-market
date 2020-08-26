<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav_vendor extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'user_id','vendor_id'
    ];
}
