<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'title','body','icon','flag','model_id','created_by','updated_by'
    ];

}
