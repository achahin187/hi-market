<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Offer extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'arab_description','eng_description','promocode','status','end_date','start_date','value_type','created_by','updated_by'
    ];
}
