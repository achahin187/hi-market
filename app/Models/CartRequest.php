<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartRequest extends Model
{
    //

    protected $fillable = [
        'cart_description','address','client_id'
    ];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity','price');
    }
}
