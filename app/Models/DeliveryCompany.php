<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCompany extends Model
{
    protected $fillable = ["commission", "name_ar", "name_en", "status", "email", "phone_number",'city_id'];
    protected $casts = [
        'phone_number' => 'array'
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
    public function branches()
    {
        return $this->belongsToMany(Branch::class,"delivery_companies_branches");
    }
}
