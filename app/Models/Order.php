<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
            'address','client_id','status','order_price','tax','delivery','total_price'
    ];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity','price');
    }
}
