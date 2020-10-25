<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Area extends Model
{
    //

    use LogsActivity;


    protected static $logName = 'area';

    protected static $logAttributes = ['ltn','lan'];

    protected $fillable = [
        'ltn','lan','created_by','updated_by'
    ];
}
