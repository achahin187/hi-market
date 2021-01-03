<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   	protected function getTitleAttribute()
    {

        return app()->getLocale() == "en" ? $this->title_en : $this->title_ar;
    }
}
