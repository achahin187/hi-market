<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Supermarket extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'supermarkets';

    protected static $logAttributes = ['arab_name','eng_name','status','commission','priority','image'];

    protected $fillable = [
        'arab_name','eng_name','status','commission','priority','image','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function offers() {
        return $this->hasMany('App\Models\Offer');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\Category');
    }

}
