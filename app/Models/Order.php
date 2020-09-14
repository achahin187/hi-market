<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
            'address','client_id','status','rate','delivery_number','order_price','request','approved_at','prepared_at','shipping_at','shipped_at','admin_cancellation','cancelled_at','reason_id','notes','created_by','updated_by'
    ];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity','price');
    }
}
