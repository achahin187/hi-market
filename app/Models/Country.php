<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    //

    use LogsActivity;


    protected static $logName = 'country';

    protected static $logAttributes = ['name_ar','name_en','status','numcode','phonecode','phonelength'];

    protected $fillable = [
        'name_ar','name_en','status','numcode','phonecode','phonelength','created_by','updated_by'
    ];

    public function supermarkets() {
        return $this->hasMany('App\Models\Supermarket');
    }
}
