<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $guarded = [];


    #relations
    public function barcode()
    {
       return $this->belogngsTo('App\Models\Supermarket'); 
    }

}
