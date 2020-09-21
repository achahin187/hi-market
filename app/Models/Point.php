<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Point extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'from','to','type','value','status','end_date','start_date','created_by','updated_by'
    ];
}
