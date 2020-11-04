<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Area extends Model
{
    //

    use LogsActivity;


    protected static $logName = 'area';

    protected static $logAttributes = ['name_ar','name_en','city','country','status'];

    protected $fillable = [
        'name_ar','name_en','city','country','status','created_by','updated_by'
    ];


    public function areacountry() {
        return $this->belongsTo('App\Models\Country','country');
    }


    public function areacity() {
        return $this->belongsTo('App\Models\City','city');
    }

    public function supermarkets() {
        return $this->hasMany('App\Models\Supermarket');
    }
}
