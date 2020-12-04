<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    //
    use LogsActivity;


    protected static $logName = 'city';

    protected static $logAttributes = ['name_ar','name_en','country','status'];

    protected $fillable = [
        'name_ar','name_en','country','status','created_by','updated_by'
    ];

    public function citycountry() {
        return $this->belongsTo('App\Models\Country','country');
    }

    public function supermarkets() {
        return $this->hasMany('App\Models\Supermarket');
    }
    protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
}
