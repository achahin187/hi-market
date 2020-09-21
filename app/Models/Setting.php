<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'tax','tax_on_product','delivery','tax_value','cancellation','splash','created_by','updated_by'
    ];
}
