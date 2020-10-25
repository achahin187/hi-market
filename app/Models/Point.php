<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Point extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'points';

    protected static $logAttributes = ['from','to','type','value','status','end_date','start_date'];

    protected $fillable = [
        'from','to','type','value','status','end_date','start_date','created_by','updated_by'
    ];
}
