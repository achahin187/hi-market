<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Branch extends Model
{
    //

    use LogsActivity;

    protected static $logName = 'supermarket branches';

    protected static $logAttributes = ['name_ar', 'name_en', 'status', 'image', 'supermarket_id'];

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_supermarket');
    }


    public function locations()
    {
        return $this->hasMany('App\Models\BranchLocation');
    }
    

    public function supermarket()
    {
        return $this->belongsTo('App\Models\Supermarket');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_supermarket', "branch_id");
    }

    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'product_supermarket');
    }


    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
}
