<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Branch extends Model
{
    //

    use LogsActivity;

    protected static $logName = 'supermarket branches';

    protected static $logAttributes = ['name_ar','name_en','status','image','supermarket_id'];

    protected $fillable = [
        'name_en','name_ar','status','image','supermarket_id','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function supermarket() {
        return $this->belongsTo('App\Models\Supermarket');
    }

    public function offers() {
        return $this->hasMany('App\Models\Offer');
    }
}
