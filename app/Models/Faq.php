<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Faq extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'question','answer','created_by','updated_by'
    ];
}
