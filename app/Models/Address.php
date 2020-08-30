<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'description','client_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
