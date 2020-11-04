<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'products';

    protected static $logAttributes = ['arab_name','eng_name','price','images','category_id','vendor_id','supermarket_id','subcategory_id','arab_description','eng_description','flag','status','start_date','end_date','measure_id','size_id','subcategory_id','review','eng_spec','arab_spec','rate','exp_date','points','priority','barcode'];

    protected $fillable = [
        'name_ar','name_en','price','images','category_id','vendor_id','supermarket_id','branch_id','subcategory_id','arab_description','eng_description','flag','status','start_date','end_date','measure_id','size_id','subcategory_id','review','eng_spec','arab_spec','rate','exp_date','points','priority','barcode','created_by','updated_by'
    ];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
    public function vendor() {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function supermarket() {
        return $this->belongsTo('App\Models\Supermarket');
    }

    public function subcategory() {
        return $this->belongsTo('App\Models\SubCategory');
    }

    public function measure() {
        return $this->belongsTo('App\Models\Measures');
    }

    public function size() {
        return $this->belongsTo('App\Models\Size');
    }

    public function clients() {
        return $this->belongsToMany('App\Models\Client');
    }

    public function orders() {
        return $this->belongsToMany('App\Models\Order');
    }

    public function branch() {
        return $this->belongsTo('App\Models\Branch');
    }

}
