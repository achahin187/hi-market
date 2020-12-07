<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'category';

    protected static $logAttributes = ['image', 'name_ar', 'name_en',];

    protected $fillable = [
        'image', 'name_ar', 'name_en', 'created_by', 'updated_by'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function vendors()
    {
        return $this->hasMany('App\Models\Vendor');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Models\Subcategory');
    }

    public function supermarkets()
    {
        return $this->belongsToMany('App\Models\Supermarket');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
}
