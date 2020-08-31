<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'tax','tax_on_product','delivery'
    ];
}
