<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'ltn','lan'
    ];
}
