<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class NotificationMobile extends Model
{
   use LogsActivity;
    protected $table= 'notifications_mobile';
    protected $fillable = [
        'title_ar','title_en','body_en','body_ar','type','client_id','body_en','order_id','product_id','supermarket_id'
    ];

}
