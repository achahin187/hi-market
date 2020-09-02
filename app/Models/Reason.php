<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
        'arab_reason','eng_reason','status'
    ];
}
