<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Size extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'value','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
