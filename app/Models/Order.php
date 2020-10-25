<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{

    use LogsActivity;

    protected static $logName = 'order';

    protected static $logAttributes = ['review_status','client_review','mobile_delivery','address','client_id','status','order_date','delivery_date','delivery_rate','order_price','request','approved_at','prepared_at','shipping_at','shipped_at','rejected_at','received_at','cancelled_at','driver_id','admin_cancellation','reason_id','notes',];

    protected $fillable = [
            'review_status','client_review','mobile_delivery','address','client_id','status','order_date','delivery_date','delivery_rate','order_price','request','approved_at','prepared_at','shipping_at','shipped_at','rejected_at','received_at','cancelled_at','driver_id','admin_cancellation','reason_id','notes','created_by','updated_by'
    ];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity','price');
    }
}
