<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    //
    use LogsActivity;

    protected $table = 'addresses';

    protected static $logName = 'address';

    protected static $logAttributes = ['description','client_id'];

    protected $guarded = []; 


    
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
