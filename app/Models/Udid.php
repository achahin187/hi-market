<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Udid extends Model
{
    public $timestamps = false;
    protected $fillable = ["body","client_id"];
}
