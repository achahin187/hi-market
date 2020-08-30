<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'cart_description','address','user_id','status','order_price'
    ];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity','price');
    }
}
