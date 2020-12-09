<?php

namespace App;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ["user_id","product_id","qty"];
    public function product()
    {
        return $this->belongsTo( Product::class);
    }
    public function client()
    {
        return $this->hasMany(Client::class,"user_id");
    }
}
