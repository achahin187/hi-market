<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Reason extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'reason';

    protected static $logAttributes = ['arab_reason','eng_reason','status',];

    protected $fillable = [
        'arab_reason','eng_reason','status','created_by','updated_by'
    ];
}
