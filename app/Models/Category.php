<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'category';

    protected static $logAttributes = ['image','arab_name','eng_name',];

    protected $fillable = [
        'image','arab_name','eng_name','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function vendors() {
        return $this->hasMany('App\Models\Vendor');
    }

    public function subcategories() {
        return $this->hasMany('App\Models\Subcategory');
    }

    public function supermarkets() {
        return $this->belongsToMany('App\Models\Supermarket');
    }
}
