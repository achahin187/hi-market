<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CartRequest extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'cart_description','address','client_id','converted','created_by','updated_by'
    ];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

}
