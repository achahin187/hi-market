<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Vendor extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'vendors';

    protected static $logAttributes = ['arab_name','eng_name','image','category_id','subcategory_id','sponsor'];

    protected $fillable = [
        'arab_name','eng_name','image','category_id','subcategory_id','sponsor','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\Category','category_vendor');
    }

    // public function subcategory() {
    //     return $this->belongsTo('App\Models\SubCategory');
    // }


}
