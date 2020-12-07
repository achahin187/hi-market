<?php

namespace App;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ["user_id","product_id","qty"];
    public function products()
    {
        return $this->hasOne(Product::class);
    }
    public function client()
    {
        return $this->hasMany(Client::class,"user_id");
    }
}
