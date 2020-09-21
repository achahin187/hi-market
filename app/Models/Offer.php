<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Offer extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'type','description','promo_code','promo_code_type','status','end_date','start_date','mode','value','created_by','updated_by'
    ];
}
