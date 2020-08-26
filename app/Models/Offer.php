<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'type','description','promo_code','promo_code_type','status','end_date','start_date','mode','value'
    ];
}
