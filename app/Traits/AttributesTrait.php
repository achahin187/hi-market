<?php


namespace App\Traits;


trait AttributesTrait
{
    public function getNameAttribute()
    {
        return getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
    public function getDescriptionAttribute()
    {
        return getLocale() == "en" ? $this->desc_en : $this->desc_ar;
    }
}
