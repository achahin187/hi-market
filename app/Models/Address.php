<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'address';

    protected static $logAttributes = ['description','client_id'];

    protected $fillable = [
        'description','client_id','created_by','updated_by'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
