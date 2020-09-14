<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //

    protected $fillable = [
        'arab_name','eng_name','image','category_id','sponsor','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
}
