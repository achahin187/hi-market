<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];

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
