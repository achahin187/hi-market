<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];


    public function scopeCheckPromoCode($q, $promoCode)
    {
        
        return $q->Where('promocode_name', $promoCode);
    }

    public function scopeCheckSuperMarket($q, $supermarket_id)
    {

        return $q->Where('branch_id', $supermarket_id);
    }

    public function supermarket()
    {
    	return $this->belongsTo('App\Models\Supermarket') ;
    }

    public function branches()
    {
    	return $this->hasMany('App\Models\Branch');
    }

    public function product()
    {
    	return $this->belongsTo('App\Models\Product');
    }
}
