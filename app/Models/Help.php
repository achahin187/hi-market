<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $guarded = [];

    public function getTitleAttribute()
    {
    	return app()->getLocale() == "en" ? $this->title_en : $this->title_ar;
    }

    protected function getDescriptionAttribute()
    {
        return app()->getLocale() == "en" ? $this->description_en : $this->description_ar;
    }

}
