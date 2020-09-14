<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //

    protected $fillable = [
        'tax','tax_on_product','delivery','tax_value','cancellation','splash','created_by','updated_by'
    ];
}
