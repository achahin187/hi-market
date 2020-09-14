<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //

    protected $fillable = [
        'type','description','promo_code','promo_code_type','status','end_date','start_date','mode','value','created_by','updated_by'
    ];
}
