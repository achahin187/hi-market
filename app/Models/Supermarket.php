<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Supermarket extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'supermarkets';

    protected static $logAttributes = ['arab_name','eng_name','status','commission','priority','image'];

    protected $fillable = [
        'arab_name','eng_name','status','commission','priority','image','logo_image','area_id','city_id','country_id','start_time','end_time','state','created_by','updated_by'
    ];



    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function Barcode()
    {
       return $this->hasOne('App\Models\Barcode'); 
    }

    public function offers() {
        return $this->hasMany('App\Models\Offer');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\Category');
    }

    public function branches() {
        return $this->belongsToMany('App\Models\Branch');
    }

    public function area() {
        return $this->belongsTo('App\Models\Area');
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }

    public function country() {
        return $this->belongsTo('App\Models\Country');
    }

    public function user() {
        return $this->belongsTo('App\User','created_by','id');
    }



    public function scopeSelection($query)
    {
        return $query->select('arab_name','eng_name','commission','start_time','end_time','state');
    }
    protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_name : $this->arab_name;
    }
}
