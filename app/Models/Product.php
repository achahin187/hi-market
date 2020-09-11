<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'arab_name','eng_name','price','images','category_id','vendor_id','supermarket_id','arab_description','eng_description','flag','status','start_date','end_date'
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

    public function clients() {
        return $this->belongsToMany('App\Models\Client');
    }

    public function orders() {
        return $this->belongsToMany('App\Models\Order');
    }

}
