<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
        'user_id','product_id'
    ];
}
