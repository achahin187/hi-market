<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Coverage_area extends Model
{
    //
    use LogsActivity;

    protected $table = 'coverage_areas';


    protected static $logName = 'area';

    protected static $logAttributes = ['lat','long','status'];

    protected $fillable = [
        'lat','long','status','created_by','updated_by'
    ];
}
