<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //

    protected $fillable = [
        'description','client_id','created_by','updated_by'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
