<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Measures extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'measuring point';

    protected static $logAttributes = ['arab_name','eng_name',];

    protected $fillable = [
        'arab_name','eng_name','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
