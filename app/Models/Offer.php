<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Offer extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'offer';

    protected static $logAttributes = ['arab_name','eng_name','arab_description','eng_description','offer_type','promocode','status','end_date','start_date','value_type','supermarket_id','branch_id'];

    protected $fillable = [
        'arab_name','eng_name','arab_description','eng_description','offer_type','promocode','status','end_date','start_date','value_type','supermarket_id','branch_id','image','created_by','updated_by'
    ];

    public function scopeCheckPromoCode($q, $promoCode)
    {
        return $q->Where('promocode', $promoCode);
    }

    public function scopeCheckSuperMarket($q, $supermarket_id)
    {
        return $q->Where('supermarket_id', $supermarket_id);
    }

    public function supermarket() {
        return $this->belongsTo('App\Models\Supermarket');
    }

    public function branch() {
        return $this->belongsTo('App\Models\Branch');
    }

}
