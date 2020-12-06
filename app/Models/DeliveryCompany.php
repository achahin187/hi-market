<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCompany extends Model
{
    protected $fillable = ["commission","name_ar","name_en","status","email","branch_id","phone_number"];
}
