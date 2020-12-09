<?php


namespace App\Pipeline;


class Vendor extends Filter
{
    protected function canRunRequest()
    {
        return !request($this->filterRequest()) ;
    }

    protected function query($builder)
    {
        return $builder->whereHas("vendor", function ($query) {
            $query->orderBy(app()->getLocale() == "en" ? "eng_name" : "arab_name",request("order","asc"));
        });
    }
}
