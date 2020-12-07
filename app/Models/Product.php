<?php

namespace App\Models;

use App\Pipeline\CreatedAt;
use App\Pipeline\MostPopular;
use App\Pipeline\Price;
use App\Pipeline\Vendor;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    //
    use LogsActivity,HasFilter;
    protected $queryFilters= [
        CreatedAt::class,
        Vendor::class,
        MostPopular::class,
        Price::class
    ];

    protected static $logName = 'products';
    protected $table = 'product';

    // protected static $logAttributes = ['arab_name','eng_name','price','offer_price','images','category_id','vendor_id','supermarket_id','subcategory_id','arab_description','eng_description','flag','status','start_date','end_date','measure_id','size_id','subcategory_id','ratings','eng_spec','arab_spec','rate','exp_date','points','priority','barcode','production_date'];
    
    protected static $logAttributes = ['name_ar','name_en','price','offer_price','images','category_id','vendor_id','supermarket_id','subcategory_id','arab_description','eng_description','flag','status','start_date','end_date','measure_id','size_id','subcategory_id','ratings','eng_spec','arab_spec','rate','exp_date','points','priority','barcode','production_date'];

    protected $fillable = [
        'name_ar','name_en',"views",'price','offer_price','rate','images','category_id','vendor_id','supermarket_id','branch_id','subcategory_id','arab_description','eng_description','flag','status','start_date','end_date','measure_id','size_id','subcategory_id','ratings','eng_spec','arab_spec','exp_date','production_date','points','priority','barcode','created_by','updated_by'
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

    // public function branch() {
    //     return $this->belongsTo('App\Models\Branch');
    // }

    public function clientreviews() {
        return $this->belongsToMany('App\Models\Client','client_reviews');
    }

    public function branches() {
        return $this->belongsToMany('App\Models\Branch','product_supermarket');
    }

 

    protected function getNameAttribute()
    {

        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
    protected function getDescriptionAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_description : $this->arab_description;
    }

    protected function getSpecsAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_spec : $this->arab_spec;
    }

}
